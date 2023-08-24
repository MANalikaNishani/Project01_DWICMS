<?php include 'TopNav.php' ?>

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
session_start();

if (isset($_SESSION['profile_id'])) {
  $profile_id = $_SESSION['profile_id'];
  $EmpNo = $profile_id;
}


$msg = '';
$msgs = '';

// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Retrieve form data
  $EmpNo = $_POST['EmpNo'];
  $name = $_POST['name'];
  $designation = $_POST['designation'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $work = $_POST['work'];
  $assets = $_POST['assets'];
  $description = $_POST['work-description'];
  $targetDir = "uploads/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
  $TEmpNo = $_POST['TEmpNo'];
  $Tname = $_POST['Tname'];
  $Tdesignation = $_POST['Tdesignation'];
  $Ttelephone = $_POST['Ttelephone'];
  $Temail = $_POST['Temail'];

  if (!empty($_FILES["file"]["name"])) {
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'html', 'zip');
    if (in_array($fileType, $allowTypes)) {
      // Upload file to server
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Prepare and execute the SQL query to insert the data
        $query = "INSERT INTO handover (EmpNo, name, designation, email, phone, work, assets, description, file_name, upload_on, TEmpNo, Tname, Tdesignation, Ttelephone, Temail) 
                  VALUES ('$EmpNo', '$name', '$designation', '$email', '$phone', '$work', '$assets', '$description', '$fileName', NOW(), '$TEmpNo', '$Tname', '$Tdesignation', '$Ttelephone', '$Temail')";

        $insert = mysqli_query($conn, $query);

        if ($insert) {
          $msg = "The file " . $fileName . " has been uploaded successfully.";

        } else {
          $msgs = "File upload failed, please try again.";
        }
      } else {
        $msgs = "Sorry, there was an error uploading your file.";
      }
    } else {
      $msgs = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
  } else {
    $msgs = 'Please select a file to upload.';
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
  <script src="path/to/toastify.js"></script>

  <title>Handover</title>
  <style>
    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .container {
      margin: 4% auto;
      width: 90%;
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
      padding: 0px 0px 10px 10px;
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



  <!-- Work Handover frame -->

  <body>

    <fieldset style="width:90%">
      <legend>
        <font color="Black" size="6">Work Handover Form</font>
      </legend>

      <hr>
      <font face="Times New Roman" size="4">
        <div id="body">
          <div id="input">
            <div id="lable">
              <div class="form-frame">

                <form method="post" enctype="multipart/form-data" onsubmit="return checkpass(); " action="#">

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
                      <td><label for="name">Hander EmpNo :</label></td>
                      <td><input type="hidden" name="EmpNo" value="<?php echo $profile_id; ?>" />
                        <input type="text" id="EmpNo" class="login-form-field" value="<?php echo $profile_id; ?>"
                          disabled />
                      </td>


                      <td><label for="name">Hander Name:</label></td>
                      <td><input type="text" id="name" class="login-form-field" name="name" placeholder="Your name.."
                          required></td>

                      <td><label for="designation" required>Hander Designation:</label></td>
                      <td><input type="text" class="login-form-field" name="designation"
                          placeholder="Hander's Designation:" id="designation" required></td>
                    </tr>
                    <tr>
                      <td><label for="email">Hander Email:</label></td>
                      <td><input type="text" id="email" class="login-form-field" name="email" placeholder="Your email.."
                          required></td>

                      <td><label for="phone">Hander Phone:</label></td>
                      <td><input type="text" id="phone" class="login-form-field" name="phone" placeholder="Your phone.."
                          required></td>

                      <td><label for="work">Work Task Handing Over:</label></td>
                      <td>
                        <select id="work" class="login-form-field" name="work" required>
                          <option value="completed">Completed Work</option>
                          <option value="inprogress">Work In Progress</option>
                          <option value="pending">Pending Work</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label for="assets">Assets Handing Over:</label></td>
                      <td>
                        <select id="assets" class="login-form-field" name="assets" required>
                          <option value="all">All Assets</option>
                          <option value="partial">Partial Assets</option>
                        </select>
                      </td>

                      <td><label for="work-description">Resign Description:</label></td>
                      <td><textarea id="work-description" class="login-form-field" name="work-description"
                          placeholder="Enter description" required></textarea></td>

                      <td><label for="file" required>Work List:</label></td>
                      <td><input type="file" name="file" class="login-form-field" placeholder="Choose a file to upload:"
                          id="file" required></td>
                    </tr>
                    <tr>
                      <td><label for="TEmpNo">Teker EmpNo :</label></td>
                      <td><input type="text" id="TEmpNo" class="login-form-field" name="TEmpNo" placeholder="TEmpNo.."
                          required></td>

                      <td><label for="Tname" required>Taker Name:</label></td>
                      <td><input type="text" class="login-form-field" name="Tname" placeholder="Taker's name" id="Tname"
                          required></td>

                      <td><label for="Tdesignation" required>Taker Designation:</label></td>
                      <td><input type="text" name="Tdesignation" class="login-form-field"
                          placeholder="Taker's Designation:" id="Tdesignation" required></td>
                    </tr>
                    <tr>
                      <td><label for="Ttelephone" required>Taker Telephone:</label></td>
                      <td><input type="text" class="login-form-field" name="Ttelephone" placeholder="Taker's Telephone:"
                          id="Ttelephone" required></td>

                      <td><label for="Temail" required>Taker Email:</label></td>
                      <td><input type="text" class="login-form-field" name="Temail" placeholder="Taker's Email:"
                          id="Temail" required></td>

                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit"></td>

                    </tr>
                  </table>
                </form>
    </fieldset>
  </body>

</html>