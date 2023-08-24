<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
	$email = $_POST['Email'];
	$query = mysqli_query($con, "select profile_id, Email from userlogin where Email='$email'");
	$row = mysqli_fetch_array($query);
	if (mysqli_num_rows($query) > 0) {
		$profile_id = $row['profile_id'];
		$email = $row['Email'];
		$_SESSION['id'] = $profile_id;
		$_SESSION['email'] = $email;
		header('location:userresetpassword.php');

	} else {
		$msg = "Invalid email. Please try again.";
	}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<title>Login Form</title>
	<style>
		body {
			background-color: ;
			font-family: Arial, sans-serif;
			background-image: url("c.png");
			/* Replace "path/to/image.jpg" with the path to your image file */
			background-repeat: no-repeat;
			/* Prevent the background image from repeating */
			background-size: cover;
			/* Scale the background image to cover the entire element */
		}

		.container {
			margin: 3% auto;
			width: 400px;
			background-color: #8FBC8F;
			padding: 30px;
			border-radius: 5px;
			box-shadow: 20px 20px 20px 0px rgba(0, 0, 0, 0.2);
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
			color: #B22222;
			text-decoration: none;
			margin-left: 5px;
		}
	</style>
</head>

<body>


	<div class="container">
		<div class="text-center">
		</div>
		<p style="font-size:16px; color:red">
			<?php if ($msg) {
				echo $msg;
			} ?>
		</p>
		<form class="user" method="post" action="">
			<h4 class="h4 text-gray-900 mb-4">
				<font face="Imprint MT Shadow">Recover your password!</font>
			</h4>
			<hr>
			<div class="form-group">
				<input type="text" class="form-control form-control-user" id="Email" name="Email"
					aria-describedby="emailHelp" placeholder="Enter Email Address..." required="true">
			</div>
			<p> <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Reset"></p>
		</form>
		<div class="text-center">
			<p>
				<font size="3">Already have an account?</font><a class="small" href="userlogin.php">
					<font size="4"> Login!</font>
				</a>
			<p>
		</div>

</body>

</html>