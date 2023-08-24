<?php

// Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

// Define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "designwork";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$msg = '';

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["Name"];
  $email = $_POST["Email"];
  $message = $_POST["Message"];

  // Insert data into the "contact" table
  $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";

  if (mysqli_query($conn, $sql)) {
    $msg = "Message saved to database and sent email ";


    $recipient = "test1995823@gmail.com"; // Change this to the recipient email address
    $subject = "New message from contact form";
    $sender = $_POST["Name"];
    $senderEmail = $_POST["Email"];
    $mailBody = "Name: $name\nEmail: $email\nMessage: $message";

    //Create instance of PHPMailer
    $mail = new PHPMailer();

    //Set mailer to use SMTP
    $mail->isSMTP();

    //Define SMTP host
    $mail->Host = "smtp.gmail.com";

    //Enable SMTP authentication
    $mail->SMTPAuth = true;

    //Set SMTP encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";

    //Set SMTP port to connect
    $mail->Port = "587";

    //Set Gmail username
    $mail->Username = "test1995823@gmail.com";

    //Set Gmail password
    $mail->Password = "hqtwaqybujgaukae";

    //Email subject
    $mail->Subject = $subject;

    //Set sender email
    $mail->setFrom($email);

    //Enable HTML
    $mail->isHTML(true);

    //Email body
    $mail->Body = "Name: $name\n <br> Email: $email\n <br> Message: $message";

    //Add recipient
    $mail->addAddress($recipient);

    //Finally send email
    if ($mail->send()) {
      $msg = "Message saved to database and sent email succesfully!";
    } else {
      $msg = "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }

    //Close SMTP connection
    $mail->smtpClose();

    // Close database connection
    mysqli_close($conn);
  }
}
?>


<?php include 'index.php' ?>

<!DOCTYPE html>
<html>

<head>
  <title>Feed Back</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Times New Roman", sans-serif;
    }

    body,
    html {
      height: 100%;
      color: #000000;
      line-height: 1.8;
    }

    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }
  </style>
</head>

<body>


  <div class="w3-content w3-container w3-padding-64" id="contact">
    <div class="w3-row w3-padding-0 w3-section">
      <div class="w3-col m2 w3-container">
      </div>
      <div class="w3-col m8 w3-panel">
        <div class="w3-large w3-margin-bottom">
          <p class="w3-center"><em>I'd love your feedback!</em></p>
          <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-centre"></i> Colombo, Sri Lanka<br>
          <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-centre"></i> Phone: +94 717091104<br>
          <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-centre"></i> Email:
          man.nishani95@gmail.com<br>
        </div>
        <p>Any Issue? Leave me a note:</p>
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return checkpass();">

          <p style="font-size:16px; color:green" align="center">
            <?php if ($msg) {
              echo $msg;
            } ?>
          </p>

          <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
            </div>
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
            </div>
          </div>
          <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
          <button class="w3-button w3-black w3-right w3-section" type="submit"><i class="fa fa-paper-plane"></i> SEND
            MESSAGE
          </button>
        </form>
      </div>
    </div>
  </div>

</body>

</html>