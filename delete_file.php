<?php
$conn = mysqli_connect("localhost", "root", "", "designwork");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fileNo'])) {
    $fileNumber = $_GET['fileNo'];

    $conn = mysqli_connect("localhost", "root", "", "designwork");
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Delete the selected row from the database
    $sql = "DELETE FROM files WHERE FileNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fileNumber);

    if ($stmt->execute()) {
        echo "File deleted successfully.";
        header('Location: uploadedfiles.php');
    } else {
        echo "Error deleting file: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>