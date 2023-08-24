<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      font-family: Times;
    }

    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #2F4F4F;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */

    }

    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 14px;
      color: white;
      display: block;
      transition: 0.3s;
    }

    .sidenav a:hover {
      color: #f1f1f1;
    }

    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }

    #main {
      transition: margin-left .5s;
      padding: 16px;
    }

    @media screen and (max-height: 450px) {
      .sidenav {
        padding-top: 15px;
      }

      .sidenav a {
        font-size: 18px;
      }
    }
  </style>
</head>

<body>
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <ul>
      <a href="profile1.php" onclick="loadPage('profile.html')"><i class="fa fa-user fa-2x"></i> My Profile</a>
      <a href="uploadedfiles.php" onclick="loadPage('uploadedfiles.php')"><i class="fa fa-file fa-2x"></i> My Files</a>
      <a href="assetsuploaded.php" onclick="loadPage('assetsuploaded.php')"><i class="fa fa-upload fa-2x"></i> My
        Assets</a>
      <a href="workdonesheet.php" onclick="loadPage('workdonesheet.php')"><i class="fa fa-briefcase fa-2x"></i> My
        Works</a>
      <a href="MyHandover.php" onclick="loadPage('MyHandover.php')"><i class="fa fa-briefcase fa-2x"></i> My
        Handover</a>
      <a href="userlogin.php" onclick="loadPage('userlogin.php')"><i class="fa fa-sign-out fa-2x"></i> Logout</a>
      <a href="help.php" onclick="loadPage('help.php')"><i class="fa fa-question-circle fa-2x"></i> Help</a>
    </ul>
  </div>
  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
    }
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft = "0";
    }

    function loadPage(page) {
      // This function could be used to load content dynamically
      // using AJAX or other techniques.
      alert("Loading page " + page);
    }
  </script>
</body>

</html>