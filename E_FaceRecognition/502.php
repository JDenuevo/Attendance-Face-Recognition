<!DOCTYPE html>
<html>
<head>
<title>502 - Bad Gateway</title>
<link rel="icon" href="../photos/logo.png">
<link rel="stylesheet" href="../css/effect.css">
<link rel="stylesheet" href="../css/style.css">
<!-- JS CSS -->
<link rel="stylesheet" href="../js/bootstrap.js">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../bootstrap/bootstrap.css">

<script src="https://kit.fontawesome.com/4b9ba14b0f.js" crossorigin="anonymous"></script>

</head>
<body style = "background-color: #4f96fe;">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
.far{
  font-size: 150px;
}

.num{
  font-size: 170px;
  font-family: 'Poppins', sans-serif;
}
body {
    background-color: white; /* Set the initial background color to white */
    visibility: hidden; /* Hide the content initially */
  }
</style>
<div class="h-100 d-flex align-items-center justify-content-center text-center">
    <br>
    <br>
    <div class="container">
        <br>
        <br><?php
        header("HTTP/1.0 502 - Bad Gateway");
        echo "<h1><strong>502 ERROR</strong></h1>";
        echo "<h4>The requested URL is taking to long to respond.</h4>";
        ?>
        <br>
        <div class = "justify-content-around text-center">
            <div class="far num text-white mx-1">5</div>
            <i class="far fa-question-circle fa-spin text-white mx-1"></i>
            <div class="far num text-white mx-1">2</div>
        </div>    
        <br>
        <div class="msg">
 This page is taking too long to load.
  <p>
    Sorry about that. Please try refreshing or clicking 
    <span id="countdown" class="text-white"></span>
    <?php 
        if(isset($_SESSION["loggedinasguest"]) || $_SESSION["loggedinasguest"] == true){
    ?>
    <a class="text-white" href="../e_attendance" id="dashboard-link" style="display: none;">Attendance Log</a>
    <?php 
        } elseif(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
    ?>
    <a class="text-white" href="../g_attendance" id="dashboard-link" style="display: none;">Attendance Log</a>
    <?php
        }elseif(isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] == true){
    ?>
    <a class="text-white" href="../a_attendance" id="dashboard-link" style="display: none;">Attendance Log</a>
    <?php
        }elseif(isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] == true){
    ?>
    <a class="text-white" href="../s_attendance" id="dashboard-link" style="display: none;">Attendance Log</a>
    <?php
        }
    ?>
    and try again.
  </p>
</div>

<script>
  // Countdown function
  function countdown(seconds) {
    let counter = seconds;

    const countdownElement = document.getElementById('countdown');
    const dashboardLink = document.getElementById('dashboard-link');

    const intervalId = setInterval(() => {
      counter--;

      // Update countdown text
      countdownElement.innerText = 'this after ' + counter + ' seconds';

      if (counter <= 0) {
        // Show link after countdown ends
        clearInterval(intervalId);
        countdownElement.style.display = 'none'; // Hide countdown element
        dashboardLink.style.display = 'inline'; // Show link
      }
    }, 1000);
  }

  // Start the countdown when the page loads
  window.onload = function () {
    const countdownSeconds = 15; // Set the desired countdown duration in seconds
    countdown(countdownSeconds);
  };
</script>

    </div>

    
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

<div id="loading" style="background-color: white; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;"></div>

<script>
  // Function to show the content and hide the loading element
  function showContent() {
    document.body.style.visibility = 'visible'; // Show the content
    document.getElementById('loading').style.display = 'none'; // Hide the loading element
  }

  // Set a timeout to run the showContent function after 4 seconds (4000 milliseconds)
  setTimeout(showContent, 5000);
</script>

</body>
</html>
