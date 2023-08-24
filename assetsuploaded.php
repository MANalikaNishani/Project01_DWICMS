<?php include 'index.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <title>Assets Uploaded</title>

  <style>
    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */
    }

    .container {
      margin: 2% auto;
      width: 70%;
      background-color: rgba(46, 139, 87, 0.40);
      padding: 30px;
      border-radius: 4px;
      box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body class="">

  <div class="container">


    <!-- Assets Upload frame -->

    <body>
      <fieldset style="width:100%">
        <legend>
          <font color="Black" size="6">Assets Details Form</font>
        </legend>
        <hr>
        <button class="print-button" onclick="printTable()" color="blue"><i class="fas fa-print">Print
            Table</i></button>
        <button class="download-button" onclick="downloadReport()">Download</button>
        <br>
        <br>
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
              padding: 10px;
            }

            tr:nth-child(even) {
              background-color: #dddddd;
            }

            .container {
              margin: 2% auto;
              width: 70%;
              background-color: rgba(46, 139, 87, 0.40);
              padding: 30px;
              border-radius: 4px;
              box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
            }

            .button {
              background-color: #41c71f;
              border: 2px solid #13b821;
              color: rgb(255, 255, 255);
              width: 97px;
              height: 37px;
            }

            .print-button {
              background-color: #007bff;
              color: #fff;
              border: none;
              padding: 10px 10px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 12px;
            }

            .download-button {
              background-color: #007bff;
              color: #fff;
              border: none;
              padding: 10px 10px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 12px;
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

          $sql = "SELECT EmpNo2, AssetName, AssetType, AssetDescription, Location , PurchaseDate, PurchasePrice, AssetImage, upload_on 
        FROM assest 
        WHERE EmpNo2 = '$profile_id'"; // add the condition to filter by user ID
          
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            echo "<table>
          <tr>
            
            <th>Asset Name</th>
            <th>Asset Type</th> 
            <th>Asset Description</th>
            <th>Location</th>
            <th>Purchase Date</th>    
            <th>Purchase Price</th>
            <th>Asset Image</th>
            <th>Uploaded On</th>
            
          
          </tr>";

            while ($row = $result->fetch_assoc()) {
              echo "<tr>
             
              <td>" . $row["AssetName"] . "</td>
              <td>" . $row["AssetType"] . "</td>
              <td>" . $row["AssetDescription"] . "</td>
              <td>" . $row["Location"] . "</td>
              <td>" . $row["PurchaseDate"] . "</td>
              <td>" . $row["PurchasePrice"] . "</td>
              <td><img src='uploads/" . $row['AssetImage'] . "' width='100' height='100' alt=''></td>
              <td>" . $row["upload_on"] . "</td>
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

        function downloadReport() {
          var htmlContent = document.documentElement.outerHTML;
          var blob = new Blob([htmlContent], { type: "text/html" });
          var url = URL.createObjectURL(blob);
          var a = document.createElement("a");
          a.href = url;
          a.download = "report.html";
          a.click();
          setTimeout(function () {
            URL.revokeObjectURL(url);
          }, 0);
        }
      </script>
    </body>

</html>