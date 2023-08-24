<?php include 'index.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/stylesheet1.css">
    <title>Work Done</title>
    <style>
        body {
            background-image: url('images/cb.png');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            margin: 4% auto;
            width: 70%;
            background-color: rgba(46, 139, 87, 0.40);
            padding: 30px;
            border-radius: 4px;
            box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <p><button onclick='printTable()'><i class='fas fa-print'>Print Table</i></button></p>

        <!-- Work Done Sheet -->
        <fieldset style="width:100%">
            <legend>
                <font color="Black" size="6">Work Done Sheet</font>
            </legend>
            <hr>
            <font face="Times New Roman" size="4">
                <style>
                    table {
                        font-family: Times;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    td,
                    th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }

                    tr:nth-child(even) {
                        background-color: #dddddd;
                    }
                </style>

                <?php
                $conn = mysqli_connect("localhost", "root", "", "designwork");
                if ($conn->connect_error) {
                    die("Connection Failed:" . $conn->connect_error);
                }

                if (isset($_SESSION['profile_id'])) {
                    $profile_id = $_SESSION['profile_id'];
                } else {
                    $profile_id = "";
                }

                $sql = "SELECT EmpNo3, WorkTitle, WorkDescription, WorkDate, WorkCategory, file, file_name, upload_on 
                        FROM works 
                        WHERE EmpNo3 = '$profile_id'"; // add the condition to filter by user ID
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                              <th>Work Title</th>
                              <th>Work Description</th> 
                              <th>Work Category</th>
                              <th>Work File</th>  
                              <th>Images</th>    
                              <th>Uploaded On</th>
                              <th>Actions</th>
                            </tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["WorkTitle"] . "</td>
                                <td>" . $row["WorkDescription"] . "</td>
                                <td>" . $row["WorkCategory"] . "</td>
                                <td><a href='uploads3/" . $row["file"] . "'>View</span></a></td>
                                <td><img src='uploads3/" . $row['file_name'] . "' width='100' height='100' alt=''></td>
                                <td>" . $row["upload_on"] . "</td>
                                <td>
                                <p><a href='edit_details.php?id=" . $row['EmpNo3'] . "'><span class='fa fa-edit text-dark'></span></button></p>
                                
                                </td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
        </fieldset>
    </div>

    <style>
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
            width: 60%;
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
    </style>


    <script>
        function printTable() {
            var table = document.getElementsByTagName("table")[0].outerHTML;
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">' + table + '</body></html>');
            newWin.document.close();
            setTimeout(function () {
                newWin.close();
            }, 10);
        }
    </script>
</body>

</html>
</body>

</html>