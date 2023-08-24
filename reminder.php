<?php
include 'TopNav.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "designwork";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$msg = '';
$msgs = '';

session_start();
if (isset($_SESSION['profile_id'])) {
  $profile_id = $_SESSION['profile_id'];
  $EmpNo4 = $profile_id;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $EmpNo4 = $_POST['EmpNo4'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $remind_from = $_POST['remind_from'];
  $remind_to = $_POST['remind_to'];
  $status = $_POST['status'];

  $query = "INSERT INTO reminders (EmpNo4,title, description, remind_from, remind_to, status) 
              VALUES ('$EmpNo4','$title', '$description', '$remind_from', '$remind_to', '$status')";
  $result = $conn->query($query);
  header('Location: reminder.php');
  if ($result) {
    echo "Data saved successfully!";
  } else {
    echo "Error: " . $conn->error;
  }

  $conn->close();
}

$today = date('Y-m-d');
$query = "SELECT * FROM reminders WHERE EmpNo4 = '$EmpNo4' AND remind_from <= '$today' AND remind_to >= '$today'";
$result = $conn->query($query);
$todayTasks = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">

  <style>
    .login-form-field {
      border: none;
      border-bottom: 1px solid #3a3a3a;
      margin-bottom: 10px;
      border-radius: 3px;
      outline: none;
      background-color: rgba(46, 139, 87, 0.2);
      padding: 0px 0px 10px 10px;
    }

    .modal-content {
      background-color: #A9A9A9;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 30%;
      border-radius: 4px;
      box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
      font-family: Times;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      font-family: Times;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: Times;
      cursor: pointer;
    }

    /* Today's Tasks Form */
    #todayTasksContainer {
      margin-top: 20px;
      font-family: Times;
      width: 40%;
      height: 5%;
    }

    .card {
      margin-bottom: 20px;
      font-family: Times;
    }


    .card-body {
      padding: 20px;
      background-color: rgba(46, 139, 87, 0.2);
      border-radius: 5px;
      font-family: Times;

    }

    .card-title {
      font-size: 16px;
      text-decoration: Times;
      font-weight: bold;
      font-family: Times;

    }

    .card-subtitle {
      font-size: 14px;
      text-decoration: Times;
      color: #888;
      font-family: Times;
    }

    .card-text {
      margin-bottom: 10px;
      font-family: Times;
    }

    input[type="checkbox"] {
      margin-right: 10px;
    }

    .delete-task {
      margin-left: 10px;
    }

    #delete-selected-tasks {
      margin-top: 10px;
    }

    /* Add New Reminder Form */
    .modal {

      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(128, 128, 128, 0.6);
    }

    .modal-content {
      background-color: rgba(46, 139, 87, 0.40);
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      border-radius: 5px;
      max-width: 500px;
    }

    .close {
      color: #888;
      float: right;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

    .form-table {
      width: 50%;
      margin-bottom: 20px;
    }

    .form-table tr td {
      padding: 10px;
    }

    .form-table label {
      font-weight: bold;
    }

    .form-table input[type="text"],
    .form-table textarea,
    .form-table select {
      width: 100%;
      padding: 5px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    .form-table input[type="date"] {
      width: 100%;
      padding: 5px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    .form-table select {
      height: 30px;
    }

    .form-table button {
      display: block;
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    .form-table button:hover {
      background-color: #0056b3;
    }

    .form-table a {
      display: block;
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #6c757d;
      color: #fff;
      border: none;
      border-radius: 3px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
    }

    .form-table a:hover {
      background-color: #495057;
    }
  </style>
</head>

<body>
  <div class="container">
    <fieldset style="width:85%">
      <h3 class="text-center" style="font-family:Times;"><b>Work Reminder</b></h3>

      <div class="row">
        <div class="col-md-6">
          <h3 class="text-center" style="font-family:Times;"><button class="btn btn-primary rounded-pill w-50"
              id="add-reminder-button">+ Add New Reminder</button></h3>
        </div>
        <div class="col-md-6">
          <h3 class="text-center" style="font-family:Times;"> <a href="task_report.php"
              class="btn btn-primary rounded-pill w-50" id="">Meeting Report</a></h3>

        </div>
        <div class="row">
          <h3 class="text-center" style="font-family:Times;"> <a href="#" class="btn btn-primary rounded-pill w-50"
              id="today-tasks-button">Today Tasks</a></h3>

        </div>
      </div>
  </div>
  </font>
  </fieldset>

  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form action="#" id="reminder-form" method="POST">
        <input type="hidden" name="id">
        <div class="form-group">
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
            <tbody>
              <tr>
                <td><label for="title" class="control-label">EmpNo</label></td>
                <td>
                  <input type="hidden" name="EmpNo4" value="<?php echo $profile_id; ?>" />
                  <input type="text" id="EmpNo4" class="login-form-field" value="<?php echo $profile_id; ?>" disabled />
                </td>
              </tr>
              <tr>
                <td><label for="title" class="control-label">Title</label></td>
                <td><input type="text" name="title" id="title" class="login-form-field" placeholder="Enter Title"
                    autofocus required /></td>
              </tr>
              <tr>
                <td><label for="description" class="control-label">Short Description</label></td>
                <td><textarea rows="2" name="description" id="description" class="login-form-field"
                    placeholder="Enter Description" required></textarea></td>
              </tr>
              <tr>
                <td><label for="remind_from" class="control-label">Remind From</label></td>
                <td><input type="date" max="" name="remind_from" id="remind_from" class="login-form-field" value=""
                    required /></td>
              </tr>
              <tr>
                <td><label for="remind_to" class="control-label">Remind To</label></td>
                <td><input type="date" min="" name="remind_to" id="remind_to" class="login-form-field" value=""
                    required /></td>
              </tr>
              <tr>
                <td><label for="status" class="control-label">Status</label></td>
                <td>
                  <select name="status" id="status" class="login-form-field" required="required">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <div class="row justify-content-center">
                    <div class="col-lg- col-md-5 col-sm-12 m-1">
                      <button class="btn btn-primary rounded-pill w-100">Save Data</button>
                    </div>
                    <div class="col-lg- col-md-5 col-sm-12 m-1">
                      <a href="reminder.php" class="btn btn-secondary rounded-pill w-100">Cancel</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>

  <div id="todayTasksContainer" style="display: none;">
    <h3>Today's Tasks</h3>
    <?php foreach ($todayTasks as $task): ?>
      <div class="card" id="task-<?php echo $task['id']; ?>">
        <div class="card-body">
          <h5 class="card-title">
            <?php echo $task['title']; ?>
          </h5>
          <h6 class="card-subtitle mb-2 text-muted">
            <?php echo $task['description']; ?>
          </h6>
          <p class="card-text">From:
            <?php echo $task['remind_from']; ?> To:
            <?php echo $task['remind_to']; ?>
          </p>
          <p class="card-text">Status:
            <?php echo ($task['status'] == 1) ? 'Active' : 'Inactive'; ?>
          </p>
          <input type="checkbox" name="taskIds[]" value="<?php echo $task['id']; ?>">
          <button class="fa fa-trash text-danger" data-task-id="<?php echo $task['id']; ?>"
            onclick="deleteTask(<?php echo $task['id']; ?>)"></button>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("add-reminder-button");
    var span = document.getElementsByClassName("close")[0];
    var todayTasksContainer = document.getElementById("todayTasksContainer");

    btn.onclick = function () {
      modal.style.display = "block";
      todayTasksContainer.style.display = "none";
    }

    span.onclick = function () {
      modal.style.display = "none";
    }
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    var todayTasksButton = document.getElementById("today-tasks-button");
    todayTasksButton.onclick = function () {
      modal.style.display = "none";
      todayTasksContainer.style.display = "block";
    }
    var deleteSelectedTasksButton = document.getElementById("delete-selected-tasks");
    deleteSelectedTasksButton.onclick = function () {
      var selectedTasks = document.querySelectorAll('input[name="taskIds[]"]:checked');
      var taskIds = [];
      for (var i = 0; i < selectedTasks.length; i++) {
        taskIds.push(selectedTasks[i].value);
      }
      console.log(taskIds);

      location.reload();
    }
    var deleteTaskButtons = document.getElementsByClassName("delete-task");
    for (var i = 0; i < deleteTaskButtons.length; i++) {
      deleteTaskButtons[i].onclick = function () {
        var taskId = this.getAttribute("data-task-id");
        console.log(taskId);
        deleteTask(taskId);
      }
    }



    function deleteTask(taskId) {
      // Send an AJAX request to delete the task from the database
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Task deleted successfully, remove it from the DOM
          var taskElement = document.getElementById('task-' + taskId);
          if (taskElement) {
            taskElement.remove();
          }
        }
      };
      xhr.open('POST', 'delete_task.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send('taskId=' + taskId);
    }




  </script>