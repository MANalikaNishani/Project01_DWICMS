<?php include 'index.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <style>
    .container {
      margin: 2% auto;
      width: 40%;
      background-color: rgba(46, 139, 87, 0.40);
      padding: 30px;
      border-radius: 4px;
      box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
      font-family: 'Times New Roman', Times, serif;
      font-size: 14;
    }


    /* The Modal (background) */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      padding-top: 100px;
      /* Location of the box */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
      position: relative;
      background-color: #5cb85c;
      margin: auto;
      padding: 0;
      border: 1px solid #888;
      width: 30%;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      -webkit-animation-name: animatetop;
      -webkit-animation-duration: 0.4s;
      animation-name: animatetop;
      animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
      from {
        top: -300px;
        opacity: 0
      }

      to {
        top: 0;
        opacity: 1
      }
    }

    @keyframes animatetop {
      from {
        top: -300px;
        opacity: 0
      }

      to {
        top: 0;
        opacity: 1
      }
    }

    /* The Close Button */
    .close {
      color: black;
      float: right;
      font-size: 30px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-header {
      padding: 2px 16px;
      background-color: #5cb85c;
      color: white;
    }

    .modal-body {
      padding: 2px 16px;
    }

    .modal-footer {
      padding: 2px 16px;
      background-color: #5cb85c;
      color: white;
    }

    .login-form-field {
      border: none;
      border-bottom: 1px solid #3a3a3a;
      margin-bottom: 10px;
      border-radius: 3px;
      outline: none;
      background-color: rgba(46, 139, 87, 0.0);
      padding: 0px 0px 10px 10px;
    }

    input[type="submit"] {
      background-color: #41c71f;
      border: 2px solid #13b821;
      color: rgb(255, 255, 255);
      width: 130px;
      height: 37px;
    }
  </style>

<body>

  <?php


  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "designwork";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if the user is logged in
  if (!isset($_SESSION['profile_id'])) {
    header('Location: index.php');
  }

  // Retrieve user profile details from the database
  $profile_id = $_SESSION['profile_id'];
  $sql = "SELECT EmpNo1, FileNo, FileName, FolioNo, Letter, LetterDate, file_name, uploaded_on FROM files WHERE EmpNo1 = '$profile_id'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fileNo'])) {
      $fileNumber = $_POST['fileNo'];
      // Get the new values from the form
      $new_file_no = $_POST['FileNo'];
      $new_file_name = $_POST['FileName'];
      $new_folio_no = $_POST['FolioNo'];
      $new_letter = $_POST['Letter'];

      // Update the file details in the database for the selected file number
      $update_sql = "UPDATE files SET FileNo='$new_file_no', FileName='$new_file_name', FolioNo='$new_folio_no', Letter='$new_letter' WHERE EmpNo1='$profile_id' AND FileNo='$fileNumber'";
      if ($conn->query($update_sql) === TRUE) {
        echo '
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                            <h2>Success</h2>
                        </div>
                        <div class="modal-body">
                            <p>File details updated successfully.</p>
                        </div>
                    </div>
                </div>
                <script>
                    // Display the success message modal
                    var modal = document.getElementById("myModal");
                    modal.style.display = "block";
                    // Close the modal when the close button is clicked
                    var closeBtn = document.getElementsByClassName("close")[0];
                    closeBtn.onclick = function() {
                        modal.style.display = "none";
                    }
                </script>
            ';
        exit();
      } else {
        echo "Error updating record: " . $conn->error;
      }
    }

    // Get the selected file number from the query string
    if (isset($_GET['fileNo'])) {
      $fileNumber = $_GET['fileNo'];

      // Fetch the details of the selected file
      $file_sql = "SELECT FileNo, FileName, FolioNo, Letter FROM files WHERE EmpNo1 = '$profile_id' AND FileNo = '$fileNumber'";
      $file_result = $conn->query($file_sql);

      if ($file_result && $file_result->num_rows > 0) {
        $file_row = $file_result->fetch_assoc();

        echo '
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h2 class="m-0 font-weight-bold text-primary">Update File Details</h2>
                                            <hr>
                                        </div>
                                        <div class="card-body">
                                            <form class="user" method="POST" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="FileNo">File No:</label>
                                                    <input type="text" name="FileNo" id="FileNo" class="login-form-field" placeholder="File No" value="' . $file_row['FileNo'] . '">
                                                </div>
                                                <div class="form-group">
                                                    <label for="FileName">File Name:</label>
                                                    <input type="text" name="FileName" id="FileName" class="login-form-field" placeholder="File Name" value="' . $file_row['FileName'] . '">
                                                </div>
                                                <div class="form-group">
                                                    <label for="FolioNo">Folio No:</label>
                                                    <input type="text" name="FolioNo" id="FolioNo" class="login-form-field" placeholder="Folio No" value="' . $file_row['FolioNo'] . '">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Letter">Letter:</label>
                                                    <input type="text" name="Letter" id="Letter" class="login-form-field" placeholder="Letter" value="' . $file_row['Letter'] . '">
                                                </div>
                                                <input type="hidden" name="fileNo" value="' . $file_row['FileNo'] . '">
                                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Update Details">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
      } else {
        echo "No file found.";
      }
    } else {
      echo "No file selected.";
    }
  } else {
    echo "No file found.";
  }

  $conn->close();
  ?>


</body>

</html>