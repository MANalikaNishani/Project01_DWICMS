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

if (isset($_POST['Submit'])) {
  // Get form data
  $EmpNo = $_POST['EmpNo'];
  $FName = $_POST['FirstName'];
  $LName = $_POST['LastName'];
  $Email = $_POST['Email'];
  $Designation = $_POST['Designation'];
  $Password = $_POST['Password'];
  $Telephone = $_POST['Telephone'];
  $Address = $_POST['Address'];
  $Birthday = $_POST['Birthday'];
  $Gender = $_POST['Gender'];

  // Check if email is already registered
  $ret = mysqli_query($conn, "SELECT Email FROM userlogin WHERE Email='$Email'");
  $result = mysqli_fetch_array($ret);
  if ($result > 0) {
    $msg = "This email is already associated with another account";
  } else {
    // Check if EmpNo is already registered
    $ret = mysqli_query($conn, "SELECT EmpNo FROM userlogin WHERE EmpNo='$EmpNo'");
    $result = mysqli_fetch_array($ret);
    if ($result > 0) {
      $msg = "This EmpNo is already associated with another account";
    } else {
      // Handle file upload
      if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/"; // directory to store uploaded images
        $target_file = $target_dir . basename($_FILES['profile_pic']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowed_types)) {
          if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
            $profile_pic = $target_file;
          } else {
            $msg = "Error uploading file";
          }
        } else {
          $msg = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed";
        }
      }
      /// Add the profile picture to the database
      if (!isset($msg)) {
        $query = mysqli_query($conn, "INSERT INTO userlogin (EmpNo, FName, LName, Email, Designation, Password, Telephone, Address, Birthday, Gender, profile_pic) VALUES ('$EmpNo','$FName', '$LName', '$Email', '$Designation', '$Password', '$Telephone', '$Address', '$Birthday', '$Gender', '$profile_pic')");
        if ($query) {
          $msgs = "You have successfully registered";
        } else {
          $msg = "Something went wrong. Please try again";
        }
      }
    }
  }
}

// Check if a file was uploaded
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
  // Get the file name and size
  $file_name = $_FILES['profile_pic']['name'];
  $file_size = $_FILES['profile_pic']['size'];

  // Check if the file size is within the limit (in bytes)
  $file_limit = 1024 * 1024 * 2; // 2 MB
  if ($file_size > $file_limit) {
    $msg = "File size is too large. Please upload a file smaller than 2 MB.";
  } else {
    // Generate a unique file name
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name_new = uniqid('profile_', true) . '.' . $file_ext;

    // Upload the file to a directory on your server
    $file_dest = 'uploads/' . $file_name_new;
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file_dest)) {
      // File was uploaded successfully
      $profile_pic = $file_name_new;
    } else {
      // Error uploading file
      $msg = "Error uploading profile picture. Please try again.";
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


  <title>Login Form</title>

  <style>
    body {
      background-color: #FFF;
      font-family: Arial, sans-serif;
      background-image: url("c.png");
      /* Replace "path/to/image.jpg" with the path to your image file */
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .container {
      margin: 1% auto;
      width: 400px;
      background-color: #8FBC8F;
      padding: 30px;
      border-radius: 1px;
      box-shadow: 20px 20px 0px 0px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      font-size: 32px;
      color: #333;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="password"] {
      padding: 10px;
      width: 100%;
      border-radius: 3px;
      border: none;
      margin-bottom: 20px;
      box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2);
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 3px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #3e8e41;
    }

    p {
      font-size: 14px;
      color: #333;
      text-align: center;
      margin-top: 20px;
    }

    a {
      color: #fff;
      text-decoration: none;
      margin-left: 5px;
    }
  </style>

  <script>
    function checkpass() {
      if (document.register.Password.value !== document.register.RepeatPassword.value) {
        alert('New Password and Confirm Password field does not match');
        document.register.RepeatPassword.focus();
        return false;
      }
      return true;
    }
    function validateMinLength() {
      var password = document.register.Password.value;
      if (password.length < 8) {
        alert('Password should be at least 8 characters long');
        document.register.Password.focus();
        return false;
      }
      return true;
    }

  </script>
</head>


<body class="">


  <div class="container">
    <p style="font-size:16px; color:green" align="center">

      <?php
      // $msgs = "You have successfully registered";
      if (isset($msgs)) {
        echo $msgs;
      } ?>
    </p>

    <p style="font-size:16px; color:red" align="center">
      <?php
      // $msg = "Something went wrong. Please try again";
      if (isset($msg)) {
        echo $msg;
      } ?>
    </p>


    <!-- Sign Up frame -->
    <form class="user" name="register" method="post" onsubmit="return checkpass();" action=""
      enctype="multipart/form-data">

      <font face="Imprint MT Shadow" size="6">Sign Up</font>
      </h1>
      <hr>
      <font face="Imprint MT Shadow">
        <div class="col-sm-6 mb-3 mb-sm-0">
          <input type="text" class="form-control form-control-user" id="EmpNo" name="EmpNo" placeholder="EmpNo"
            required="true">
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
          <input type="text" class="form-control form-control-user" id="FName" name="FirstName" placeholder="First Name"
            pattern="[A-Za-z]+" required="true">
        </div>
        <div class="col-sm-6">
          <input type="text" class="form-control form-control-user" id="LName" name="LastName" placeholder="Last Name"
            pattern="[A-Za-z]+" required="true">
        </div>
        <div class="form-group">
          <input type="text" class="form-control form-control-user" id="Email" name="Email" placeholder="Email Address"
            required="true">
        </div>
        <div class="form-group">
          <input type="text" class="form-control form-control-user" id="Designation" name="Designation"
            placeholder="Designation" required="true">
        </div>
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="password" class="form-control form-control-user" id="Password" name="Password"
              placeholder="Password" required="true">
          </div>
          <div class="col-sm-6">
            <input type="password" class="form-control form-control-user" id="RepeatPassword" name="RepeatPassword"
              placeholder="Repeat Password" required="true">
          </div>
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
          <input type="text" class="form-control form-control-user" id="Telephone" name="Telephone"
            placeholder="Telephone" required="true">
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
          <input type="text" class="form-control form-control-user" id="Address" name="Address" placeholder="Address"
            required="true">
        </div>

        <label for="birthday">Birthday:</label>
        <input type="date" id="Birthday" name="Birthday">
        <br>
        <br>

        <fieldset data-role="controlgroup">
          <legend>Choose your gender:</legend>
          <label for="male">Male</label>
          <input type="radio" name="Gender" id="Male" value="male" checked>
          <label for="female">Female</label>
          <input type="radio" name="Gender" id="Female" value="female">
        </fieldset>

        <br>
        <br>

        <div class="form-group">
          <label for="profile_pic">Profile Picture:</label>
          <input type="file" class="form-control-file" id="profile_pic" name="profile_pic">
        </div>

        <input type="submit" name="Submit" value="Register Account" class="btn btn-primary btn-user btn-block">

        <hr>
        <div class="text-center">
          <p>
            <font size="3">Already have an account?</font><a class="small" href="userlogin.php">
              <font size="4"> Login!</font>
            </a>
          <p>
      </font>
  </div>
  </form>

</body>

</html>