<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "designwork";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['taskId'];

    // Delete the task from the database
    $query = "DELETE FROM reminders WHERE id = '$taskId'";
    $result = $conn->query($query);
    header("Location: reminder.php");

    if ($result) {
        echo "Task deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>