<?php
include "config.php";
error_reporting(0); {

  if (isset($_POST['but_submit'])) {

    $Email = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $Password = mysqli_real_escape_string($con, $_POST['txt_pwd']);

    if ($Email != "" && $Password != "") {

      // Retrieve the user's ID from the database
      $sql_query = "SELECT profile_id FROM userlogin WHERE Email='" . $Email . "' AND Password='" . $Password . "'";
      $result = mysqli_query($con, $sql_query);
      $row = mysqli_fetch_array($result);

      // If a user was found with the given email and password, log them in and redirect to their dashboard
      if ($row) {
        $_SESSION['profile_id'] = $row['profile_id'];
        $id = $row['profile_id'];

        header('Location: index.php');
      } else {
        $msg = "Invalid login details.";
      }

    }

  }
}
?>




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

  <title>Login Form</title>
  <style>
    body {
      background-color: ;
      font-family: Arial, sans-serif;
      background-image: url("c.png");

      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .login-form-field {
      border: none;
      border-bottom: 1px solid #3a3a3a;
      margin-bottom: 10px;
      border-radius: 3px;
      outline: none;
      padding: 0px 0px 5px 5px;
    }

    html {
      height: 100%;
    }

    body {
      height: 100%;
      width: 50%;
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      display: grid;
      justify-items: center;
      align-items: center;
      background-color: #3a3a3a;
    }

    #main-holder {
      width: 50%;
      height: 70%;
      display: grid;
      justify-items: center;
      align-items: center;
      background-color: white;
      border-radius: 7px;
      box-shadow: 0px 0px 5px 2px black;
    }

    #login-error-msg-holder {
      width: 100%;
      height: 100%;
      display: grid;
      justify-items: center;
      align-items: center;
    }

    #login-error-msg {
      width: 23%;
      text-align: center;
      margin: 0;
      padding: 5px;
      font-size: 12px;
      font-weight: bold;
      color: #8a0000;
      border: 1px solid #8a0000;
      background-color: #e58f8f;
      opacity: 0;
    }

    #error-msg-second-line {
      display: block;
    }

    #login-form {
      align-self: flex-start;
      display: grid;
      justify-items: center;
      align-items: center;
    }

    .login-form-field::placeholder {
      color: #3a3a3a;
    }

    .login-form-field {
      border: none;
      border-bottom: 1px solid #3a3a3a;
      margin-bottom: 10px;
      border-radius: 3px;
      outline: none;
      padding: 0px 0px 5px 5px;
    }

    #login-form-submit {
      width: 100%;
      padding: 7px;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      background-color: #3a3a3a;
      cursor: pointer;
      outline: none;
    }

    input[type="submit"] {
      background-color: #41c71f;
      border: 2px solid #13b821;
      color: rgb(255, 255, 255);
      width: 97px;
      height: 37px;

    }

    input[type="submitt"] {
      background-color: #7a2f2f;
      border: 2px solid #7a2f2f;
      color: rgb(255, 255, 255);
      width: 97px;
      height: 37px;
      text-align: center;

    }
  </style>
</head>

<body>


  <main id="main-holder">
    <font face="Imprint MT Shadow" color="black">
      <div class="row">
        <div class="text-center">

          <!-- Login frame -->
          <p><a href="login.php" class="w3-bar-item w3-button" onclick="toggleFunction()"><i class="fa fa-camera"
                aria-hidden="true"></i></a>
          </p>
          <h1 class="h4 text-gray-900 mb-4">
            <font face="Imprint MT Shadow">Login Here</font>
          </h1>
          <hr>
        </div>
        <p style="font-size:16px; color:red" align="center">
          <?php if ($msg) {
            echo $msg;
          } ?>
        </p>

        <form method="POST" action="">
          <div class="form-group">

            <input type="text" class="login-form-field" id="Email" name="txt_uname" aria-describedby="emailHelp"
              placeholder="Enter Email Adress..." required="true">
          </div>
          <div class="form-group">

            <input type="password" class="login-form-field" id="Password" name="txt_pwd" placeholder="Password"
              required="true">
          </div>
          <p><input type="submit" name="but_submit" value="Login"></p>

        </form>

        <p><a class="small">
            <font size="2" color="blue"><a href="userforgetpassword.php">Forgot Password?</a></font>
        </p>

        <p>Don't have an account? <font size="2" color="red"><a href="userregister.php">Sign up here</a></font>
        </p>

      </div>
</body>

</html>