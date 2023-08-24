<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "designwork");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_SESSION['profile_id'])) {
    $profile_id = $_SESSION['profile_id'];
} else {
    $profile_id = "";
}

$sql = "SELECT EmpNo4, title, description
        FROM reminders 
        WHERE EmpNo4 = '$profile_id'"; // add the condition to filter by user ID

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generate the HTML report
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Report</title>
        <style>
            @media print {
                @page {
                    size: A4;
                    margin: 0;
                }
    
                body {
                    margin: 1.27cm;
                }
            }

            .form-container {
                width: 100%;
                max-width: 21cm;
                margin: 0 auto;
                padding: 2cm;
                border: 1px solid #000;
                background-color: #fff;
                box-sizing: border-box;
            }

            .print-button {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }
            h1 {
                text-align: center;
                margin-bottom: 1cm;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 1cm;
            }

            table th, table td {
                padding: 0.5cm;
                border: 1px solid black;
            }

            ul {
                margin-left: 2cm;
            }

            p {
                margin-bottom: 0.5cm;
            }
        </style>
    </head>
    <body>
        <div class="form-container">
            <h1>Report</h1>
            <h2>File Details</h2>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '
                <tr>
                    <td>Title</td>
                    <td>' . $row["title"] . '</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>' . $row["description"] . '</td>
               
                </tr>';
    }

    echo '
            </table>
            <h2>Summary</h2>
            <p>The report provides information about the file(s) with the following details:</p>
            <ul>';

    $result->data_seek(0); // Reset the result set pointer to the beginning

    while ($row = $result->fetch_assoc()) {
        echo '
                <li>Title: ' . $row["title"] . '</li>
                <li>Description: ' . $row["description"] . '</li>';
    }

    echo '
            </ul>
           
        </div>

        <script>
            function printPage() {
                window.print();
            }
        </script>
        <button onclick="printPage()">Print</button>
    </body>
    </html>';
} else {
    echo '<p>No file details found for the selected user.</p>';
}

$conn->close();
?>