<?php include 'index.php' ?>

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

$id = null;



// Check if 'id' key is set in the session variable
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
} else {
  // handle the case when 'id' key is not set in the session
}

if (isset($_SESSION['profile_id'])) {
  $profile_id = $_SESSION['profile_id'];
  $EmpNo3 = $profile_id;
}

$msg = '';
$msgs = '';


// File upload path
// Check if the form was submitted
if (isset($_POST['Submit'])) {
  $EmpNo3 = $_POST['EmpNo3'];
  $WorkTitle = $_POST['WorkTitle'];
  $WorkDescription = $_POST['WorkDescription'];
  $WorkDate = $_POST['WorkDate'];
  $WorkCategory = $_POST['WorkCategory'];

  $targetDir = "uploads3/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if (isset($_POST["Submit"]) && !empty($_FILES["file"]["name"])) {
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
      // Upload file to server
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Insert image file name into database
        $query = "INSERT into works (EmpNo3, WorkTitle, WorkDescription, WorkDate, WorkCategory,  file_name, upload_on) VALUES ('" . $EmpNo3 . "', '" . $WorkTitle . "', '" . $WorkDescription . "', '" . $WorkDate . "', '" . $WorkCategory . "',   '" . $fileName . "', NOW())";
        $insert = mysqli_query($conn, $query);
        //header('Location: workupload.php');
        if ($insert) {
          $msg = "The file " . $fileName . " has been uploaded successfully.";
        } else {
          $msgs = "File upload failed, please try again.";
        }

      } else {
        $msgs = "Sorry, there was an error uploading your file.";
      }
    } else {
      $msgs = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
  } else {
    $msgs = 'Please select a file to upload.';
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="path/to/toastify.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="path/to/toastify.js"></script>


  <title>Work Upload</title>
  <style>
    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .container {
      margin: 4% auto;
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



<div class="container">


  <!-- work Upload frame -->

  <body>

    <fieldset style="width:95%">
      <legend>
        <font color="Black" size="6">Work Upload Form</font>
      </legend>

      <hr>
      <font face="Times New Roman" size="4">
        <div id="body">
          <div id="input">
            <div id="lable">

              <div class="form-frame">
                <form action="#" method="post" enctype="multipart/form-data" onsubmit="return checkpass();">

                  <p style="font-size:16px; color:blue" align="center">
                    <?php if ($msg) {
                      echo $msg;
                    } ?>
                  </p>
                  <p style="font-size:16px; color:red" align="center">
                    <?php if ($msgs) {
                      echo $msgs;
                    } ?>
                  </p>

                  <table>
                    <tr>
                      <td><label for="EmpNo3">EmpNo:</label></td>
                      <td><input type="hidden" name="EmpNo3" value="<?php echo $profile_id; ?>" />
                        <input type="text" id="EmpNo3" class="login-form-field" value="<?php echo $profile_id; ?>"
                          disabled />
                      </td>

                      <td><label for="WorkTitle">Title:</label></td>
                      <td><input type="text" id="WorkTitle" class="login-form-field" name="WorkTitle"
                          placeholder="Enter title" required></td>

                      <td><label for="WorkDescription">Description:</label></td>
                      <td><textarea id="WorkDescription" class="login-form-field" name="WorkDescription"
                          placeholder="Enter description" required></textarea></td>
                    </tr>
                    <tr>

                      <td><label for="WorkDate">Date:</label></td>
                      <td><input type="date" id="WorkDate" class="login-form-field" name="WorkDate" required></td>

                      <td><label for="WorkCategory">Category:</label></td>
                      <td>
                        <select type="text" id="WorkCategory" class="login-form-field" name="WorkCategory" required>
                          <option value="" disabled selected>--Please select--</option>
                          <option value="AIUDP - PKG - O1">AIUDP - PKG - O1</option>
                          <option value="AIUDP - PKG - O2">AIUDP - PKG - O2</option>
                          <option value="AIUDP - PKG - O3">AIUDP - PKG - O3</option>
                          <option value="AIUDP - PKG - O4">AIUDP - PKG - O4</option>
                          <option value="Writing">Writing</option>
                          <option value="Other">Other</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label for="file">File:</label></td>
                      <td><input type="file" id="file" class="login-form-field" name="file"
                          placeholder="Choose a file to upload:"></td>



                      <td><label for="file">Image:</label></td>
                      <td><input type="file" id="file" class="login-form-field" name="file"
                          placeholder="Choose a file to upload:"></td>


                    </tr>
                    <tr>
                      <td></td>
                      <td><input type="submit" name="Submit" class="button1" value="Upload"></td>
                    </tr>
                  </table>

                </form>
    </fieldset>
</div>
</body>

</html>