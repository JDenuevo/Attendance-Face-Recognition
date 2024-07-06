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
<title>Guest Dashboard | BERGS</title>
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
              <a class="nav-link active px-3" href="g_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="g_attendance">Attendance</a>
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
        <h2>Guest's Dashboard</h2>
      </div>
      <hr>
      
        <div class="text-center">
            <label class="fw-semibold fs-3">Overview</label>
        </div>

        <div class="row">
          

          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-success">

              <div class="card-header bg-transparent">
                <h6 small class="card-title">Number of Presents This Month</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-regular fa-id-badge"></i> <label class="fw-bold"><?php 
                // Set the timezone to Manila
                date_default_timezone_set('Asia/Manila');
                
                // Get the current date in Manila
                $date_today = date('Y-m-d');
                
                // SQL query to retrieve the rows
                $sql = "SELECT * FROM bergs_attendance 
                            WHERE marked='Present' 
                            AND MONTH(date) = MONTH('$date_today') 
                            AND YEAR(date) = YEAR('$date_today') 
                            AND employee_id = '$employee_id'";
                
                // Execute the query and get the result set
                $result = mysqli_query($conn, $sql);
                
                // Get the number of rows returned by the query
                $num_rows = mysqli_num_rows($result);
                
                echo $num_rows;?>
                </label> Presents this Month</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="e_attendance" class="btn btn-sm btn-success w-75 text-light" data-toggle="tooltip" title="View Presents"><i class="fa-solid fa-eye"></i> View Presents</a>
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
                    
                    $sql1 = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
                                    
                    // Execute the query and get the result set
                    $result1 = mysqli_query($conn, $sql1);
                    
                    // Get the number of rows returned by the query
                    $num_rows1 = mysqli_num_rows($result1);
                    
                    $row = mysqli_fetch_assoc($result1);
                    $department = $row['department'];
                    
                    // SQL query to retrieve the rows with event_date in current month and relevant department
                    $sql = "SELECT * FROM bergs_event WHERE YEAR(event_date) = $current_year AND MONTH(event_date) = $current_month AND (event_to = 'To All Employees' OR event_to = '$department')";
                    
                    // Execute the query and get the result set
                    $result = mysqli_query($conn, $sql);
                    
                    // Get the number of rows returned by the query
                    $num_rows = mysqli_num_rows($result);
                    
                    echo $num_rows;
                ?>
                </label> Events</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="e_event" class="btn btn-sm btn-warning w-75" data-toggle="tooltip" title="View Events"><i class="fa-solid fa-eye"></i> View Events</a>
              </div>

            </div>
          </div>
          
          <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
            <div class="card text-bg-light border-primary">

              <div class="card-header bg-transparent">
                <h6 class="card-title">Memorandum this month</h6>
              </div>

              <div class="card-body ">
                <p class="card-text"><i class="fa-solid fa-message"></i> <label class="fw-bold"><?php 
                    // Get the current month and year
                    date_default_timezone_set('Asia/Manila');
                    $current_month = date('m');
                    $current_year = date('Y');
                    
                    $sql1 = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
                                    
                    // Execute the query and get the result set
                    $result1 = mysqli_query($conn, $sql1);
                    
                    // Get the number of rows returned by the query
                    $num_rows1 = mysqli_num_rows($result1);
                    
                    $row = mysqli_fetch_assoc($result1);
                    $department = $row['department'];
                    
                    // SQL query to retrieve the rows with event_date in current month and relevant department
                    $sql = "SELECT * FROM bergs_memo WHERE YEAR(memo_date) = $current_year AND MONTH(memo_date) = $current_month AND (memo_to = 'To All Employees' OR memo_to = '$department' OR memo_to = '$employee_id')";
                    
                    // Execute the query and get the result set
                    $result = mysqli_query($conn, $sql);
                    
                    // Get the number of rows returned by the query
                    $num_rows = mysqli_num_rows($result);
                    
                    echo $num_rows;
                ?>
                </label> Memos</p>
              </div>

              <div class="card-footer text-center bg-transparent">
                <a href="e_memo" class="btn btn-sm btn-primary w-75" data-toggle="tooltip" title="View Memorandum"><i class="fa-solid fa-eye"></i> View Memorandum</a>
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
                    <p class="card-text">Check out a New Policy</p>
                    <a href="e_policies" class="btn btn-primary" data-toggle="tooltip" title="Go to Policy">Go to Policy</a>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
                <div class="card mx-1 my-1">
                  <div class="card-body text-center border border-dark rounded">
                    <p class="card-text">Check out a New Memorandum</p>
                    <a href="e_memo" class="btn btn-primary" data-toggle="tooltip" title="Go to Memorandum">Go to Memorandum</a>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-1">
                <div class="card mx-1 my-1">
                  <div class="card-body text-center border border-dark rounded">
                    <p class="card-text">Check out a New Event</p>
                    <a href="e_event" class="btn btn-primary" data-toggle="tooltip" title="Go to Events">Go to Event</a>
                  </div>
                </div>
              </div>

                
            
            
        </div>

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
