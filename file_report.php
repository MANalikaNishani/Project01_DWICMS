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

$sql = "SELECT EmpNo1, FileNo, FileName, FolioNo, Letter, LetterDate 
        FROM files 
        WHERE EmpNo1 = '$profile_id'"; // add the condition to filter by user ID

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generate the HTML report
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
        function printPage() {
            window.print();
        }
        function downloadReport() {
            var htmlContent = document.documentElement.outerHTML;
            var blob = new Blob([htmlContent], { type: "text/html" });
            var url = URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.href = url;
            a.download = "report.html";
            a.click();
            setTimeout(function() {
                URL.revokeObjectURL(url);
            }, 0);
        }
    

            function downloadReport() {
                var htmlContent = document.documentElement.outerHTML;
                var blob = new Blob([htmlContent], { type: "text/html" });
                var url = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = url;
                a.download = "report.pdf";
                a.click();
                setTimeout(function() {
                    URL.revokeObjectURL(url);
                }, 0);
            }
        </script>
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
                
                .print-button,
                .download-button {
                    display: none;
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

            .download-button {
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

            table th,
            table td {
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
    <button class="print-button" onclick="printPage()">Print</button>
        <button class="download-button" onclick="downloadReport()">Download</button>
        <div class="form-container" id="report-content">
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
                    <td>File No</td>
                    <td>' . $row["FileNo"] . '</td>
                </tr>
                <tr>
                    <td>File Name</td>
                    <td>' . $row["FileName"] . '</td>
                </tr>
                <tr>
                    <td>Folio No</td>
                    <td>' . $row["FolioNo"] . '</td>
                </tr>
                <tr>
                    <td>Letter</td>
                    <td>' . $row["Letter"] . '</td>
                </tr>
                <tr>
                    <td>Letter Date</td>
                    <td>' . $row["LetterDate"] . '</td>
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
                <li>File No: ' . $row["FileNo"] . '</li>
                <li>File Name: ' . $row["FileName"] . '</li>
                <li>Folio No: ' . $row["FolioNo"] . '</li>
                <li>Letter: ' . $row["Letter"] . '</li>
                <li>Letter Date: ' . $row["LetterDate"] . '</li>';
    }

    echo '
            </ul>          
        </div>

    </body>
    </html>';
} else {
    echo '<p>No file details found for the selected user.</p>';
}

$conn->close();
?>