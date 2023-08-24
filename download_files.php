<?php
if (isset($_POST['downloadSelected'])) {
    // Download selected files as a zip
    if (!empty($_POST['selectedFiles'])) {
        $zip = new ZipArchive();
        $zipName = 'selected_files.zip';

        if ($zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($_POST['selectedFiles'] as $file) {
                $zip->addFile('uploads/' . $file, $file);
            }

            $zip->close();

            // Send the zip file to the browser for download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);

            // Delete the zip file after download
            unlink($zipName);
        } else {
            echo "Failed to create zip file.";
        }
    } else {
        echo "No files selected.";
    }
} elseif (isset($_POST['downloadAll'])) {
    // Download all files as a zip
    $conn = mysqli_connect("localhost", "root", "", "designwork");
    if ($conn->connect_error) {
        die("Connection Failed:" . $conn->connect_error);
    }

    if (isset($_SESSION['profile_id'])) {
        $profile_id = $_SESSION['profile_id'];
    } else {
        $profile_id = "";
    }

    $sql = "SELECT file_name FROM files WHERE EmpNo1 = '$profile_id'"; // add the condition to filter by user ID

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $zip = new ZipArchive();
        $zipName = 'all_files.zip';

        if ($zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            while ($row = $result->fetch_assoc()) {
                $file = $row['file_name'];
                $zip->addFile('uploads/' . $file, $file);
            }

            $zip->close();

            // Send the zip file to the browser for download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);

            // Delete the zip file after download
            unlink($zipName);
        } else {
            echo "Failed to create zip file.";
        }
    } else {
        echo "No files found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>