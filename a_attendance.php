<?php
require 'a_form_validation.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Attendance | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

<!-- Jquery Table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">
<body>
<!--Main Navigation-->
  <nav class="navbar navbar-expand-lg navbar-expand-md shadow p-1 rounded fixed-top" id="navbar" style="background-color: #DAEAF1;">
    <div class="container-fluid mx-auto">

      <!-- OffCanvas Left Navigation Bar -->
      <button class="btn btn-primary btn-sm" id="ocleft" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasRight">
        <i class="fa-solid fa-user"></i>
        Profile
      </button>

      <a class="navbar-brand" href="login_form">
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
              <a class="nav-link px-3" href="a_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="a_list">List of Employees</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 active" href="a_attendance">Attendance</a>
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

        <label class="fw-italic"><?php echo $row['position'] ?> <br> <span class = "fw-bold"><?php echo $row['full_name'] ?></span></label>

        <?php } ?>
        <hr>
        <ul class="nav flex-column d-md-block">
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
                <a class="nav-link list-group-item border text-truncate rounded" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
            </li>

        </ul>
        <br><br>
      </div>
    </nav>


    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>Employee's Attendance</h2>
      </div>
      <hr>

      <button class="btn btn-sm btn-outline-primary mx-1 my-1" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-filter"></i> View
      </button>

      <ul class="dropdown-menu px-2" aria-labelledby="multiSelectDropdown" id ="multiSelectDropdown">
        <li><label><input type="checkbox" value="1" class="checkbox-column" checked> Employee ID</label></li>
        <li><label><input type="checkbox" value="2" class="checkbox-column" checked> Full Name</label></li>
        <li><label><input type="checkbox" value="3" class="checkbox-column" checked> Time In </label></li>
        <li><label><input type="checkbox" value="4" class="checkbox-column" checked> Time Out</label></li>
        <li><label><input type="checkbox" value="5" class="checkbox-column" checked> Hours of Work</label></li>
        <li><label><input type="checkbox" value="6" class="checkbox-column" checked> Overtime In</label></li>
        <li><label><input type="checkbox" value="7" class="checkbox-column" checked> Overtime Out</label></li>
        <li><label><input type="checkbox" value="8" class="checkbox-column" checked> Hours of Over Time</label></li>
        <li><label><input type="checkbox" value="9" class="checkbox-column" checked> Time In Image</label></li>
        <li><label><input type="checkbox" value="10" class="checkbox-column" checked> Time Out Image</label></li>
        <li><label><input type="checkbox" value="11" class="checkbox-column" checked> Marked</label></li>
      </ul>
      
            <button class="btn btn-sm btn-outline-primary mx-1 float-end" type="button" onclick="showDeleteConfirmation('haha');" title="Attendance" ><i class="fa-solid fa-clipboard-user"></i> Attendance Login</button>
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
            <div class="btn-group mx-1 float-end">
                <button class="btn btn-sm btn-outline-secondary" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="Click to see more Actions">
                    Attendance Options <i class="fa-solid fa-caret-down"></i> 
                </button>
                <ul class="dropdown-menu dropdown-menu-light text-small shadow text-center">
                    <li>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#a_summary_monthly" aria-expanded="false" data-toggle="tooltip" data-placement="left" title="Attendance Summary">
                            <i class="fa-solid fa-table-list"></i>
                            Attendance Summary
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-sm btn-outline-secondary mt-1" type="button" data-bs-toggle="modal" data-bs-target="#a_summary" aria-expanded="false" data-toggle="tooltip" data-placement="left" title="Attendance Information">
                            <i class="fa-solid fa-table-list"></i>
                            Attendance Information
                        </button>
                    </li>
                </ul>      
            </div>
        
      <br>
      <br>
      <div class="pt-2" style="overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered" id="attendanceTable">
          <thead>
            <tr class="text-center table-active text-truncate">
              <td scope="col" class = "text-center" data-column="0" hidden>Attendance Number</td>
              <td scope="col" class = "text-center" data-column="1" >Employee ID</td>
              <td scope="col" class = "text-center" data-column="2" >Full Name</td>
              <td scope="col" class = "text-center" data-column="3" >Time In</td>
              <td scope="col" class = "text-center" data-column="4" >Time Out</td>
              <td scope="col" class = "text-center" data-column="5" >Hours of Work</td>
              <td scope="col" class = "text-center" data-column="6" >Overtime In</td>
              <td scope="col" class = "text-center" data-column="7" >Overtime Out</td>
              <td scope="col" class = "text-center" data-column="8" >Hours of Over Time</td>
              <td scope="col" class = "text-center" data-column="9" >Time In Image</td>
              <td scope="col" class = "text-center" data-column="10" >Time Out Image</td>
              <td scope="col" class = "text-center" data-column="11" >Marked</td>

            </tr>
          </thead>

          <tbody>

            <?php
            include ("dbconn.php");
            date_default_timezone_set("Asia/Manila");
            $haha = date("Y-m-d");
            $i=0;
            $sql = "SELECT * FROM bergs_attendance ORDER BY time_in DESC";
            if($rs=$conn->query($sql)){
                while ($row=$rs->fetch_assoc()) {
                  $i++;

                  $start_time = $row['time_in'];
                  $end_time = $row['time_out'];

                  // Convert the start and end times to UNIX timestamps
                  $start_timestamp = strtotime($start_time);
                  $end_timestamp = strtotime($end_time);

                  // Calculate the difference between the start and end times in seconds
                  $HoW = $row['hours_of_work'];

                  if($row['time_in_OT'] != null){

                    $time3 = strtotime($row['time_in_OT']); // convert the time string to a Unix timestamp
                    $time_in_OT = date('F d Y, g:i A', $time3);

                    }else{
                      $time_in_OT = $row['time_in_OT'];
                    }

                    if($row['time_out_OT'] != null){

                      $time4 = strtotime($row['time_out_OT']); // convert the time string to a Unix timestamp
                      $time_out_OT = date('F d Y, g:i A', $time4);

                      }else{
                        $time_out_OT = $row['time_out_OT'];
                      }

                  if($row['time_out'] != null){

                    $time2 = strtotime($row['time_out']); // convert the time string to a Unix timestamp
                    $time_out = date('F d Y, g:i A', $time2);

                    }else{
                      $time_out = $row['time_out'];
                    }

                    if($row['time_in'] != null){

                      $time1 = strtotime($row['time_in']); // convert the time string to a Unix timestamp
                      $time_in = date('F d Y, g:i A', $time1);

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

                  <td class = "align-middle" data-column="0" hidden><?php echo $i; ?></td>
                  <td class = "align-middle" data-column="1"><?php echo $row['employee_id']; ?></td>
                  <td class = "align-middle" data-column="2"><?php echo $row['employee_name']; ?></td>
                  <td class = "align-middle" data-column="3"><?php echo $time_in; ?></td>
                  <td class = "align-middle" data-column="4"><?php echo $time_out; ?></td>
                  <td class = "align-middle" data-column="5"><?php echo $total_hours ?></td>
                  <td class = "align-middle" data-column="6"><?php echo $time_in_OT; ?></td>
                  <td class = "align-middle" data-column="7"><?php echo $time_out_OT; ?></td>
                  <td class = "align-middle" data-column="8"><?php echo $total_hours_OT;  ?></td>
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

          $sql = "SELECT * FROM bergs_login WHERE id = '$employee_id'";
          $result = $conn->query($sql);
          while ($row=$result->fetch_assoc()) {

            $image_data = $row['image'];
            // Convert image data to base64-encoded string
            $image_data_base64 = base64_encode($image_data);
            ?>

            <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-25 px-2 rounded-circle">

        <label class="fw-italic"><?php echo $row['position'] ?> <br> <span class = "fw-bold"><?php echo $row['full_name'] ?></span></label>

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
                <a class="nav-link list-group-item border text-truncate rounded" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
            </li>

        </ul>
      </div>
    </div>
  </div>

<!-- Modal for Monthly-->
<form id="myForm" action="a_export.php" method="POST" target="_blank">
    <div class="modal fade" id="a_summary_monthly" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Monthly Attendance Summary</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body h-100 justify-content-center">
                    <div class="row">
                        <div class="col-7 py-2">
                            <input class="form-control" type="month" placeholder="Monthly" name="month" autocomplete="off" required>
                        </div>
                        <div class="col-5 py-2 text-start">
                            <a id="select-month-year-link" href="#" target="_blank" class="btn btn-outline-primary mx-2" onclick="return checkMonthYear()">Select Month & Year</a>
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
                                        const url = `a_specmonth.php?date_month=${formattedDate}`;
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
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                    <button class="btn btn-sm btn-success" type="submit" name="export" data-toggle="tooltip" data-placement="left" title="Export Excel"><i class="fa-solid fa-file-export"></i> Export Excel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal for Attendance -->
    <form id="myForm" action="a_attendance_print.php" method="POST" target="_blank">
        <div class="modal fade" id="a_summary" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Attendance</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body h-100 justify-content-center">
                        <div class="row">
                            <div class="col-12 mt-2">
                            <div class="form-check">
                        <input class="form-check-input" type="radio" name="by_employee" id="radio1" onclick="handleRadioClick('dropdownDiv1')" >
                        <label class="form-check-label" for="radio1">
                            By Employee
                        </label>
                    </div>
                    
                    <div class="dropdown mt-3" id="dropdownDiv1" style="display: none;">
                        <select class="form-select" type="button" value="" name="by_employee_select" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <option selected value="">Select Employee</option>
                            <?php
                            $sql2 = "SELECT * FROM bergs_registration WHERE privilege = 'Employee' OR privilege = 'HR Staff' OR privilege = 'Administrator'";
                            $result2 = $conn->query($sql2);
                            while ($row2 = $result2->fetch_assoc()) {
                                $fullname = $row2['lname'] . ', ' . $row2['fname'] . ' ' . $row2['mname'];
                            ?>
                                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['id'] . ' | ' . $fullname; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <br>
                    
                    <div class="col-12 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="by_department" id="radio2" onclick="handleRadioClick('dropdownDiv2')">
                            <label class="form-check-label" for="radio2">
                                By Department
                            </label>
                        </div>
                    
                      <div class="dropdown mt-3" id="dropdownDiv2" style="display: none;">
                      <select class="form-select" name="by_department_select" id="dropdownMenuButton2" aria-haspopup="true" aria-expanded="false" onchange="showEmployeeOptions()">
                        <option selected value="">Select Department</option>
                        <?php
                        $sql3 = "SELECT * FROM bergs_department";
                        $result3 = $conn->query($sql3);
                        while ($row3 = $result3->fetch_assoc()) {
                          echo "<option value='{$row3['dep_name']}'>{$row3['dep_name']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    
                    <div class="dropdown mt-3" id="dropdownDiv3" style="display: none;">
                      <select class="form-select" name="by_department_employee" id="dropdownMenuButton3" aria-haspopup="true" aria-expanded="false">
                        <option value="all">Select All Employees Under this Department</option>
                        <?php
                        $sql2 = "SELECT * FROM bergs_registration";
                        $result2 = $conn->query($sql2);
                        while ($row2 = $result2->fetch_assoc()) {
                          $fullname = $row2['lname'] . ', ' . $row2['fname'] . ' ' . $row2['mname'];
                          echo "<option value='{$row2['id']}' data-department='{$row2['department']}' style='display: none;'>{$row2['id']} | {$fullname}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    
                    <script>
                      function showEmployeeOptions() {
                        var departmentSelect = document.getElementById('dropdownMenuButton2');
                        var employeeSelect = document.getElementById('dropdownMenuButton3');
                        var employeeOptions = employeeSelect.getElementsByTagName('option');
                    
                        var selectedDepartment = departmentSelect.value;
                    
                        // Hide all employee options except "Select All Employees"
                        for (var i = 0; i < employeeOptions.length; i++) {
                          if (employeeOptions[i].value === 'all') {
                            employeeOptions[i].style.display = 'block';
                          } else {
                            employeeOptions[i].style.display = 'none';
                          }
                        }
                    
                        if (selectedDepartment !== '') {
                          // Show the employee options for the selected department
                          var options = employeeSelect.querySelectorAll("option[data-department='" + selectedDepartment + "']");
                          for (var i = 0; i < options.length; i++) {
                            options[i].style.display = 'block';
                          }
                          
                          employeeSelect.value = 'all'; // Set the default option to "Select All Employees"
                        } else {
                          employeeSelect.value = ''; // Empty the selected option
                        }
                    
                        document.getElementById('dropdownDiv3').style.display = 'block';
                      }
                    </script>
                    </div>
                    
                    <br>
                    
                    <div class="col-12 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="by_guest" id="radio4" onclick="handleRadioClick('dropdownDiv4')">
                            <label class="form-check-label" for="radio4">
                                By Guest
                            </label>
                        </div>
                    </div>
                    
                    <div class="dropdown mt-3" id="dropdownDiv4" style="display: none;">
                        <select class="form-select" type="button" value="" name="by_guest_select" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <option selected value="all_guest">Select All Guests</option>
                            <?php
                            $sql2 = "SELECT * FROM bergs_registration WHERE privilege = 'Guest'";
                            $result2 = $conn->query($sql2);
                            while ($row2 = $result2->fetch_assoc()) {
                                $fullname = $row2['lname'] . ', ' . $row2['fname'] . ' ' . $row2['mname'];
                            ?>
                                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['id'] . ' | ' . $fullname; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <br>
                    
                    <div class="col-12 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="by_all" id="radio3" onclick="handleRadioClick('')">
                            <label class="form-check-label" for="radio3">
                                By All
                            </label>
                        </div>
                    </div>

               </div>
                           <script>
                            function handleRadioClick(dropdownDivId) {
                                var dropdownDiv1 = document.getElementById('dropdownDiv1');
                                var dropdownSelect1 = dropdownDiv1.querySelector('select');
                                var dropdownDiv2 = document.getElementById('dropdownDiv2');
                                var dropdownSelect2 = dropdownDiv2.querySelector('select');
                                var dropdownDiv4 = document.getElementById('dropdownDiv4');
                                var dropdownSelect4 = dropdownDiv4.querySelector('select');
                                var radios = document.querySelectorAll('input[type="radio"]');
                        
                                if (dropdownDivId === 'dropdownDiv1') {
                                    dropdownDiv1.style.display = 'block';
                                    dropdownSelect1.required = true;
                                    dropdownDiv2.style.display = 'none';
                                    dropdownSelect2.required = false;
                                    dropdownDiv4.style.display = 'none';
                                    dropdownSelect4.required = false;
                                } else if (dropdownDivId === 'dropdownDiv2') {
                                    dropdownDiv1.style.display = 'none';
                                    dropdownSelect1.required = false;
                                    dropdownDiv2.style.display = 'block';
                                    dropdownSelect2.required = true;
                                    dropdownDiv4.style.display = 'none';
                                    dropdownSelect4.required = false;
                                }else if (dropdownDivId === 'dropdownDiv4') {
                                    dropdownDiv1.style.display = 'none';
                                    dropdownSelect1.required = false;
                                    dropdownDiv2.style.display = 'none';
                                    dropdownSelect2.required = false;
                                    dropdownDiv4.style.display = 'block';
                                    dropdownSelect4.required = true;
                                } else {
                                    dropdownDiv1.style.display = 'none';
                                    dropdownSelect1.required = false;
                                    dropdownDiv2.style.display = 'none';
                                    dropdownSelect2.required = false;
                                    dropdownDiv4.style.display = 'none';
                                    dropdownSelect4.required = false;
                                }
                        
                                // Deselect other radio buttons
                                radios.forEach(function (radio) {
                                    if (radio !== event.target) {
                                        radio.checked = false;
                                    }
                                });
                            }
                        </script>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                            <label>Select Start Date</label>
                            <input class="form-control" type="date" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-6">
                            <label>Select End Date</label>
                            <input class="form-control" type="date" id="end_date" name="end_date" required>
                        </div>
                        
                        <script>
                            // Get references to the start date and end date input elements
                            var startDateInput = document.getElementById('start_date');
                            var endDateInput = document.getElementById('end_date');
                        
                            // Add an event listener to the end date input to check for changes
                            endDateInput.addEventListener('change', function() {
                                var startDate = new Date(startDateInput.value);
                                var endDate = new Date(endDateInput.value);
                        
                                // Compare the start date and end date
                                if (endDate < startDate) {
                                    alert("End date cannot be before the start date. Please select a valid end date.");
                                    endDateInput.value = ''; // Clear the invalid end date value
                                }
                            });
                        </script>
                        </div>
                        <br><br><br>
                        <hr> 
                        <style>
                            .checkbox-label {
                                display: block;
                                margin-bottom: 10px;
                                cursor: pointer;
                            }
                        </style>

                        <label>Select Columns:</label><br>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="employee_id" checked>
                            Employee ID
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="employee_name" checked>
                            Employee Name
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="date" checked>
                            Date
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="time_in" checked>
                            Time In
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="time_out" checked>
                            Time Out
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="time_in_OT" >
                            Time In Overtime
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="time_out_OT" >
                            Time Out Overtime
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="company_name">
                            Company Name
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="late_min">
                            Late in Minutes
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="early">
                            Early in Minutes
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="columns[]" value="marked">
                            Marked As
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
                        <button class="btn btn-sm btn-success" type="submit" name="print" data-toggle="tooltip" data-placement="left" title="Print" onclick="validateForm()"><i class="fa-solid fa-print"></i> Print</button>
                        <button class="btn btn-sm btn-success" type="submit" name="export" data-toggle="tooltip" data-placement="left" title="Export Excel" onclick="validateForm()"><i class="fa-solid fa-file-export"></i> Export Excel</button>
                    </div>
                </div>
            </div>
            <script>
                function validateForm() {
                    // Check if a radio button is selected
                    if (!$('input[name="by_employee"]:checked').val() && !$('input[name="by_department"]:checked').val() && !$('input[name="by_guest"]:checked').val() && !$('input[name="by_all"]:checked').val()) {
                        alert('Please select a radio button.');
                        return false;
                    }
                    
                    if ($('input[name="by_employee"]:checked').val() && !$('select[name="by_employee_select"]').val()) {
                        alert('Please select an employee.');
                        return false;
                    }
                    
                    if ($('input[name="by_department"]:checked').val() && !$('select[name="by_department_select"]').val()) {
                        alert('Please select a department.');
                        return false;
                    }
                    
                    if ($('input[name="by_guest"]:checked').val() && !$('select[name="by_guest_select"]').val()) {
                        alert('Please select a guest.');
                        return false;
                    }
                    
                    // If everything is selected, submit the form
                    return true;
                }
</script>
        </form>

 

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
  function showDropdown(dropdownId) {
    var dropdownDiv = document.getElementById(dropdownId);
    var allDropdowns = document.getElementsByClassName("dropdown");

    // Toggle the display of the specific dropdown menu
    if (dropdownDiv.style.display === "none" || dropdownDiv.style.display === "") {
      // Hide all dropdown menus
      for (var i = 0; i < allDropdowns.length; i++) {
        allDropdowns[i].style.display = "none";
      }

      // Show the specific dropdown menu
      dropdownDiv.style.display = "block";
    } else {
      // Hide the specific dropdown menu
      dropdownDiv.style.display = "none";
    }
  }

  $(document).ready(function() {
    $(".form-check-input").on("click", function() {
      var dropdownBtn = $(this).siblings(".dropdown-toggle");
      var dropdownMenu = $(this).siblings(".dropdown-menu");

      // Hide all dropdown menus
      $(".dropdown-menu").hide();

      // Position the dropdown relative to the radio button
      var position = $(this).offset();
      dropdownMenu.css({
        top: position.top + $(this).outerHeight(),
        left: position.left
      });

      // Show the specific dropdown menu
      dropdownMenu.show();
    });
  });
</script>

  
<script>
  // Tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script>
  let table = new DataTable('#attendanceTable');
</script>

    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
