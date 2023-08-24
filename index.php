<?php
include "config.php";

// Set default values if the user is not logged in or their details are not available
$Email = "Guest";
$profile_pic = "default_profile_pic.png";


// check if user is logged in
if (!isset($_SESSION['profile_id'])) {
  header("Location: profile.php");
  exit();
}

// retrieve user profile details from the database
$profile_id = $_SESSION['profile_id'];
$sql = "SELECT CONCAT(FName, ' ', LName) AS FullName, Profile_pic FROM userlogin WHERE profile_id = '$profile_id'";
$result = $con->query($sql);

// check if the query was successful and if there is at least one row
if ($result && $result->num_rows > 0) {
  // get the first row of the result
  $row = $result->fetch_assoc();
} else {
  echo "No results found";
}

// close the database connection
$con->close();
?>

<?php include 'TopNav.php'; ?>
<?php include 'Leftbar.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      font-family: Times;
    }
  </style>
</head>

<body>
  <div id="main">
    <div style="display: flex; justify-content: space-between;">
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
      <div style="display: flex; align-items: center;">
        <?php
        echo '<img src="' . $row["Profile_pic"] . '" width="50" height="50" alt="Profile Picture">';
        echo '<br>';
        echo '<p> <span id="FullName">' . $row["FullName"] . '</span></p>';
        ?>
      </div>
    </div>
    <!-- rest of HTML code -->
  </div>
</body>

</html>