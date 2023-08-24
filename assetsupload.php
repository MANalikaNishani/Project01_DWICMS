<?php include 'index.php' ?>

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

//session_start();
//$id = $_SESSION['id']; // Assuming stored the login profile id in a session variable
if (isset($_SESSION['profile_id'])) {
  $profile_id = $_SESSION['profile_id'];
  $EmpNo2 = $profile_id;
  // Rest of your code
}
$msg = '';
$msgs = '';

// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Get the form data
  $EmpNo2 = $_POST['EmpNo2'];
  $assetName = $_POST['asset-name'];
  $assetType = $_POST['asset-type'];
  $assetDescription = $_POST['asset-description'];
  $location = $_POST['location'];
  $purchaseDate = $_POST['purchase-date'];
  $purchasePrice = $_POST['purchase-price'];


  // Handle the uploaded file
  $targetDir = "uploads/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if (!empty($_FILES["file"]["name"])) {
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
      // Upload file to server
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Insert record into the database
        $query = "INSERT INTO assest (EmpNo2, AssetName, AssetType, AssetDescription, Location , PurchaseDate, PurchasePrice, AssetImage, upload_on) VALUES ('" . $EmpNo2 . "','" . $assetName . "', '" . $assetType . "', '" . $assetDescription . "', '" . $location . "', '" . $purchaseDate . "', '" . $purchasePrice . "', '" . $fileName . "', NOW())";
        $result = mysqli_query($conn, $query);
        // header('Location: assetsupload.php');
        if ($result) {
          $msg = "Asset uploaded successfully.";
          // Set toast message
          $toast = "<script>toast('success', 'Assets uploaded successfully.')</script>";

        } else {
          $msgs = "Error uploading asset: " . mysqli_error($conn);
          $toast = "<script>toast('error', 'Error uploading asset.')</script>";
        }
      } else {
        $msgs = "Error uploading asset file.";
        $toast = "<script>toast('error', 'Error uploading asset file.')</script>";
      }
    } else {
      $msgs = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
      $toast = "<script>toast('error', 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed')</script>";
    }
  } else {
    $msgs = "Asset image is required.";
    $toast = "<script>toast('error', 'Asset image is required.')</script>";
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

  <title>Assets Upload Form</title>
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
      width: 60%;
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

<body class="">


  <div class="container">


    <!-- Assets Upload frame -->

    <body>
      <fieldset style="width:95%">
        <legend>
          <font color="Black" size="6">Assets Upload Form</font>
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
                        <td><label for="EmpNo2">EmpNo:</label></td>
                        <td><input type="hidden" name="EmpNo2" value="<?php echo $profile_id; ?>" />
                          <input type="text" id="EmpNo2" class="login-form-field" value="<?php echo $profile_id; ?>"
                            disabled />
                        </td>


                        <td><label for="asset-name">Asset Name:</label></td>
                        <td><input type="text" id="asset-name" class="login-form-field" name="asset-name"
                            placeholder="Enter asset name" required></td>
                      </tr>
                      <tr>

                        <td><label for="asset-type">Asset Type:</label></td>
                        <td>
                          <select id="asset-type" class="login-form-field" name="asset-type" required>
                            <option value="">--Please select--</option>
                            <option value="Computer">Computer</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Other">Other</option>
                          </select>
                        </td>

                        <td><label for="asset-description">Asset Number:</label></td>
                        <td><textarea type="text" id="asset-description" class="login-form-field"
                            name="asset-description" placeholder="Enter asset description" required></textarea></td>
                      </tr>
                      <tr>
                        <td><label for="location">Location:</label></td>
                        <td><input type="text" id="location" class="login-form-field" name="location"
                            placeholder="Enter location" required></td>

                        <td><label for="purchase-date">Purchase Date:</label></td>
                        <td><input type="date" id="purchase-date" class="login-form-field" name="purchase-date"
                            placeholder="Select purchase date" required></td>

                      </tr>
                      <tr>
                        <td><label for="purchase-price">Purchase Price:</label></td>
                        <td><input type="text" id="purchase-price" class="login-form-field" name="purchase-price"
                            step="0.01" min="0" placeholder="Enter purchase price"></td>

                        <td><label for="file">Asset Image:</label></td>
                        <td><input type="file" id="file" name="file" accept="image/*" required></td>

                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="submit" name="submit" class="button1" value="Upload"></td>
                      </tr>
                    </table>
                  </form>
      </fieldset>
  </div>
  </div>
  </div>

</body>

</html>