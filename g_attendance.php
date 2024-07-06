<?php
require 'g_form_validation.php';
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guest Attendance | BERGS</title>
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
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasRight">
        <i class="fa-solid fa-user"></i>
        Profile
      </button>

       <a class="navbar-brand" href="e_dashboard">
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
              <a class="nav-link px-3 active" href="g_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="g_account">Account</a>
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
        <h2>Guest's Attendance</h2>
      </div>
      <hr>

      <button class="btn btn-sm btn-outline-primary" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" data-toggle="tooltip" title="View Table Breakdown" aria-expanded="false">
        <i class="fa-solid fa-filter"></i> View
      </button>

      <ul class="dropdown-menu px-2" aria-labelledby="multiSelectDropdown" id ="multiSelectDropdown">
        <li><label><input type="checkbox" value="0" class="checkbox-column"> Attendance Number</label></li>
        <li><label><input type="checkbox" value="1" class="checkbox-column" checked> Employee ID</label></li>
        <li><label><input type="checkbox" value="2" class="checkbox-column" checked> Full Name</label></li>
        <li><label><input type="checkbox" value="3" class="checkbox-column" checked> Time In </label></li>
        <li><label><input type="checkbox" value="4" class="checkbox-column" checked> Time Out</label></li>
        <li><label><input type="checkbox" value="5" class="checkbox-column" checked> Hours of Work</label></li>
        <li><label><input type="checkbox" value="6" class="checkbox-column" checked> Over Time In</label></li>
        <li><label><input type="checkbox" value="7" class="checkbox-column" checked> Over Time Out</label></li>
        <li><label><input type="checkbox" value="8" class="checkbox-column" checked> Hours of Over Time</label></li>
        <li><label><input type="checkbox" value="9" class="checkbox-column" checked> Image Time In</label></li>
        <li><label><input type="checkbox" value="10" class="checkbox-column" checked> Image Time Out</label></li>
        <li><label><input type="checkbox" value="11" class="checkbox-column" checked> Marked</label></li>
        
      </ul>
      
      <button class="btn btn-sm btn-outline-primary mx-1 float-end" type="button" onclick="showDeleteConfirmation('haha');" data-toggle="tooltip" title="Attendance" ><i class="fa-solid fa-clipboard-user"></i> Attendance</button>
                
                <!-- Print Monthly Options        
      <div class="btn-group mx-1 float-end">
        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="Click to see Print options">
          Print Monthly Options
        </button>
        <ul class="dropdown-menu">
            <?php
            date_default_timezone_set('Asia/Manila');
            $current_date = date('Y-m-d');
            ?>
          <li><a href="a_today_attendance_print.php?date_today=<?php echo $current_date; ?>" target="_blank" class="dropdown-item btn-outline-dark"><i class="fa-solid fa-clock"></i> Today</a></li>
          <li><button class="dropdown-item btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#mod-date"><i class="fa-solid fa-calendar-plus"></i> Choose Date</button></li>
          <li><button class="dropdown-item btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#mod-monthyear"><i class="fa-solid fa-calendar"></i> Choose Month and Year</button></li>
        </ul>
      </div>
      <br>
      <br>
        --> 
      <script>
function showDeleteConfirmation(haha) {
    Swal.fire({
        title: 'ATTENDANCE',
        text: 'Do you want to time-in or time-out your attendance?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with deletion

      window.location.href = './E_FaceRecognition/e_facerecog';


        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Handle cancel button click event
            Swal.fire(
                'Cancelled Operation',
                'Click Yes next time if you want to logged your Time In or Time Out your attendance.',
                'question'
            );
        }
    });
}
</script>

                  <br>
                              <br>
      <div class="pt-2" style="overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered" id="attendanceTable">
          <thead>
            <tr class="text-center table-active text-truncate fw-bold">
              <td scope="col" class = "text-center" data-column="0" >Attendance Number</td>
              <td scope="col" class = "text-center" data-column="1" >Employee ID</td>
              <td scope="col" class = "text-center" data-column="2" >Full Name</td>
              <td scope="col" class = "text-center" data-column="3" >Time In</td>
              <td scope="col" class = "text-center" data-column="4" >Time Out</td>
              <td scope="col" class = "text-center" data-column="5" >Hours of Work</td>
              <td scope="col" class = "text-center" data-column="6" >Over Time In</td>
              <td scope="col" class = "text-center" data-column="7" >Over Time Out</td>
              <td scope="col" class = "text-center" data-column="8" >Hours of Over Time</td>
              <td scope="col" class = "text-center" data-column="9" >Image Time In</td>
              <td scope="col" class = "text-center" data-column="10" >Image Time Out</td>
               <td scope="col" class = "text-center" data-column="11" >Marked</td>

            </tr>
          </thead>

          <tbody>
            <?php
            include ("dbconn.php");
            date_default_timezone_set("Asia/Manila");
            $haha = date("Y-m-d");
            $id = $_SESSION['id'];
            $i=0;
            $sql = "SELECT * FROM bergs_attendance WHERE employee_id = '$id' ORDER BY date DESC";
            if($rs=$conn->query($sql)){
                while ($row=$rs->fetch_assoc()) {
                    $i++;

                    $start_time = $row['time_in'];
                    $end_time = $row['time_out'];

                    // Convert the start and end times to UNIX timestamps
                    $start_timestamp = strtotime($start_time);
                    $end_timestamp = strtotime($end_time);


                    if($row['time_in_OT'] != null){

                    $time3 = strtotime($row['time_in_OT']); // convert the time string to a Unix timestamp
                    $time_in_OT = date('F d Y, g:iA', $time3);

                    }else{
                      $time_in_OT = $row['time_in_OT'];
                    }

                    if($row['time_out_OT'] != null){

                      $time4 = strtotime($row['time_out_OT']); // convert the time string to a Unix timestamp
                      $time_out_OT = date('F d Y, g:iA', $time4);

                      }else{
                        $time_out_OT = $row['time_out_OT'];
                      }

                  if($row['time_out'] != null){

                    $time2 = strtotime($row['time_out']); // convert the time string to a Unix timestamp
                    $time_out = date('F d Y, g:iA', $time2);

                    }else{
                      $time_out = $row['time_out'];
                    }

                    if($row['time_in'] != null){

                      $time1 = strtotime($row['time_in']); // convert the time string to a Unix timestamp
                      $time_in = date('F d Y, g:iA', $time1);

                      }else{
                        $time_in = $row['time_in'];
                      }



                    $total_hours = $row['hours_of_work'];
                    $total_hours_OT = $row['hours_of_overtime'];

                    $time_in_img = $row['timein_image'];
                    $time_in_base64 = base64_encode($time_in_img);
                    $time_out_img = $row['timeout_image'];
                    $time_out_base64 = base64_encode($time_out_img);
                  ?>

                  <td class = "align-middle" data-column="0"><?php echo $i; ?></td>
                  <td class = "align-middle" data-column="1"><?php echo $row['employee_id']; ?></td>
                  <td class = "align-middle" data-column="2"><?php echo $row['employee_name']; ?></td>
                  <td class = "align-middle" data-column="3"><?php echo $time_in; ?></td>
                  <td class = "align-middle" data-column="4"><?php echo $time_out; ?></td>
                  <td class = "align-middle" data-column="5"><?php echo $total_hours ?></td>
                  <td class = "align-middle" data-column="6"><?php echo $time_in_OT; ?></td>
                  <td class = "align-middle" data-column="7"><?php echo $time_out_OT; ?></td>
                  <td class = "align-middle" data-column="8"><?php echo $total_hours_OT  ?></td>
                  <td class= "align-middle rounded text-center" width="100px" data-column="9"> <img style = "max-width: 100px; max-height: 100px;" src="data:image/jpeg;base64,<?php echo $time_in_base64; ?>" /></td>
                  <td class= "align-middle rounded text-center" width="100px" data-column="10"> <img style = "max-width: 100px; max-height: 100px;" src="data:image/jpeg;base64,<?php echo $time_out_base64; ?>" /></td>
                  <td class = "align-middle" data-column="11"><?php echo $row['marked']; ?></td>

                </tr>
                    <?php
                    }
                    }?>
          </tbody>
        </table>










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
  
  
   
   <!-- Modal for Date-->
 <div class="modal fade" id="mod-date" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Print Attendance for Date</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body h-100 justify-content-center">
                <div class="row">
                    <div class="col-9 py-2">
                        <input class="form-control" type="date" placeholder="Date" required>
                    </div>
                    <div class="col-3 py-2 text-start">
                        <a href="#" id="select-date-link" target="_blank" class="btn btn-sm btn-outline-primary mx-2" onclick="return checkDate()">Select Date</a>
                        <script>
                            const selectDateLink = document.querySelector('#select-date-link');
                            const input = document.querySelector('input[type="date"]');
                            function checkDate() {
                                if (input.value.trim() === '') {
                                    return false;
                                } else {
                                    const selectedDate = new Date(input.value); // creates a Date object from the input value
                                    const year = selectedDate.getFullYear();
                                    const month = ('0' + (selectedDate.getMonth() + 1)).slice(-2); // adds leading zero if necessary
                                    const day = ('0' + selectedDate.getDate()).slice(-2); // adds leading zero if necessary
                                    const formattedDate = `${year}-${month}-${day}`;
                                    const url = `a_specdate_attendance_print.php?date_selected=${formattedDate}`;
                                    selectDateLink.href = url;
                                    return true;
                                }
                            }
                            input.addEventListener('input', checkDate);
                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            </div>
        </div>
    </div>
</div>

    
     <!-- Modal for Month & Year-->
<div class="modal fade" id="mod-monthyear" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Print Attendance for Month & Year</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body h-100 justify-content-center">
                <div class="row">
                    <div class="col-8 py-2">
                        <input class="form-control" type="month" placeholder="Month & Year" name="" autocomplete="off" required>
                    </div>
                    <div class="col-4 py-2 text-start">
                        <a id="select-month-year-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary mx-2" onclick="return checkMonthYear()">Select Month & Year</a>
                        <script>
                            const monthYearLink = document.querySelector('#select-month-year-link');
                            const monthYearInput = document.querySelector('input[type="month"]');
                            function checkMonthYear() {
                                if (monthYearInput.value.trim() === '') {
                                    return false;
                                } else {
                                    const selectedDate = new Date(monthYearInput.value + '-01'); // creates a Date object from the input value and adds '-01' to set the day to the first of the month
                                    const year = selectedDate.getFullYear();
                                    const month = ('0' + (selectedDate.getMonth() + 1)).slice(-2); // adds leading zero if necessary
                                    const formattedDate = `${year}-${month}`;
                                    const url = `a_specmonth_attendance_print.php?date_month=${formattedDate}`;
                                    monthYearLink.href = url;
                                    return true;
                                }
                            }
                            monthYearInput.addEventListener('input', checkMonthYear);
                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
  // Define a function to show/hide the corresponding table column based on the checkbox state
  function toggleTableColumns() {
    $('.checkbox-column').each(function() {
      var columnIndex = $(this).val();
      $('td[data-column="' + columnIndex + '"]').toggle($(this).is(':checked'));
    });
  }

  // Loop through each checkbox and check if it has a saved state in localStorage
  $('.checkbox-column').each(function() {
    var columnIndex = $(this).val();
    var isChecked = localStorage.getItem('checkbox_' + columnIndex);

    // If a saved state exists, update the checkbox state accordingly
    if (isChecked === 'true') {
      $(this).prop('checked', true);
    } else if (isChecked === 'false') {
      $(this).prop('checked', false);
    }

    // Add a change event listener to the checkbox to update its saved state and show/hide the corresponding table column
    $(this).on('change', function() {
      localStorage.setItem('checkbox_' + columnIndex, $(this).is(':checked'));
      toggleTableColumns();
    });
  });

  // Show/hide the corresponding table column on page load
  toggleTableColumns();

  $('#modifyTableBtn').on('click', function() {
    $('#attendanceTable').toggleClass('table-striped');
  });
});
</script>

<script>
  // Tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php } ?>
