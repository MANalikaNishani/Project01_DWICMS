<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get the email and current image from the form
   $email = $_POST["email"];
   $currentImage = $_POST["current_image"];

   // Execute the face recognition Python script
   $output = shell_exec(' Python C:/xampp/htdocs/designwork/face_recognition.py');

   // Save the current image to a file
   $currentImageFilename = "current_image.png";
   $currentImageFilePath = "C:\\xampp\\htdocs\\designwork\\images\\" . $currentImageFilename;
   file_put_contents($currentImageFilePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $currentImage)));

   // Perform face recognition logic here
   
   if (strpos($email, "tharaka@gmail.com") !== false) {
      // Face recognition successful
      $recognizedUser = "Tharaka";

      // Start the session and store the recognized user's information
      session_start();
      $_SESSION["email"] = $email;
      $_SESSION["Tharaka"] = $recognizedUser;

      // Redirect to the index.php page
      header("Location: index.php");
      exit;
   } else {
      // Face recognition failed
      $error = "Face recognition failed. Please try again.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <title>Login</title>
</head>

<body onload="init()">
   <nav class="navbar text-white navbar-dark bg-dark">
      <a href="#" class="navbar-brand">
         Login
      </a>
   </nav>
   <p></p>
   <div class="container text-center bordered" style="width:280px">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
         <video onclick="snapshot(this);" width=250 height=250 id="video" controls autoplay></video>
         <br>
         <input type="email" placeholder="Email" name="email" class="form-control form-control-sm text-left">
         <br>
         <input type="text" accept="image/png" hidden name="current_image" id="current_image">
         <button onclick="login()" class="btn-dark" value="login">Login</button>
         <br>
         <br>
         <?php
         if (isset($error)) {
            echo '<p class="text-danger">' . $error . '</p>';
         }
         ?>
      </form>
   </div>
   <canvas id="myCanvas" width="400" height="350" hidden></canvas>
   <script>
      //--------------------
      // GET USER MEDIA CODE
      //--------------------
      navigator.getUserMedia = (navigator.getUserMedia ||
         navigator.webkitGetUserMedia ||
         navigator.mozGetUserMedia ||
         navigator.msGetUserMedia);

      var video;
      var webcamStream;
      if (navigator.getUserMedia) {
         navigator.getUserMedia(
            // constraints
            {
               video: true,
               audio: false
            },

            // successCallback
            function (localMediaStream) {
               video = document.querySelector('video');
               video.srcObject = localMediaStream;
               webcamStream = localMediaStream;
            },

            // errorCallback
            function (err) {
               console.log("The following error occurred: " + err);
            }
         );
      } else {
         console.log("getUserMedia not supported");
      }

      var canvas, ctx;

      function init() {
         // Get the canvas and obtain a context for
         // drawing in it
         canvas = document.getElementById("myCanvas");
         ctx = canvas.getContext('2d');
      }

      function login() {
         // Draws the current image from the video element into the canvas
         ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
         var dataURL = canvas.toDataURL('image/png');
         document.getElementById("current_image").value = dataURL;
      }
   </script>
</body>

</html>