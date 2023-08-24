<?php include 'index.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/stylesheet1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <title>View Handover Details</title>
  <style>
    .container {
      margin: 4% auto;
      width: 70%;
      background-color: rgba(46, 139, 87, 0.40);
      padding: 30px;
      border-radius: 4px;
      box-shadow: 10px 10px 0px 0px rgba(0, 0, 0, 0.2);
      overflow-x: scroll;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    label {
      font-weight: bold;
      margin-bottom: 10px;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
    }

    .message-form {
      display: none;
      margin-top: 30px;
    }

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

    .description {
      max-height: 60px;
      overflow: hidden;
    }

    .see-more {
      display: inline-block;
      margin-top: 5px;
      cursor: pointer;
      color: blue;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <fieldset style="width:90%">
      <legend>
        <font color="Black" size="6">View Handover Details</font>
      </legend>
      <hr>
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

      // Query to fetch asset details based on the selected user
      $sql = "SELECT EmpNo, name, designation, email, phone, work, assets, description, file_name, upload_on, TEmpNo, Tname, Tdesignation, Ttelephone, Temail
                FROM handover 
                WHERE EmpNo = '$profile_id'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<table>
          <tr>
            <th>Name</th>
            <th>Designation</th> 
            <th>Email</th>
            <th>Phone</th>
            <th>Work</th>  
            <th>Assets</th>    
            <th>Description</th>    
            <th>file_name</th>    
            <th>Upload_On</th>    
            <th>Taker's EmpNo</th>    
            <th>Taker's Name</th>
            <th>Taker's Designation</th>
            <th>Taker's Telephone</th>
            <th>Taker's Email</th>
            <th>Action</th>
          </tr>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["designation"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["work"] . "</td>
                    <td>" . $row["assets"] . "</td>
                    <td>
                      <div class='description'>
                        <span>" . $row["description"] . "</span>
                      </div>
                      <div class='see-more' onclick='toggleDescription(this)'>See more</div>
                    </td>
                    <td><a href='uploads/" . $row["file_name"] . "'>View</a></td>
                    <td>" . $row["upload_on"] . "</td>
                    <td>" . $row["TEmpNo"] . "</td>
                    <td>" . $row["Tname"] . "</td>
                    <td>" . $row["Tdesignation"] . "</td>
                    <td>" . $row["Ttelephone"] . "</td>
                    <td>" . $row["Temail"] . "</td>
                    <td><a href='report.php'><i class='fas fa-print'>Report Generate</i></button>
                  </tr>";
        }

        echo '</table>';
      } else {
        echo '<p>No Handover details found for the selected user.</p>';
      }
      ?>
    </fieldset>
  </div>

  <script>
    function toggleDescription(element) {
      var description = element.previousSibling;
      var isExpanded = description.classList.contains('expanded');
      if (isExpanded) {
        description.classList.remove('expanded');
        element.innerHTML = 'See more';
      } else {
        description.classList.add('expanded');
        element.innerHTML = 'See less';
      }
    }
  </script>
</body>

</html>