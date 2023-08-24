<!DOCTYPE html>
<html>

<head>
  <title>Design Work Information and Commiunication Management System for SCDP</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Times New Roman", sans-serif;
    }

    body,
    html {
      height: 100%;
      color: #000000;
      line-height: 1.8;
    }

    body {
      background-image: url('images/cb.png');
      background-repeat: no-repeat;
      /* Prevent the background image from repeating */
      background-size: cover;
      /* Scale the background image to cover the entire element */

    }

    /* Create a Parallax Effect */
    .bgimg-1,
    .bgimg-2,
    .bgimg-3 {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .w3-wide {
      letter-spacing: 10px;
    }

    .w3-hover-opacity {
      cursor: pointer;
    }

    /* Turn off parallax scrolling for tablets and phones */
    @media only screen and (max-device-width: 1600px) {

      .bgimg-1,
      .bgimg-2,
      .bgimg-3 {
        background-attachment: scroll;
        min-height: 400px;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar (sit on top) -->
  <div class="w3-top">
    <div class="w3-bar" id="myNavbar">
      <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);"
        onclick="toggleFunction()" title="Toggle Navigation Menu">
        <i class="fa fa-bars"></i>
      </a>
      <a href="index1.php" class="w3-bar-item w3-button">Home</a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-button">Login<i class="fa fa-caret-down"></i></button>
        <div class="w3-dropdown-content w3-card-4 w3-bar-block">
          <a href="admin/adminlogin.php" class="w3-bar-item w3-button">Manager</a>
          <a href="userlogin.php" class="w3-bar-item w3-button">Employee</a>
        </div>
      </div>

      </a>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
      <a href="index.php" class="w3-bar-item w3-button" onclick="toggleFunction()">Login</a>
    </div>
  </div>
  <marquee><input type="image" img src="images/R.png" width="300" height="300"></marquee>

  <h3 class="w3-center">WELCOM TO <P> DESIGN WORK INFORMATION AND COMMIUNICATION MANAGEMENT SYSTEM FOR </P>
    <P><span class="w3-tag">STRATEGIC CITIES DEVELOPMENT PROJECT
  </h3></span>
  <script>
    // Change style of navbar on scroll
    window.onscroll = function () { myFunction() };
    function myFunction() {
      var navbar = document.getElementById("myNavbar");
      if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
      } else {
        navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");
      }
    }
    // Used to toggle the menu on small screens when clicking on the menu button
    function toggleFunction() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else {
        x.className = x.className.replace(" w3-show", "");
      }
    }
  </script>


</body>

</html>