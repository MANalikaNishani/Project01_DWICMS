<?php include 'index.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="path/to/toastify.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <script src="path/to/toastify.js"></script>

  <title>File Details</title>
  <style>
    table {
      font-family: Times;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    .container {
      margin: 3% auto;
      width: 80%;
      background-color: rgba(46, 139, 87, 0.40);
      padding: 30px;
      border-radius: 4px;
      box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
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
      width: 97px;
      height: 37px;

    }
  </style>
</head>

<body>
  <div class="container">
    <fieldset style="width: 100%">
      <legend>
        <font color="Black" size="6">File Details</font>
      </legend>
      <hr>
      <form method="POST" action="">
        <label for="fileNumber">File Number:</label>
        <input type="text" class="login-form-field" id="fileNumber" name="fileNumber" required>
        <input type="submit" value="Get Details">
        <td><a href='file_report.php'><i class="fas fa-print"></i>Report Generate</button></a></td>
      </form>

      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fileNumber = $_POST['fileNumber'];

        $conn = mysqli_connect("localhost", "root", "", "designwork");
        if ($conn->connect_error) {
          die("Connection Failed: " . $conn->connect_error);
        }

        $sql = "SELECT EmpNo1, FileNo, FileName, FolioNo, Letter, LetterDate, file_name, uploaded_on 
                        FROM files 
                        WHERE FileNo = '$fileNumber'"; // adjust the query to match your table structure
      
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<table>
                            <tr>
                                <th>File No</th>
                                <th>File Name</th> 
                                <th>Folio No</th>
                                <th>Letter</th>
                                <th>Letter Date</th>    
                                <th>File</th>
                                <th>Uploaded On</th>
                               
                            </tr>";
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                                <td>" . $row["FileNo"] . "</td>
                                <td>" . $row["FileName"] . "</td>
                                <td>" . $row["FolioNo"] . "</td>
                                <td>" . $row["Letter"] . "</td>
                                <td>" . $row["LetterDate"] . "</td>
                                <td><a href='uploads/" . $row["file_name"] . "'><span class='fa fa-eye text-dark'></span></a></td>
                                <td>" . $row["uploaded_on"] . "</td>
                               
                            </tr>";
          }
          echo "</table>";
        } else {
          echo "No results found for the provided file number.";
        }
        $conn->close();
      }
      ?>
    </fieldset>
  </div>


  <title>File Upload</title>
  <style>
    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }
  </style>
  </head>

  <body class="">

    <div class="container">

      <!-- File Upload frame -->

      <body>
        <fieldset style="width:100%">
          <legend>
            <font color="Black" size="6">File Details Form</font>
          </legend>
          <hr>
          <font face="Times New Roman" size="4">
            <style>
              table {
                font-family: Times;
                border-collapse: collapse;
                width: 100%;
              }

              td,
              th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
              }

              tr:nth-child(even) {
                background-color: #dddddd;
              }
            </style>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "designwork");
            if ($conn->connect_error) {
              die("Connection Failed:" . $conn->connect_error);
            }
            if (isset($_SESSION['profile_id'])) {
              $profile_id = $_SESSION['profile_id'];
            } else {
              $profile_id = "";
            }

            $sql = "SELECT EmpNo1, FileNo, FileName, FolioNo, Letter, LetterDate, file_name, uploaded_on 
                            FROM files 
                            WHERE EmpNo1 = '$profile_id'"; // add the condition to filter by user ID
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              echo "<form method='POST' action='download_files.php'>";
              echo "<table>
                                <tr>
                                    <th>Select</th>
                                    <th>File No</th>
                                    <th>File Name</th> 
                                    <th>Folio No</th>
                                    <th>Letter</th>
                                    <th>Letter Date</th>    
                                    <th>File</th>
                                    <th>Uploaded On</th>
                                    <th>Action</th>
                                </tr>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                                    <td><input type='checkbox' name='selectedFiles[]' value='" . $row['file_name'] . "'></td>
                                    <td>" . $row["FileNo"] . "</td>
                                    <td>" . $row["FileName"] . "</td>
                                    <td>" . $row["FolioNo"] . "</td>
                                    <td>" . $row["Letter"] . "</td>
                                    <td>" . $row["LetterDate"] . "</td>
                                    <td><a href='uploads/" . $row["file_name"] . "'>View</a> | <a href='uploads/" . $row["file_name"] . "' download>Download</a></td>
                                    <td>" . $row["uploaded_on"] . "</td>
                                    <td>
                                        <a href='edit_file.php?fileNo=" . $row['FileNo'] . "'><span class='fa fa-edit text-dark'></span></a> 
                                        <a href='delete_file.php?fileNo=" . $row['FileNo'] . "'><span class='fa fa-trash text-danger'></span></a>
                                    </td>
                                </tr>";
              }
              echo "</table>";
              echo "<button type='submit' name='downloadSelected' value='Download Selected'>Download Selected</button>";
              echo "</form>";

            } else {
              echo "0 results";
            }

            $conn->close();
            ?>


            <style>
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
                width: 97px;
                height: 37px;

              }
            </style>
            <div id="myModal" class="modal">

              <div class="modal-content">
                <span class="close">&times;</span>

                <div id="popupForm">

                  <div class="modal-header">
                    <h2>Update Profile Form</h2>
                    <hr>
                    <form class="user" method="POST" enctype="multipart/form-data" action="edit_file.php">
                      <div class="form-group">
                        <label for="FileNo">File No:</label>
                        <input type="text" name="FileNo" id="FileNo" class="login-form-field" placeholder="File No"
                          value="' . $row['FileNo'] . '">
                      </div>
                      <div class="form-group">
                        <label for="FileName">File Name:</label>
                        <input type="text" name="FileName" id="FileName" class="login-form-field"
                          placeholder="File Name" value="' . $row['FileName'] . '">
                      </div>
                      <div class="form-group">
                        <label for="FolioNo">Folio No:</label>
                        <input type="text" name="FolioNo" id="FolioNo" class="login-form-field" placeholder="Folio No"
                          value="' . $row['FolioNo'] . '">
                      </div>
                      <div class="form-group">
                        <label for="Letter">Letter:</label>
                        <input type="text" name="Letter" id="Letter" class="login-form-field" placeholder="Letter"
                          value="' . $row['Letter'] . '">
                      </div>

                      <input type="submit" class="btn btn-primary btn-user btn-block" value="Update Details">
                    </form>
                  </div>
                </div>

                <script>
                  // Display success message
                  function showSuccess(message) {
                    Toastify({
                      text: message,
                      duration: 3000,
                      close: true,
                      gravity: "bottom",
                      position: "right",
                      backgroundColor: "green",
                      stopOnFocus: true
                    }).showToast();
                  }

                  // Display error message
                  function showError(message) {
                    Toastify({
                      text: message,
                      duration: 3000,
                      close: true,
                      gravity: "bottom",
                      position: "right",
                      backgroundColor: "red",
                      stopOnFocus: true
                    }).showToast();
                  }

                  // Confirm delete action
                  function confirmDelete() {
                    return confirm("Are you sure you want to delete the selected files?");
                  }
                </script>

                <script>
                  // Get the modal
                  var modal = document.getElementById("myModal");

                  // Get the button that opens the modal
                  var btn = document.getElementById("myBtn");

                  // Get the <span> element that closes the modal
                  var span = document.getElementsByClassName("close")[0];

                  // When the user clicks the button, open the modal 
                  btn.onclick = function () {
                    modal.style.display = "block";
                  }

                  // When the user clicks on <span> (x), close the modal
                  span.onclick = function () {
                    modal.style.display = "none";
                  }

                  // When the user clicks anywhere outside of the modal, close it
                  window.onclick = function (event) {
                    if (event.target == modal) {
                      modal.style.display = "none";
                    }
                  }
                </script>