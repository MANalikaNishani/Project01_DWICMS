<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['id']) == 0) {
	header('location:logout.php');
} else {
	if (isset($_POST['submit'])) {
		$email = $_SESSION['email'];
		$id = $_SESSION['id'];
		$newpassword = $_POST['newpassword'];
		$confirmpassword = $_POST['confirmpassword'];
		if ($newpassword == $confirmpassword) {
			$query = mysqli_query($con, "UPDATE userlogin SET Password='$newpassword'  WHERE Email='$email' && profile_id='$id'");
			if ($query) {
				$msg = "Password successfully changed";
				session_destroy();
			} else {
				$msg = "Password Change Unsucessfull, Try again!";
			}
		} else {
			$msg = "New Password and Confirm Password do not match";
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

		<script type="text/javascript">
			function checkpass() {
				if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
					alert('New Password and Confirm Password field does not match');
					document.changepassword.confirmpassword();
					return false;
				}
				return true;
			}

		</script>

		<head>


			<div class="container">
				<div class="text-center">
					<h1 class="h4 text-gray-900 mb-4">
						<font face="Imprint MT Shadow">Reset Password
					</h1>
				</div>
				<hr>
				<p style="font-size:16px; color:red" align="center">
					<?php if ($msg) {
						echo $msg;
					} ?>
				</p>

				<form class="user" name="changepassword" method="post" onsubmit="return checkpass();">
					<div class="form-group">
						<input type="Password" class="form-control form-control-user" id="newpassword" name="newpassword"
							value="" required="true" placeholder="Enter Your New Password" required="true">
					</div>
					<div class="form-group">
						<input type="Password" class="form-control form-control-user" id="confirmpassword"
							name="confirmpassword" value="" required="true" placeholder="Confirm Your Password"
							required="true">
					</div>
					<p> <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Reset"></p>
				</form>
				<hr>
				<div class="text-center">
					<a class="small" href="userlogin.php">Now Login!</a></font>
				</div>
			</div>
			</div>
			</div>
			</div>

	</body>

	</html>
<?php } ?>