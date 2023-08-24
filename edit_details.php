<?php include 'index.php' ?>
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
  <div class="container">

    <style>
      .container {
        font-family: 'Times New Roman', Times, serif;
        font-size: 14;
      }


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
        background-color: rgba(46, 139, 87, 0.0);
        padding: 0px 0px 10px 10px;
      }

      input[type="submit"] {
        background-color: #41c71f;
        border: 2px solid #13b821;
        color: rgb(255, 255, 255);
        width: 130px;
        height: 37px;
      }
    </style>
    <?php
    // start the session
    //session_start();
    
    // check if the user is logged in
    if (!isset($_SESSION['profile_id'])) {
      header("Location: login.php");
      exit();
    }

    // establish a database connection
    $conn = mysqli_connect("localhost", "root", "", "designwork");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // retrieve user profile details from the database
    $profile_id = $_SESSION['profile_id'];
    $sql = "SELECT Wid, WorkTitle, WorkDescription, WorkCategory, file, file_name, upload_on 
        FROM works 
        WHERE EmpNo3 = '$profile_id'"; // add the condition to filter by user ID
    
    $result = $conn->query($sql); // initialize $result variable
    
    if ($result && $result->num_rows > 0) {
      // get the first row of the result
      $row = $result->fetch_assoc();

      // check if the form was submitted
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // get the new values from the form
        $work_title = $_POST['WorkTitle'];
        $work_description = $_POST['WorkDescription'];
        $work_category = $_POST['WorkCategory'];

        $update_sql = "UPDATE works SET WorkTitle='$work_title', WorkDescription='$work_description', WorkCategory='$work_category' WHERE EmpNo3='$profile_id'";
        if ($conn->query($update_sql) === TRUE) {
          // redirect to the profile page
    
          exit();
        } else {
          echo "Error updating record: " . $conn->error;
        }
      }
    }

    if ($row) {
      echo '
    
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">

                                    <h2 class="m-0 font-weight-bold text-Times">Update Work Details</h2>
                                    <hr>
                                </div>
                                <div class="card-body">
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <label for="WorkTitle">Work Title:</label>
                                            <input type="text" name="WorkTitle" id="WorkTitle" class="login-form-field" placeholder="Work Title" value="' . $row['WorkTitle'] . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="WorkDescription">Work Description:</label>
                                            <input type="text" name="WorkDescription" id="WorkDescription" class="login-form-field" placeholder="Work Description" value="' . $row['WorkDescription'] . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="WorkCategory">Work Category:</label>
                                            <input type="text" name="WorkCategory" id="WorkCategory" class="login-form-field" placeholder="Work Category" value="' . $row['WorkCategory'] . '">
                                        </div>
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
    } else {
      echo "No work found.";
    }

    $conn->close();
    ?>