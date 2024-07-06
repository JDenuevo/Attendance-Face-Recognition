<?php
require 's_form_validation.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

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

      <a class="navbar-brand" href="s_dashboard">
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
              <a class="nav-link active px-3" href="s_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="s_list">List of Employees</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="s_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="s_account">Account</a>
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
            <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="s_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
          </li>

          <li class="nav-item pb-1">
            <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="s_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
          </li>

          <hr>

          <label class = "pb-2 fs-5 ms-1">Manage</label>
              
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="s_department" data-toggle="tooltip" title="Department"><i class="fa-solid fa-building"></i> Department</a>
            </li>

            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="s_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>

        </ul>
        <br><br>
      </div>
    </nav>



    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>HR Staff Dashboard</h2>
      </div>
      <hr>
      
        <div class="text-center">
            <label class="fw-semibold fs-3">Overview</label>
        </div>

        <div class="row">
            
          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-primary">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Number of Employees</h6>
              </div>

              <div class="card-body">
                <p class="card-text"><i class="fa-solid fa-person"></i> <label class="fw-bold">
                <?php 
                // SQL query to retrieve the rows
                $sql = "SELECT * FROM bergs_registration WHERE status='Active';";
                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;?> </label> Employees</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_list" class="btn btn-sm btn-primary w-75" data-toggle="tooltip" title="View Employee" ><i class="fa-solid fa-eye"></i> View Employees</a>
              </div>

            </div>
          </div>

          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-info">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Number of Department</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-solid fa-building"></i> <label class="fw-bold"><?php 
                // SQL query to retrieve the rows
                $sql = "SELECT * FROM bergs_department;";
                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;?>
                
                </label> Departments</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_department" class="btn btn-sm btn-info w-75" data-toggle="tooltip" title="View Department"><i class="fa-solid fa-eye"></i> View Departments</a>
              </div>

            </div>
          </div>

          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-success">

              <div class="card-header bg-transparent">
                <h6 small class="card-title">Number of Present Today</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-regular fa-id-badge"></i> <label class="fw-bold"><?php 
                // Set the timezone to Manila
                date_default_timezone_set('Asia/Manila');
                
                // Get the current date in Manila
                $date_today = date('Y-m-d');
                
                // SQL query to retrieve the rows
                $sql = "SELECT * FROM bergs_attendance WHERE marked='Present' AND date = '$date_today';";
                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;?>
                
                </label> Present Today</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_attendance" class="btn btn-sm btn-success w-75 text-light" data-toggle="tooltip" title="View Present Today"><i class="fa-solid fa-eye"></i> View Presents</a>
              </div>

            </div>
          </div>
          
          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-danger">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Number of Shifts</h6>
              </div>

              <div class="card-body">
                <p class="card-text"><i class="fa-solid fa-business-time"></i> <label class="fw-bold"><?php 
                // SQL query to retrieve the rows
                $sql = "SELECT * FROM bergs_shift;";
                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;?></label> Shifts</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_shift" class="btn btn-sm btn-danger w-75" data-toggle="tooltip" title="View Shift"><i class="fa-solid fa-eye"></i> View Shifts</a>
              </div>

            </div>
          </div>

          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-warning">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Events this month</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-solid fa-calendar-week"></i> <label class="fw-bold"><?php 
                // Get the current month and year
                date_default_timezone_set('Asia/Manila');
                $current_month = date('m');
                $current_year = date('Y');
                
                // SQL query to retrieve the rows with event_date in current month
                $sql = "SELECT * FROM bergs_event WHERE YEAR(event_date) = $current_year AND MONTH(event_date) = $current_month;";
                                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;
                ?></label> Events</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_event" class="btn btn-sm btn-warning w-75" data-toggle="tooltip" title="View Events"><i class="fa-solid fa-eye"></i> View Events</a>
              </div>

            </div>
          </div>
          
           <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-secondary">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Memorandum this month</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-solid fa-calendar-week"></i> <label class="fw-bold"><?php 
                // Get the current month and year
                date_default_timezone_set('Asia/Manila');
                $current_month = date('m');
                $current_year = date('Y');
                
                // SQL query to retrieve the rows with event_date in current month
                $sql = "SELECT * FROM bergs_memo WHERE YEAR(memo_date) = $current_year AND MONTH(memo_date) = $current_month;";
                                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;
                ?></label> Memorandum</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="s_memo" class="btn btn-sm btn-secondary w-75" data-toggle="tooltip" title="View Memorandum"><i class="fa-solid fa-eye"></i> View Memorandum</a>
              </div>

            </div>
          </div>

        </div>
        
        <hr>
        
        <div class="text-center">
            <label class="fw-semibold fs-3">Shortcuts</label>
        </div>
  
        <div class="row">
            
              <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
                <div class="card mx-1 my-1">
                  <div class="card-body text-center border border-dark rounded">
                    <p class="card-text">Create or Update a new Policy</p>
                    <a href="s_policies" class="btn btn-primary" data-toggle="tooltip" title="Go to Policy">Go to Policy</a>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
                <div class="card mx-1 my-1">
                  <div class="card-body text-center border border-dark rounded">
                    <p class="card-text">Notify your Colleagues on a new Memorandum</p>
                    <a href="s_memo" class="btn btn-primary" data-toggle="tooltip" title="Go to Memorandum">Go to Memorandum</a>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
                <div class="card mx-1 my-1">
                  <div class="card-body text-center border border-dark rounded">
                    <p class="card-text">Create an Event</p>
                    <a href="s_event" class="btn btn-primary" data-toggle="tooltip" title="Go to Events">Go to Event</a>
                  </div>
                </div>
              </div>
        </div>
        
        <hr>
        
        <div class="text-center">
            <label class="fw-semibold fs-3">Recent Attendance</label>
        </div>
        
        <div class="pt-2" style="overflow-x:auto">
           <table class="table table-responsive table-hover table-bordered" id="attendanceTable">
              <thead>
                <tr class="text-center table-active text-truncate">
                  <td scope="col" class = "text-center" data-column="0" >Employee ID</td>
                  <td scope="col" class = "text-center" data-column="1" >Employee Name</td>
                  <td scope="col" class = "text-center" data-column="2" >Time In</td>
                  <td scope="col" class = "text-center" data-column="3" >Time In Image</td>
                </tr>
              </thead>
    
              <tbody>
            
                  <?php 
                   include ("dbconn.php");
                    date_default_timezone_set("Asia/Manila");
                     $haha = date("Y-m-d");
                     $sql = "SELECT * FROM bergs_attendance WHERE date='$haha' ORDER BY time_in DESC";
                     if($rs=$conn->query($sql)){
                    while ($row=$rs->fetch_assoc()) {
                        if($row['time_in'] != null){

                      $time1 = strtotime($row['time_in']); // convert the time string to a Unix timestamp
                      $time_in = date('F d Y, g:i A', $time1);

                      }else{
                        $time_in = $row['time_in'];
                      }
                      $time_in_img = $row['timein_image'];
                         $time_in_base64 = base64_encode($time_in_img);
                  ?>
                
                   <td class = "align-middle text-center" data-column="0"><?php echo $row['employee_id']; ?></td>
                   <td class = "align-middle text-center" data-column="1"><?php echo $row['employee_name']; ?></td>
                   <td class = "align-middle text-center" data-column="3"><?php echo $time_in; ?></td>
                   <td class= "align-middle rounded text-center" width="100px" data-column="4"> <img style = "max-width: 100px; max-height: 100px;" src="data:image/jpeg;base64,<?php echo $time_in_base64; ?>" /></td>
                   </tr>
                   <?php 
                   }
                   }
                   ?>
              </tbody>
            </table>
        </div>
        
        <br>

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
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="s_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded " data-toggle="tooltip" data-placement="left" title="Set a Event!" href="s_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
          </ul>

          <hr>

          <label class = "pb-2 fs-5 ms-1">Manage</label>
              
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="s_department" data-toggle="tooltip" title="Department"><i class="fa-solid fa-building"></i> Department</a>
            </li>

            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="s_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>


        </ul>
      </div>
    </div>
  </div>

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
