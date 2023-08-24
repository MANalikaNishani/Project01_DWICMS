<?php include 'TopNav.php' ?>
<?php
if (isset($_POST['but_logout'])) {
  session_destroy();
  header('Location:userlogin.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Web Page</title>
 
 
</head>

<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);
      background-color: rgba(46, 139, 87, 0.40);
      max-width: 300px;
      margin: auto;
      text-align: center;
      font-family: Times;

    }

    .title {
      color: grey;
      font-size: 18px;
    }

    button {
      border: none;
      outline: 0;
      display: inline-block;
      padding: 8px;
      color: blue;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 100%;
      font-size: 18px;
    }

    a {
      text-decoration: none;
      font-size: 22px;
      color: white;
    }

    button:hover,
    a:hover {
      opacity: 0.7;
    }
  </style>
  </head>

  <body>

    <h2 style="text-align:center">User Profile Details</h2>

    <div class="card">

      <?php
      // database credentials
      include "config.php";

      // check if user is logged in
      if (!isset($_SESSION['profile_id'])) {
        header("Location: profile1.php");
        exit();
      }

      // retrieve user profile details from the database
      $profile_id = $_SESSION['profile_id'];
      $sql = "SELECT EmpNo, FName, LName, Email, Telephone, Address, Designation, Profile_pic FROM userlogin WHERE profile_id = '$profile_id'";
$result = $con->query($sql);

// check if the query was successful and if there is at least one row
if ($result && $result->num_rows > 0) {
  // get the first row of the result
  $row = $result->fetch_assoc();

  // display the user profile picture and details in the HTML elements
  echo '<img src="' . $row["Profile_pic"] . '" width="100" height="100" alt="Profile Picture">';
  echo '<p><strong>EmpNo:</strong> <span id="EmpNo">' . $row["EmpNo"] . '</span></p>';
  echo '<p><strong>First Name:</strong> <span id="FName">' . $row["FName"] . '</span></p>';
   echo '<p><strong>Last Name:</strong> <span id="LName">' . $row["LName"] . '</span></p>';
  echo '<p><strong>Email:</strong> <span id="Email">' . $row["Email"] . '</span></p>';
  echo '<p><strong>Designation:</strong> <span id="Designation">' . $row["Designation"] . '</span></p>';
  echo '<p><strong>Telephone:</strong> <span id="Phone">' . $row["Telephone"] . '</span></p>';
  echo '<p><strong>Address:</strong> <span id="Address">' . $row["Address"] . '</span></p>';
} else {
  echo "No results found";
}

      // close the database connection
      $con->close();
      ?>



      <p><button id="myBtn">Edit</button></p>




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
  background-color:rgba(46, 139, 87,0.0);
  padding: 0px 0px 10px 10px;
}
input[type="submit"] {
    background-color: #41c71f;
    border:2px solid #13b821;
    color: rgb(255, 255, 255);
    width:97px; height:37px;
   
  }  

      </style>
      <div id="myModal" class="modal">

        <div class="modal-content">
          <span class="close">&times;</span>

         <div id="popupForm">
  
  <div class="modal-header">
    <h2>Update Profile Form</h2>
   <hr>
    <form method="post" enctype="multipart/form-data" action="edit.php">
      
     
      <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="login-form-field" id="FirstName" name="FirstName" placeholder="First Name" pattern="[A-Za-z]+" value="<?php echo $row["FName"]; ?>" required="true">
      </div>
      <br>
      <div class="col-sm-6">
        <input type="text" class="login-form-field" id="LastName" name="LastName" placeholder="Last Name" pattern="[A-Za-z]+" value="<?php echo $row["LName"]; ?>" required="true">
      </div>
      <br>
      <div class="form-group">
        <input type="email" class="login-form-field" id="Email" name="Email" placeholder="Email Address" value="<?php echo $row["Email"]; ?>" required="true">
      </div>
      <br>
      <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="login-form-field" id="Telephone" name="Telephone" placeholder="Telephone" value="<?php echo $row["Telephone"]; ?>" required="true">
      </div>
      <br>
      <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="login-form-field" id="Address" name="Address" placeholder="Address" value="<?php echo $row["Address"]; ?>" required="true">
      </div>
      <br>
      <div class="form-group">
        <label for="profile_pic">Profile Picture:</label>
        <input type="file" class="form-control-file" id="profile_pic" name="profile_pic" >
      </div>
      <br>
      <input type="submit" class="btn btn-primary btn-user btn-block" value="Update">
    </form>
  </div>
</div>



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
  </body>

</html>