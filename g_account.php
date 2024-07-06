<?php
require 'g_form_validation.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guest Account | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

<!-- Jquery Table -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/display_image.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!--Main Navigation-->
  <nav class="navbar navbar-expand-lg navbar-expand-md shadow p-1 rounded fixed-top" id="navbar" style="background-color: #DAEAF1;">
    <div class="container-fluid mx-auto">

      <!-- OffCanvas Left Navigation Bar -->
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasRight">
        <i class="fa-solid fa-user"></i>
        Profile
      </button>

       <a class="navbar-brand" href="g_dashboard">
        <img src="photos/bergslogo.png" class="img-fluid px-1" width="80px">
      </a>

      <!-- OffCanvas Right Navigation Bar -->
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" href="#offcanvasRight" data-bs-toggle="offcanvas" aria-controls="navbarSupportedContent">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <img src="photos/bergs.png" class="img-fluid w-75">
          <button type="button" class="btn-close me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

          <ul class="navbar-nav m-auto">
            <li class="nav-item">
              <a class="nav-link px-3" href="g_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="g_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 active" href="g_account">Account</a>
            </li>
          </ul>


          <form class="d-flex" action="logout.php"role="button">
            <a href="login_form">
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
        
        <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-100 py-4 px-2 rounded-circle">
        <label class="fw-italic"><?php echo $row['title'] . " | " . $row['department'] ?> <br> <span class = "fw-bold"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></span></label>
        <?php } ?>
        <hr>
        <!--
        <ul class="nav flex-column d-md-block">
                                <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="e_policies" data-toggle="tooltip" title="Policies" ><i class="fa-solid fa-file-lines"></i> Policies</a></li>
            </li>
             </ul>

        </ul>
        -->
        <br><br>
      </div>
    </nav>


    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>Guest's Account</h2>
        
      </div>
      <hr>
        <a class = "text-decoration-none float-end">
            <button class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#changepass" data-toggle="tooltip" data-placement="left" title="Change Password">
                  <i class="fa-solid fa-pen-to-square"></i> Change Password
            </button>
        </a>
        
      <?php
      $employee_id = $_SESSION['id'];
      $sql = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
      if($rs=$conn->query($sql)){
          $row=$rs->fetch_assoc();
      ?>
      
<h4 class="fW-bold my-2">Information</h4>
<div class="card mx-auto border-dark">
  <div class="card-body shadow">
      
    <div class="row rows-col-3">
      <div class="col-12 col-lg-4 col-md-4 col-sm-12 ">
        <input class="form-control" type="department" value="<?php echo $row['department'] ?>" autocomplete="off" readonly>
        <center><label>Department</label></center>
      </div>

      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <?php
          $sql2 = "SELECT * FROM bergs_shift";
          $result2 = mysqli_query($conn, $sql2);
          $selected_shift = ''; // Variable to store the selected shift value
          while($row2 = mysqli_fetch_array($result2)) {
              $selected = ($row['shift_num'] == $row2['shift_num']) ? 'selected' : '';
              $start_time = date('g:i A', strtotime($row2['shift_start']));
              $end_time = date('g:i A', strtotime($row2['shift_end']));
              if ($selected == 'selected') {
                  // If the current shift is selected, store the shift times in the variable
                  $selected_shift = $start_time . ' to ' . $end_time;
              }
          }
          ?>
          <input class="form-control" id="inputGroupSelect01" name="shift" type="text" readonly value="<?php echo $selected_shift ?>" readonly>
         <?php
            }
          ?>
          <center><label>Shift</label><br></center>
      </div>
      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <input class="form-control" type="text" placeholder="Card Number" name="cardnum" value="<?php echo $row['cardnum'] ?>" autocomplete="off" readonly>
          <center><label>Card Number</label></center>
      </div>
    </div>
    <br>
    <div class="row rows-col-3">
      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
        <input class="form-control" type="date" placeholder="Date of Employment" name="date_of_employment" value="<?php echo $row['date_of_employment'] ?>" autocomplete="off" readonly>
        <center><label>Date of Employment</label></center>
      </div>
      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
        <input class="form-control" type="text" placeholder="Title" name="title" value="<?php echo $row['title'] ?>" autocomplete="off" readonly>
        <center><label>Title</label></center>
      </div>
      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <input class="form-control" type="text" placeholder="Privilege" name="privilege" value="<?php echo $row['privilege'] ?>" autocomplete="off" readonly>
          <center><label>Privilege</label><br></center>
      </div>
    </div>
    <br>
    <div class="row rows-col-3">
      <div class="col-12 col-lg-4 col-md-4 col-sm-12 ">
          <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
          <input class="form-control" type="text" placeholder="Dela Cruz" name="lname" value="<?php echo $row['lname'] ?>" autocomplete="off" readonly>
          <center><label>Last Name</label></center>
      </div>

      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <input class="form-control" type="text" placeholder="Juan" name="fname" value="<?php echo $row['fname'] ?>" autocomplete="off" readonly>
          <center><label>First Name</label><br></center>
      </div>

      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <input class="form-control" type="text" placeholder="Rivera" name="mname" value="<?php echo $row['mname'] ?>" autocomplete="off" readonly>
          <center><label>Middle Name</label><br></center>
      </div>
    </div>
    <br>
    <div class="row rows-col-3">
      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
          <input class="form-control" type="date" value="<?php echo $row['bday'] ?>" autocomplete="off" readonly>
          <center><label>Birthday</label></center>
      </div>

      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
        <input class="form-control" type="gender" value="<?php echo $row['gender'] ?>" autocomplete="off" readonly>
        <center><label>Gender</label></center>
      </div>

      <div class="col-12 col-lg-4 col-md-4 col-sm-12">
        <input class="form-control" type="text"value="<?php echo $row['contact_number'] ?>" autocomplete="off" readonly>
        <center><label>Contact no.</label></center>
      </div>
    </div>
    <br>
    <div class="row rows-col-3">
        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
            <input class="form-control" type="text" placeholder="Office Tel" name="office_tel" value="<?php echo $row['office_tel'] ?>" autocomplete="off" readonly>
            <center><label>Office Tel</label></center>
        </div>
        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
            <input class="form-control" type="text" placeholder="Nationality" name="nationality" value="<?php echo $row['nationality'] ?>" autocomplete="off" readonly>
            <center><label>Nationality</label></center>
        </div>
        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
            <input class="form-control" type="text" placeholder="City" value="<?php echo $row['city'] ?>" autocomplete="off" readonly>
            <center><label>City</label></center><br>
        </div>
        <script>
        const cityInput = document.querySelector('input[name="city"]');
        cityInput.addEventListener('keypress', function(event) {
          const key = event.key;
          const regex = /[a-z A-Z]/;
          if (!regex.test(key)) {
            event.preventDefault();
          }
        });
      </script>
    </div>
    <div class="row rows-col-2">
      <div class="col-12 col-lg-6 col-md-6 col-sm-12">
        <input class="form-control" type="text" placeholder="Address" value="<?php echo $row['address'] ?>" autocomplete="off" readonly>
        <center><label>Home Address</label></center><br>
      </div>

      <form action="g_change_password.php" method="POST">

      <div class="col-12 col-lg-6 col-md-6 col-sm-12">
        <input class="form-control" name="email" type="text" placeholder="email@gmail.com" value="<?php echo $row['email'] ?>" autocomplete="off" readonly>
        <center><label>Email</label></center>
      </div>

    </div>

  </div>
</div>
<br><br>
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
        <label class="fw-italic"><?php echo $row['title'] . " | " . $row['department'] ?> <br> <span class = "fw-bold"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></span></label>
        <?php } ?>

      <hr>

      <div class = "list-group">
        <ul class= "list-unstyled mb-0 pb-3 pb-md-2 pe-lg-2">
          <ul class = "list-unstyled fw-normal pb-2 small">
          </ul>

          <hr>

                      <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="e_policies" data-toggle="tooltip" title="Policies" ><i class="fa-solid fa-file-lines"></i> Policies</a></li>
            </li>
             </ul>

        </ul>
      </div>
    </div>
  </div>

   <!-- Modal Change Password -->

<input type="hidden" name="password" value="">
    
    <div class="modal fade modal-lg" id="changepass" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-b">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row row-col-2">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <input class="form-control" type="text" placeholder="New Password" id="new_password" name="new_password" autocomplete="off" required>
                            <center><label>New Password</label></center>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <input class="form-control" type="text" placeholder="Confirm Password" id="confirm_password" name="confirm_password" autocomplete="off" required>
                            <center><label>Confirm Password</label></center>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" type="submit" name="change_password">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors'])) {
    $error = $_GET['errors'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'CHANGE PASSWORD DONE!',
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
  
<script>
  // Tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

  <script>
if (window.performance) {
  if (performance.navigation.type == 1) {
    // Reloaded the page using the browser's reload button
    window.location.href = "e_account";
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>