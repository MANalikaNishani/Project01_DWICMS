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

//session_start();
if (isset($_SESSION['profile_id'])) {
  $profile_id = $_SESSION['profile_id'];
  $EmpNo1 = $profile_id;
  // Rest of your code
}
$msg = '';
$msgs = '';

// File upload path
// Check if the form was submitted
if (isset($_POST['submit'])) {
  $EmpNo1 = $_POST['EmpNo1'];
  $FileNo = $_POST['FileNo'];
  $FileName = $_POST['FileName'];
  $FolioNo = $_POST['FolioNo'];
  $Letter = $_POST['letter'];
  $LetterDate = $_POST['LetterDate'];
  $targetDir = "uploads/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
      // Upload file to server
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Insert image file name into database
        $query = "INSERT into files (EmpNo1, FileNo, FileName, FolioNo, letter, LetterDate, file_name, uploaded_on) VALUES ('" . $EmpNo1 . "', '" . $FileNo . "', '" . $FileName . "', '" . $FolioNo . "', '" . $Letter . "', '" . $LetterDate . "', '" . $fileName . "', NOW())";
        $insert = mysqli_query($conn, $query);
        // header('Location: fileupload.php');
        if ($insert) {
          $msg = "The file " . $fileName . " has been uploaded successfully.";
          echo "<script>showToast('$msg');</script>"; // show toast alert
        } else {
          $msgs = "File upload failed, please try again.";
          echo "<script>showToast('$msg');</script>"; // show toast alert
        }

      } else {
        $msgs = "Sorry, there was an error uploading your file.";
        echo "<script>showToast('$msg');</script>"; // show toast alert
      }
    } else {
      $msgs = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
      echo "<script>showToast('$msg');</script>"; // show toast alert
    }
  } else {
    $msgs = 'Please select a file to upload.';
    echo "<script>showToast('$msg');</script>"; // show toast alert
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
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <title>File Upload</title>
  <script>
    function showToast(msg) {
      Toastify({
        text: msg,
        duration: 3000, // 3 seconds
        gravity: "bottom", // toast position
        position: "center", // toast position
        backgroundColor: "#3f51b5", // toast background color
        stopOnFocus: true, // stop timer when the toast is clicked
        onClick: function () { } // callback function when the toast is clicked
      }).showToast();
    }
  </script>
  <style>
    .container {
      margin: 4% auto;
      width: 60%;
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
      padding: 0px 0px 5px 5px;
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

  <!-- File Upload frame -->

  <body>
    <fieldset style="width:95%">
      <legend>
        <font color="Black" size="6">File Upload Form</font>
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
                      <td><label for="EmpNo1">EmpNo:</label></td>
                      <td><input type="hidden" name="EmpNo1" value="<?php echo $profile_id; ?>" />
                        <input type="text" id="EmpNo1" class="login-form-field" value="<?php echo $profile_id; ?>"
                          disabled />
                      </td>

                      <td><label for="FileNo">FileNo:</label></td>
                      <td><input type="text" class="login-form-field" name="FileNo" placeholder="FileNo" id="FileNo"
                          required></td>
                    </tr>
                    <tr>
                      <td><label for="FileName">FileName:</label></td>
                      <td>
                        <select type="select" class="login-form-field" name="FileName" id="FileName" required>
                          <option value="General">General</option>
                          <option value="Audit Quary">Audit Quary</option>
                          <option value="Mission">Mission</option>
                          <option value="Meeting">Meeting</option>
                        </select>

                      <td><label for="FolioNo">FolioNo:</label></td>
                      <td><input type="text" class="login-form-field" name="FolioNo" placeholder="Folio" id="FolioNo"
                          required></td>
                    </tr>
                    <tr>
                      <td><label for="letter">Letter:</label></td>
                      <td><input type="text" class="login-form-field" name="letter" placeholder="letter" id="letter"
                          required></td>

                      <td><label for="LetterDate">LetterDate:</label></td>
                      <td><input type="date" class="login-form-field" name="LetterDate" placeholder="LetterDate"
                          id="LetterDate" required></td>
                    </tr>
                    <tr>
                      <td><label for="file">Choose a file to upload:</label></td>
                      <td><input type="file" class="login-form-field" name="file" placeholder="Choose a file to upload:"
                          class="fa fa-upload" id="file" required></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><input type="submit" name="submit" class="button1" value="Upload"></td>
                    </tr>
                  </table>
                </form>
    </fieldset>
</div>

</body>

</html>