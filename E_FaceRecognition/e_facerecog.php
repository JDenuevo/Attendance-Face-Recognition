<?php
 include ('../dbconn.php');
require './e_form_validation_fr.php';
date_default_timezone_set('Asia/Manila');
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Face Recognition | BERGS</title>
<link rel="stylesheet" href="../css/effect.css">
<link rel="icon" href="../photos/bergslogo.png">

<script defer src="../js/face-api.min.js"></script>
<script defer src="../js/e_facerecog.js"></script>

<!-- Jquery Table -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    console.error = function() {};

</script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="../css/style.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="../js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
<style>
  #camera {
    position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  }

  #video {
    width: 100%;
    height: 100%;
  }

  #canvas {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;
  z-index: 1;
  max-width: 100%;
  max-height: 100%;
  }

</style>
</head>
<body>
<!--Main Navigation-->
  <nav class="navbar navbar-expand-lg navbar-expand-md shadow p-1 rounded fixed-top" id="navbar" style="background-color: #DAEAF1;">
    <div class="container-fluid mx-auto">

      <!-- OffCanvas Left Navigation Bar -->
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasRight">
        <i class="fa-solid fa-user"></i>
        Profile
      </button>

      <a class="navbar-brand" href="../login_form">
        <img src="../photos/bergslogo.png" class="img-fluid px-1" width="80px">
      </a>

      <!-- OffCanvas Right Navigation Bar -->
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" href="#offcanvasRight" data-bs-toggle="offcanvas" aria-controls="navbarSupportedContent">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <img src="../photos/bergs.png" class="img-fluid w-75">
          <button type="button" class="btn-close me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

          <ul class="navbar-nav m-auto">
            <li class="nav-item">
                <?php 
                if(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
                ?>
              <a class="nav-link px-3" href="../e_dashboard">Dashboard</a>
              <?php 
                }elseif(isset($_SESSION["loggedinasguest"]) || $_SESSION["loggedinasguest"] == true){
              ?>
               <a class="nav-link px-3" href="../g_dashboard">Dashboard</a>
              <?php
                }elseif(isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] == true){
              ?>
               <a class="nav-link px-3" href="../a_dashboard">Dashboard</a>
              <?php
                }elseif(isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] == true){
              ?>
               <a class="nav-link px-3" href="../s_dashboard">Dashboard</a>
              <?php
                }
              ?>
            </li>
            
            <li class="nav-item">
                <?php 
                if(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
                ?>
              <a class="nav-link px-3 active" href="../e_attendance">Attendance</a>
              <?php 
                }elseif(isset($_SESSION["loggedinasguest"]) || $_SESSION["loggedinasguest"] == true){
              ?>
              <a class="nav-link px-3 active" href="../g_attendance">Attendance</a>
              <?php
                }elseif(isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] == true){
              ?>
               <a class="nav-link px-3 active" href="../a_attendance">Attendance</a>
              <?php 
                }elseif(isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] == true){
              ?>
               <a class="nav-link px-3 active" href="../s_attendance">Attendance</a>
              <?php 
              }
              ?>
            </li>
            
            <li class="nav-item">
                <?php 
                if(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
                ?>
                <a class="nav-link px-3" href="../e_account">Account</a>
                <?php 
                }elseif(isset($_SESSION["loggedinasguest"]) || $_SESSION["loggedinasguest"] == true){
              ?>
                <a class="nav-link px-3" href="../g_account">Account</a>              
              <?php
                }elseif(isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] == true){
              ?>
               <a class="nav-link px-3" href="../a_account">Account</a>
              <?php
                }elseif(isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] == true){
              ?>
               <a class="nav-link px-3" href="../s_account">Account</a>
              <?php
                }
              ?>
            </li>
          </ul>

          <form class="d-flex" action="../logout"role="button">
            <a href="../logout">
            <button class="btn ms-3 px-3" data-toggle="tooltip" data-placement="top" title="Sign Out" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
            </a>
          </form>

        </div>
      </div>
    </div>
  </nav>

<!--Main Navigation-->

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 col-lg-2 d-md-block bg-light sidebar border-end">
      <div class="position-sticky list-group"><br><br>
        
          <?php

            $employee_id = $_SESSION['id'];

            $sql = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
            $result = $conn->query($sql);
            while ($row=$result->fetch_assoc()) {

            $image_data = $row['image'];
            // Convert image data to base64-encoded string
            $image_data_base64 = base64_encode($image_data);
            ?>

            <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-100 py-2 px-2 rounded-circle">
            <label class="fw-italic"><?php echo $row['title'] ?> <br> <span class = "fw-bold"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></span></label>
            <?php } ?>

          <hr>
        <?php 
                if(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
                ?>
        <ul class="nav flex-column d-md-block">

          <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="View a Memo!" href="../e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="View a Event!" href="../e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
          </ul>

          <hr>

          <label class = "pb-2 fs-5 ms-1">Manage</label>
              

            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="../e_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>
            
        </ul>
        <?php 
                }
        ?>
        <br><br>
      </div>
    </nav>


    <main class="col-12 col-md-10 col-lg-10 ms-sm-auto px-md-4">
  <br><br><br>
  <div class="page-header pt-2">
    <label class = "fs-2">Face Recognition Attendance</label>
  </div>
  <hr>

  <div class="justify-content-center text-center">
    <div class="row">
      <div class="container text-end py-2">
        <label class = "text-truncate" id = 'time'><i class="fa-regular fa-clock fa-spin" style="color: #000000;"></i></label>
      </div>

      <div class="col-12 col-lg-5 col-md-5 col-sm-12">
        <div id="camerabox" class="py-5 shadow border border-opacity-50 text-center">
          <div id="camera">
            <video class = "img-fluid" id="video" autoplay muted></video>
            <canvas id="canvas"></canvas>
          </div>
        </div>
        <br><br>
        <div class="shadow border border-opacity-50">
          <h3><center>Notification Here!</center></h3>
        </div>
      </div>

        <div class="col-12 col-lg-7 col-md-7 col-sm-12 py-2 shadow border border-opacity-50">
            <h4>Today's Attendance Information</h4>
            <hr>

            <form action="" method="POST">
                  <div class="container-fluid text-center align-items-center" id="contents">
                  </div>
                  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <div class="container text-center align-items-center">
                        
                      <button class="btn btn-success my-2"id="timeOutButton" type="button" name="time_out_btn" class="btn btn-success" onclick="captureImageAndSave()" disabled>Time Out</button>
                      <button class="btn btn-success my-2"id="halfDayButton" type="button" name="half_day_btn" class="btn btn-success" onclick="halfday()" disabled>HalfDay</button>
                        <br>
                      <button class="btn btn-primary my-2" id="timeInOTButton" type="button" name="time_in_OT_btn" class="btn btn-primary" onclick="TimeinOT()" disabled> Time In OT</button>
                      <button class="btn btn-primary my-2" id="timeOutOTButton" type="button" name="time_out_OT_btn" class="btn btn-primary" onclick="CaptureTimeOutOT()" disabled> Time Out OT</button>
                      
                    </div>
            
            </form>
            <br><br><br>>
        </div>
    </div>
</div>
    </main>
    <?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors'])) {
    $error = $_GET['errors'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Time Out',
        text: '$error',
        showConfirmButton: false,
        showClass: {
          popup: 'animate__animated animate__fadeIn'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      });
      setTimeout(function() {
        Swal.close();
      }, 4000);
    </script>";

    unset($_GET['errors']);
  }
?>


<!-- Off Canvas for Profile Button -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header justify-content-end">
      <button type="button" class="btn-close float-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
    <?php

      $employee_id = $_SESSION['id'];

      $sql = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
      $result = $conn->query($sql);
      while ($row=$result->fetch_assoc()) {

      $image_data = $row['image'];
      // Convert image data to base64-encoded string
      $image_data_base64 = base64_encode($image_data);
      ?>

      <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-25 px-2 rounded-circle">
      <label class="fw-italic"><?php echo $row['position'] ?> <br> <span class = "fw-bold"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></span></label>
      <?php } ?>

      <hr>
        <?php 
                if(isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] == true){
                ?>
      <div class = "list-group">
        <ul class= "list-unstyled mb-0 pb-3 pb-md-2 pe-lg-2">
          <ul class = "list-unstyled fw-normal pb-2 small">
          </ul>


          <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="../e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="../e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
          </ul>

          <hr>

          <label class = "pb-2 fs-5">Manage</label>
              
              <li><a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Policies" href="../e_policies"><i class="fa-solid fa-file-lines"></i> Policies</a></li>
              

          </li>

        </ul>
      </div>
      <?php 
                }
      ?>
    </div>
  </div>

<script>
  function checkAttendance() {
      $(document).ready(function() {
          // Get the attendance data using AJAX
          $.ajax({
              url: "./get_attendance",
              dataType: "json",
              success: function(data) {
                    // Check if the response is empty
                  if ($.isEmptyObject(data)) {
                       $("#timeInOTButton, #timeOutOTButton, #timeOutButton").prop("disabled", true);
                      return;
                  }
                  var timeIn = data[0].time_in != null ? new Date(data[0].time_in) : null;
                  var timeOut = data[0].time_out != null ? new Date(data[0].time_out) : null;
                  var timeInOT = data[0].time_in_OT !== null ? new Date(data[0].time_in_OT) : null;
                  var timeOutOT = data[0].time_out_OT !== null ? new Date(data[0].time_out_OT) : null;
                  var leave_early = data[0].leave_early !== null ? data[0].leave_early : null;
                  var shift_end = data[0].shift_end !== null ? data[0].shift_end : null;
                  var beginning_out = data[0].beginning_out !== null ? data[0].beginning_out : null;
                  var end_out = data[0].end_out !== null ? data[0].end_out : null;
                  var beginning_ot_in = data[0].beginning_ot_in !== null ? data[0].beginning_ot_in : null;
                  var beginning_ot_out = data[0].beginning_ot_out !== null ? data[0].beginning_ot_out : null;
                  var end_ot_in = data[0].end_ot_in !== null ? data[0].end_ot_in : null;
                  var end_ot_out = data[0].end_ot_out !== null ? data[0].end_ot_out : null;
                  $("#timeInOTButton, #timeOutOTButton, #timeOutButton, #halfDayButton").hide();
                  
                 if (leave_early !== null && beginning_out !== null) {
                      var shiftEndTime = new Date();
                      var [hours, minutes, seconds] = beginning_out.split(':');
                      shiftEndTime.setHours(hours);
                      shiftEndTime.setMinutes(minutes - leave_early);
                      shiftEndTime.setSeconds(seconds); // Set the seconds part of the date
                      var options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                      var updatedShiftEndTime = shiftEndTime.toLocaleTimeString([], options);
                    }else{
                        var updatedShiftEndTime = beginning_out;
                    }
                    
                    
               
                    
                    // Show/hide the TimeInOTButton and TimeOutOTButton based on the values of beginning_in_ot, beginning_out_ot, end_in_ot, and end_out_ot
                    if (beginning_ot_in == null && beginning_ot_out == null && end_ot_in == null && end_ot_out == null) {
                        $("#timeInOTButton, #timeOutOTButton").hide();
                        $("#timeInOTButton, #timeOutOTButton").prop("disabled", true);
                    }


                    // Get the value of exp_time_out as a datetime object and calculate the difference between it and the current time
                  var expTimeOut = new Date(data[0].exp_time_out);
                  var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit'});
                  
                       // Show/hide the Half Day button based on the value of time_out
                    if (timeOut === null) {
                        $("#halfDayButton").show();
                        $("#halfDayButton").prop("disabled", false);
                    } else {
                        $("#halfDayButton").hide();
                        $("#halfDayButton").prop("disabled", true);
                    }
                    
                  // Disable/enable the buttons based on the rules
                 if ((timeOut === null && updatedShiftEndTime > currentTime) || (timeOut !== null && timeInOT === null && timeOutOT === null) || (timeOut !== null && timeInOT !== null && timeOutOT !== null)) {
                      $("#timeInOTButton, #timeOutOTButton, #timeOutButton").prop("disabled", true);
                      $("#timeInOTButton, #timeOutOTButton, #timeOutButton").hide();
                      
                  } else if (timeOut === null && timeInOT === null && currentTime >= updatedShiftEndTime && currentTime <= end_out) {
                      $("#timeOutButton").show();
                      $("#halfDayButton").hide();
                      $("#timeOutButton").prop("disabled", false);
                      $("#timeInOTButton, #timeOutOTButton").prop("disabled", true);
                  }else if (timeOut === null && timeInOT === null && beginning_ot_in !== null && end_ot_in !== null && beginning_ot_in <= currentTime && end_ot_in >= currentTime){
                      $("#timeInOTButton, #timeOutButton").prop("disabled", false);
                      $("#timeOutOTButton").prop("disabled", true);
                      $("#halfDayButton, #timeOutOTButton").hide();
                      $("#timeInOTButton, #timeOutButton").show();
                  }else if (timeInOT !== null && timeOut !== null && timeOutOT === null && beginning_ot_out !== null && end_ot_out !== null && beginning_ot_out <= currentTime && end_ot_out >= currentTime) {                                         
                      $("#timeInOTButton, #timeOutButton").prop("disabled", true);
                      $("#timeOutOTButton").prop("disabled", false);
                      $("#timeOutOTButton").show();
                      $("#timeInOTButton, #timeOutButton, #halfDayButton").hide();
                  } else {
                      $("#timeInOTButton, #timeOutButton, #timeOutOTButton").prop("disabled", true);
                      $("#timeInOTButton, #timeOutOTButton, #timeOutButton").hide();
                  }
              }
          });
      });
  }
  setInterval(checkAttendance, 3000);
</script>

<script>
  function captureImageAndSave() {
  // Get the video and canvas elements
  var video = document.getElementById('video');
  var canvas = document.getElementById('canvas');

  // Set the canvas dimensions to match the video
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw the current frame of the video onto the canvas
  var context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Convert the canvas to a data URL with specified format and quality
  var dataURL = canvas.toDataURL("image/jpeg", 0.7);

  // Send the data URL to the server using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open('POST', './save_image', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('dataURL=' + encodeURIComponent(dataURL));
  }
</script>

<script>
  function halfday() {
  // Get the video and canvas elements
  var video = document.getElementById('video');
  var canvas = document.getElementById('canvas');

  // Set the canvas dimensions to match the video
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw the current frame of the video onto the canvas
  var context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Convert the canvas to a data URL with specified format and quality
  var dataURL = canvas.toDataURL("image/jpeg", 0.7);

  // Send the data URL to the server using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open('POST', './halfday', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('dataURL=' + encodeURIComponent(dataURL));
  }
</script>

<script>
  function TimeinOT() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './time_in_OT', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send();
  }
</script>

<script>
  function CaptureTimeOutOT() {
  // Get the video and canvas elements
  var video = document.getElementById('video');
  var canvas = document.getElementById('canvas');

  // Set the canvas dimensions to match the video
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw the current frame of the video onto the canvas
  var context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Convert the canvas to a data URL with specified format and quality
  var dataURL = canvas.toDataURL("image/jpeg", 0.7);

  // Send the data URL to the server using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open('POST', './save_image_timeout', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('dataURL=' + encodeURIComponent(dataURL));
  }
</script>

<script>
  $(document).ready(function(){
    setInterval(function(){
        $.ajax({
          url: './load',
          dataType: 'json',
          success: function(data){
      var contents = '';
      $.each(data, function(index, value) {
          
        contents += '<center><div class="py-5 shadow border border-opacity-50 text-center fs-1" style="width: 300px; height: 300px;">';
        contents += '<div id="camera"><img style="max-width: 320px; max-height: 200px;" src="data:image/jpeg;base64,' + value.image_data_base64 + '" /></div>';
        contents += '</div>';

        contents += '<div class="col-12 pt-2">';
        contents += '<label for="employee_id" class="py-1 fw-bold">Employee ID</label>';
        contents += '<input class="form-control form-control-sm my-1 text-truncate w-50" type="text" placeholder="Employee ID" value="' + value.employee_id + '" name="employee_id" id="employee_id" autocomplete="off" readonly required>';
        contents += '</div>';
        contents += '<div class="col-12">';
        contents += '<label for="employee_name" class="py-1 fw-bold">Full Name</label>';
        contents += '<input class="form-control form-control-sm my-1 text-truncate w-50" type="text" placeholder="Full Name" value="' + value.employee_name + '" name="employee_name" id="employee_name" autocomplete="off" readonly required>';
        contents += '</div>';
        contents += '<div class="col-12">';
        contents += '<label for="time_in" class="py-1 fw-bold">Time In</label>';
        contents += '<input class="form-control form-control-sm my-1 w-50" type="text" placeholder="Time In" value="' + value.time_in + '" name="time_in" id="time_in" autocomplete="off" readonly required>';
        contents += '</div>';
        contents += '<div class="col-12">';
        contents += '<label for="time_out" class="py-1 fw-bold">Time Out</label>';
        contents += '<input class="form-control form-control-sm my-1 w-50" type="text" placeholder="Time Out" value="' + value.time_out + '" name="time_out" id="time_out" autocomplete="off" readonly required>';
        contents += '</div>';
        contents += '<div class="col-12">';
        contents += '<label for="time_in_OT" class="py-1 fw-bold">Time In Overtime</label>';
        contents += '<input class="form-control form-control-sm my-1 w-50" type="text" placeholder="Time In Overtime" value="' + value.time_in_OT + '" name="time_in_OT" id="time_in_OT" autocomplete="off" readonly required>';
        contents += '</div>';
        contents += '<div class="col-12">';
        contents += '<label for="time_out_OT" class="py-1 fw-bold">Time Out Overtime</label>';
        contents += '<input class="form-control form-control-sm my-1 w-50" type="text" placeholder="Time Out Overtime" value="' + value.time_out_OT + '" name="time_out_OT" id="time_out_OT" autocomplete="off" readonly required>';
        contents += '</div></div></center>';
        
      });
      $('#contents').html(contents);
          }

        });
    }, 5000); // Refresh every 1 second
  });
</script>

<script>
  // Tooltip
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

<script type="text/javascript">
function updateTime(){
  var now = new Date();
  var date = now.toLocaleDateString();
  var day = now.toLocaleString('en-US', { weekday: 'long' });
  var time = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila' });
  $('#time').html(day + ', ' + date + ' ' + time);
  setTimeout(updateTime, 1000);
}
$(function(){
  updateTime();
});
</script>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
