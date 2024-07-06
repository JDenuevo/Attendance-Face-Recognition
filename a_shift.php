<?php
include("dbconn.php");
require 'a_form_validation.php';
date_default_timezone_set("Asia/Manila");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Shift | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Jquery Table -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">

<!--Main Navigation-->
  <nav class="navbar navbar-expand-lg navbar-expand-md shadow p-1 rounded fixed-top" id="navbar" style="background-color: #DAEAF1;">
    <div class="container-fluid mx-auto">

      <!-- OffCanvas Left Navigation Bar -->
      <button class="btn btn-sm btn-primary" id="ocleft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasRight">
        <i class="fa-solid fa-user"></i>
        Profile
      </button>

      <a class="navbar-brand" href="login_form">
        <img src="photos/bergslogo.png" class="img-fluid px-1" width="80px">
      </a>

      <!-- OffCanvas Right Navigation Bar -->
      <button class="btn btn-sm btn-primary" id="ocleft" type="button" href="#offcanvasRight" data-bs-toggle="offcanvas" aria-controls="navbarSupportedContent">
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
              <a class="nav-link px-3" href="a_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="a_list">List of Employees</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="a_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="a_account">Account</a>
            </li>
          </ul>


          <form class="d-flex" action="logout.php"role="button">
            <a href="login_form">
            <button class="btn border-0 ms-3 px-3" data-toggle="tooltip" data-placement="top" title="Sign Out" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
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
      <div class="position-sticky list-group pt-2"><br><br><br>
        <?php
          $employee_id = $_SESSION['id'];

          $sql = "SELECT * FROM bergs_login WHERE id = '$employee_id'";
          $result = $conn->query($sql);
          while ($row=$result->fetch_assoc()) {

            $image_data = $row['image'];
            // Convert image data to base64-encoded string
            $image_data_base64 = base64_encode($image_data);
            ?>

            <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-100 py-4 px-2 rounded-circle">

        <label class="fw-italic"><?php echo $row['title'] ?> <br> <span class = "fw-bold"><?php echo $row['full_name'] ?></span></label>

        <?php } ?>

        <hr>
        <ul class="nav flex-column d-md-block">
          <li class="nav-item dropdown dropup-center dropup pb-1" id="myDropdown">
          <label class = "pb-2 fs-5 ms-1">Board</label>

          <li class="nav-item pb-1">
            <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="a_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
          </li>

          <li class="nav-item pb-1">
            <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="a_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
          </li>

          <hr>

          <label class = "pb-2 fs-5 ms-1">Manage</label>
              
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="a_department" data-toggle="tooltip" title="Department"><i class="fa-solid fa-building"></i> Department</a>
            </li>

            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="a_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>
            
            
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded active" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
            </li>

        </ul>
        <br><br>
      </div>
    </nav>

    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>Admin Timetable Shift Maintenance</h2>
      </div>
      <hr>

      <div class="text-end">
        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#add_shift" type="button" data-toggle="tooltip" data-placement="left" title="Create new Shift!"> <i class="fa-solid fa-plus"></i> Create New</button>
      </div>

      <div class="pt-2" style="overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered">
          <thead>
            <tr class="text-center table-active text-truncate fw-bold">
              <td scope="col">Shift Number</td>
              <td scope="col">Timetable Name</td>
              <td scope="col">On Duty Time</td>
              <td scope="col">Off Duty Time</td>
              <td scope="col">Late Grace Period (Minutes)</td>
              <td scope="col">Early Leave (Minutes)</td>
              <td scope="col">Beginning Time In</td>
              <td scope="col">End Time In</td>
              <td scope="col">Beginning Time Out</td>
              <td scope="col">End Time Out</td>
              <td scope="col">Beginning Overtime In</td>
              <td scope="col">End Overtime In</td>
              <td scope="col">Beginning Overtime Out</td>
              <td scope="col">End Overtime Out</td>
              <td scope="col">Actions</td>
            </tr>
          </thead>

          <tbody>

            <?php
                    $i=0;
                    $sql = "SELECT * FROM bergs_shift";
                    if($rs=$conn->query($sql)){
                        while ($row=$rs->fetch_assoc()) {

                            $time1 = strtotime($row['shift_start']); // convert the time string to a Unix timestamp
                            $shift_start = date('g:iA', $time1);

                            $time2 = strtotime($row['shift_end']); // convert the time string to a Unix timestamp
                            $shift_end = date('g:iA', $time2);

                            if($row['beginning_in'] != NULL){
                              $time3 = strtotime($row['beginning_in']); // convert the time string to a Unix timestamp
                              $beginning_in = date('g:iA', $time3);
                            }else{
                              $beginning_in = "";
                            }
                            
                            if($row['beginning_out'] != NULL){
                              $time4 = strtotime($row['beginning_out']); // convert the time string to a Unix timestamp
                              $beginning_out = date('g:iA', $time4);
                            }else{
                              $beginning_out = "";
                            }

                            if($row['end_in'] != NULL){
                              $time5 = strtotime($row['end_in']); // convert the time string to a Unix timestamp
                              $end_in = date('g:iA', $time5);
                            }else{
                              $end_in = "";
                            }

                            if($row['end_out'] != NULL){       
                            $time6 = strtotime($row['end_out']); // convert the time string to a Unix timestamp
                            $end_out = date('g:iA', $time6);
                            }else{
                              $end_out = "";
                            }

                          if($row['beginning_ot_in'] != NULL){
                            $time9 = strtotime($row['beginning_ot_in']); // convert the time string to a Unix timestamp
                            $beginning_ot_in = date('g:iA', $time9);
                          }else{
                            $beginning_ot_in = "";
                          }
                          
                          if($row['beginning_ot_out'] != NULL){
                            $time10 = strtotime($row['beginning_ot_out']); // convert the time string to a Unix timestamp
                            $beginning_ot_out = date('g:iA', $time10);
                          }else{
                            $beginning_ot_out = "";
                          }

                          if($row['end_ot_in'] != NULL){
                            $time11 = strtotime($row['end_ot_in']); // convert the time string to a Unix timestamp
                            $end_ot_in = date('g:iA', $time11);
                          }else{
                            $end_ot_in = "";
                          }

                          if($row['end_ot_out'] != NULL){       
                          $time12 = strtotime($row['end_ot_out']); // convert the time string to a Unix timestamp
                          $end_ot_out = date('g:iA', $time12);
                          }else{
                            $end_ot_out = "";
                          }
    
                    ?>
            <tr class="text-center align-middle">
              <td class="text-center"><?php echo $row['shift_num']  ?></td>
              <td class="text-center"><?php echo $row['shift_name']  ?></td>
              <td class="text-center"><?php echo $shift_start  ?></td>
              <td class="text-center"><?php echo $shift_end  ?></td>
              <td class="text-center"><?php echo $row['late_start'] ?></td>
              <td class="text-center"><?php echo $row['leave_early'] ?></td>
              <td class="text-center"><?php echo $beginning_in ?></td>
              <td class="text-center"><?php echo $end_in ?></td>
              <td class="text-center"><?php echo $beginning_out ?></td>
              <td class="text-center"><?php echo $end_out ?></td>
              <td class="text-center"><?php echo $beginning_ot_in ?></td>
              <td class="text-center"><?php echo $end_ot_in ?></td>
              <td class="text-center"><?php echo $beginning_ot_out ?></td>
              <td class="text-center"><?php echo $end_ot_out ?></td> 
              <td class="d-flex-list justify-content-evenly align-middle" width = "150px">
                  <!--
              <button class="btn btn-sm btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#updatemodal_modify_<?php echo $row['shift_num'] ?>" type="button">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Update
                </button> -->
                
                <button type="button" class="btn btn-sm btn-primary mt-1 " data-bs-toggle="modal" data-bs-target="#updateshift_<?php echo $row['shift_num'] ?>" data-toggle="tooltip" title="Update Shift">
                  <i class="fa-solid fa-pen-to-square"></i> Update
                </button>

                <a href="#" onclick="showDeleteConfirmation('<?php echo $row['shift_num']; ?>');" class="btn btn-sm btn-danger mt-1"data-toggle="tooltip" title="Remove">
                <i class="fa-solid fa-trash"></i>
                Remove
            </a>
              </td>
            </tr>
            <?php
                        }
                      }
            ?>
          </tbody>
        </table>
      </div>

      <script>
function showDeleteConfirmation(shift_num) {
    Swal.fire({
        title: 'REMOVE SHIFT!',
        text: 'Do you want to remove the shift?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with deletion
            Swal.fire({
        icon: 'success',
        title: 'REMOVING SHIFT!',
        text: 'Data Removed Successfully',
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

      window.location.href = 'a_shift_remove.php?shift_num=' + shift_num;


        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Handle cancel button click event
            Swal.fire(
                'Cancelled',
                'Your data is safe',
                'error'
            );
        }
    });
}
</script>

    </main>
  </div>
</div>

<!-- Off Canvas for Profile Button -->
  <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header justify-content-end">
      <button type="button" class="btn-close float-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <?php
          $employee_id = $_SESSION['id'];

          $sql = "SELECT * FROM bergs_login WHERE id = '$employee_id'";
          $result = $conn->query($sql);
          while ($row=$result->fetch_assoc()) {

            $image_data = $row['image'];
            // Convert image data to base64-encoded string
            $image_data_base64 = base64_encode($image_data);
            ?>

            <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-25 px-2 rounded-circle">

        <label class="fw-italic"><?php echo $row['title'] ?> <br> <span class = "fw-bold"><?php echo $row['full_name'] ?></span></label>

        <?php } ?>

      <hr>
      <div class = "list-group">
          
        <ul class= "list-unstyled mb-0 pb-3 pb-md-2 pe-lg-2">
          <ul class = "list-unstyled fw-normal pb-2 small">
            
          </ul>

          <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="a_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded " data-toggle="tooltip" data-placement="left" title="Set a Event!" href="a_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
          </ul>

          <hr>

           <label class = "pb-2 fs-5 ms-1">Manage</label>
              
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="a_department" data-toggle="tooltip" title="Department"><i class="fa-solid fa-building"></i> Department</a>
            </li>

            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="a_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>
            
            
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded active" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
            </li>

        </ul>
      </div>
    </div>
  </div>
  
  
  
  
<!-- Update Shift -->
<?php
  $sql = "SELECT * FROM bergs_shift";
  if($rs=$conn->query($sql)){
      while ($row=$rs->fetch_assoc()) {

  ?>
<form action="a_shift_update.php" method="POST">
<div class="modal fade" id="updateshift_<?php echo $row['shift_num'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Update Shift</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col col-lg-12 col-md-12 col-sm-12">
                <label for="shift_name">Timetable Name :</label>
                <input type="hidden" name="shift_num" value="<?php echo $row['shift_num'] ?>">
                <input type="text" class="form-control" value="<?php echo $row['shift_name'] ?>" name="shift_name" id="shift_name" required>
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="start_time">On Duty Time  :</label>
                <input type="time" class="form-control" value="<?php echo $row['shift_start'] ?>" name="start_time" id="start_time" required>
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="end_time">Off Duty Time :</label>
                <input type="time" class="form-control" value="<?php echo $row['shift_end'] ?>" name="end_time" id="end_time" required>
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="late_time">Late Time (Minutes) :</label>
                <input type="number" class="form-control" value="<?php echo $row['late_start'] ?>" name="late_time" id="late_time" value ="0" min="0" required>
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="leave_early">Leave Early (Minutes) :</label>
                <input type="number" class="form-control" value="<?php echo $row['leave_early'] ?>" name="leave_early" id="leave_early" value ="0" min="0" required>
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="beginning_in">Beginning In :</label>
                <input type="time" class="form-control" value="<?php echo $row['beginning_in'] ?>" name="beginning_in" id="beginning_in" >
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="end_in">End In :</label>
                <input type="time" class="form-control" value="<?php echo $row['end_in'] ?>" name="end_in" id="end_in" >
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="beginning_out">Beginning Out :</label>
                <input type="time" class="form-control" value="<?php echo $row['beginning_out'] ?>" name="beginning_out" id="beginning_out" >
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="end_out">End Out :</label>
                <input type="time" class="form-control" value="<?php echo $row['end_out'] ?>" name="end_out" id="end_out" >
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="beginning_ot_in">Beginning Overtime In :</label>
                <input type="time" class="form-control" value="<?php echo $row['beginning_ot_in'] ?>" name="beginning_ot_in" id="beginning_ot_in" >
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="end_ot_in">End Overtime In :</label>
                <input type="time" class="form-control" value="<?php echo $row['end_ot_in'] ?>" name="end_ot_in" id="end_ot_in" >
            </div>
        </div>
        
        <div class="row row-col-2">
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="beginning_ot_out">Beginning Overtime Out :</label>
                <input type="time" class="form-control" value="<?php echo $row['beginning_ot_out'] ?>" name="beginning_ot_out" id="beginning_ot_out" >
            </div>
            
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <label for="end_ot_ou">End Overtime Out :</label>
                <input type="time" class="form-control" value="<?php echo $row['end_ot_out'] ?>" name="end_ot_out" id="end_ot_out" >
            </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close tab">Close</button>
        <button type="submit" class="btn btn-sm btn-success"  data-toggle="tooltip" name="update" data-placement="left" title="Update shift"><i class="fa-solid fa-floppy-disk"></i> Update Shift</button>
      </div>
    </div>
  </div>
</div>
</form>

<?php
    }
    }
  ?>

  <!-- Modal for Add Shift -->
<form action="a_shift_add.php" method="POST">
  <div class="modal fade" id="add_shift" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Add Shift Timetable</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row">
            <div class="col-12 col-lg-12 col-md-12 col-sm-12">
              <label for="shift_name">Timetable Name :</label>
              <input type="text" class="form-control" name="shift_name" id="shift_name" required>
            </div>

          <div class="row">
            <div class="col-12 col-lg-6 col-md-6- col-sm-12">
              <label for="start_time">On Duty Time :</label>
              <input type="time" class="form-control" name="start_time" id="start_time" required>
            </div>
            <div class="col-12 col-lg-6 col-md-6- col-sm-12">
              <label for="end_time">Off Duty Time :</label>
              <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
        </div><br>

        <div class="row">
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="late_time">Late Time (Minutes) :</label>
                  <input type="number" class="form-control" id="late_time" name="late_time" value ="0" min="0">
                </div>
                
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="leave_early">Leave Early (Minutes) :</label>
                  <input type="number" id="leave_early" name="leave_early" class="form-control" value ="0" min="0">
                </div>
            </div><br>
        
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="beginning_in">Beginning In :</label>
                  <input type="time" class="form-control" id="beginning_in" name="beginning_in" required>
                </div>
                
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="end_in">End In :</label>
                  <input type="time" id="end_in" name="end_in" class="form-control" required>
                </div>
            </div><br>

            <div class="row">
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="beginning_out">Beginning Out :</label>
                  <input type="time" class="form-control" id="beginning_out" name="beginning_out" required>
                </div>
                
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="end_out">End Out:</label>
                  <input type="time" id="end_out" name="end_out" class="form-control" required>
                </div>
            </div><br>

            <div class="row">
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="beginning_ot_in">Beginning Overtime In :</label>
                  <input type="time" class="form-control" id="beginning_ot_in" name="beginning_ot_in" >
                </div>
                
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="end_ot_in">End Overtime In :</label>
                  <input type="time" id="end_ot_in" name="end_ot_in" class="form-control" >
                </div>
            </div><br>

            <div class="row">
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="beginning_ot_out">Beginning Overtime Out :</label>
                  <input type="time" class="form-control" id="beginning_ot_out" name="beginning_ot_out" >
                </div><br>
                
                <div class="col-12 col-lg-6 col-md-6- col-sm-12">
                  <label for="end_ot_out">End Overtime Out:</label>
                  <input type="time" id="end_ot_out" name="end_ot_out" class="form-control">
                </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close tab">Close</button>
          <button type="submit" class="btn btn-sm btn-success" name="add_btn" data-toggle="tooltip" data-placement="left" title="Add new shift now!"><i class="fa-solid fa-plus"></i> Add Shift</button>
        </div>
        </div>
    </div>
    </div>
  </div>
</form>

<?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors1'])) {
    $error1 = $_GET['errors1'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'ADDING SHIFT!',
        text: '$error1',
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

    unset($_GET['errors1']);
  }
?>

  <?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors2'])) {
    $error2 = $_GET['errors2'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'UPDATING SHIFT!',
        text: '$error2',
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

    unset($_GET['errors2']);
  }
?>
  
  
<script>
  const beginningOtIn = document.getElementById('beginning_ot_in');
  const beginningOtOut = document.getElementById('beginning_ot_out');
  const endOtIn = document.getElementById('end_ot_in');
  const endOtOut = document.getElementById('end_ot_out');

  const setRequired = () => {
    if (beginningOtIn.value || beginningOtOut.value || endOtIn.value || endOtOut.value) {
      beginningOtIn.required = true;
      beginningOtOut.required = true;
      endOtIn.required = true;
      endOtOut.required = true;
    } else {
      beginningOtIn.required = false;
      beginningOtOut.required = false;
      endOtIn.required = false;
      endOtOut.required = false;
    }
  };

  beginningOtIn.addEventListener('change', setRequired);
  beginningOtOut.addEventListener('change', setRequired);
  endOtIn.addEventListener('change', setRequired);
  endOtOut.addEventListener('change', setRequired);
</script>

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
    window.location.href = "a_shift";
  }
}</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
