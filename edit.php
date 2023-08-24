<?php
// database credentials
include "config.php";

// check if user is logged in
session_start();
if (!isset($_SESSION['profile_id'])) {
  header("Location: login.php");
  exit();
}

// retrieve user profile details from the database
$profile_id = $_SESSION['profile_id'];
$sql = "SELECT EmpNo, FName, LName, Email, Telephone, Address, Birthday, profile_pic FROM userlogin WHERE EmpNo = '$profile_id'";
$result = $con->query($sql);

if ($result && $result->num_rows > 0) {
  // get the first row of the result
  $row = $result->fetch_assoc();

  // check if the form was submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get the new values from the form
    $new_fname = $_POST['FirstName'];
    $new_lname = $_POST['LastName'];
    $new_email = $_POST['Email'];
    $new_telephone = $_POST['Telephone'];
    $new_address = $_POST['Address'];
    $new_profile_pic = '';

    // check if a new profile picture was uploaded
    if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
      // get the file information
      $file_name = $_FILES['profile_pic']['name'];
      $file_size = $_FILES['profile_pic']['size'];
      $file_tmp = $_FILES['profile_pic']['tmp_name'];
      $file_type = $_FILES['profile_pic']['type'];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      // check if the file type is allowed
      $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
      if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) {
        // move the file to the uploads directory
        $new_profile_pic = 'uploads/' . uniqid() . '.' . $file_ext;
        move_uploaded_file($file_tmp, $new_profile_pic);
      }
    }

    // update the user profile details in the database
    $update_sql = "UPDATE userlogin SET FName='$new_fname', LName='$new_lname', Email='$new_email', Telephone='$new_telephone', Address='$new_address', profile_pic='$new_profile_pic' WHERE EmpNo='$profile_id'";
    if ($con->query($update_sql) === TRUE) {
      // redirect to the profile page
      header("Location: profile1.php");
      exit();
    } else {
      echo "Error updating record: " . $con->error;
    }
  }

  echo '<div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                  </div>
                  <div class="card-body">
                    <form class="user" method="POST" enctype="multipart/form-data">
					 
                      <div class="form-group">
                        <input type="text"  name="FirstName" placeholder="First Name" value="' . $row['FName'] . '">
                      </div>
                      <div class="form-group">
                        <input type="text"  name="LastName" placeholder="Last Name" value="' . $row['LName'] . '">
                      </div>
                      <div class="form-group">
                        <input type="email" name="Email" placeholder="Email Address" value="' . $row['Email'] . '">
                      </div>
                      <div class="form-group">
                        <input type="tel"  name="Telephone" placeholder="Telephone" value="' . $row['Telephone'] . '">
                      </div>
                      <div class="form-group">
                        <input type="text"  name="Address" placeholder="Address" value="' . $row['Address'] . '">
                      </div>
                      <div class="form-group">
                        <label for="profile_pic">Profile Picture</label>
                        <input type="file" name="profile_pic">
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">Update Profile</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>';

} else {
  echo "No profile found.";
}

// close the database connection
$con->close();
?>