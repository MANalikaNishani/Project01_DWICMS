<?php
$conn = mysqli_connect("localhost", "root", "", "designwork");
if ($conn->connect_error) {
  die("Connection Failed:" . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM works WHERE EmpNo3 = '$id'";
if ($conn->query($sql) === TRUE) {
  header("Location: workdonesheet.php");
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>