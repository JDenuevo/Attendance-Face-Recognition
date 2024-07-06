<?php
require 'e_form_validation.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Memorandum | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Jquery Table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/display_image.css">

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
              <a class="nav-link px-3" href="e_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="e_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="e_account">Account</a>
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

        $sql = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
        $result = $conn->query($sql);
        while ($row=$result->fetch_assoc()) {

        $image_data = $row['image'];
        // Convert image data to base64-encoded string
        $image_data_base64 = base64_encode($image_data);
        ?>

        <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="w-100 py-2 px-2 rounded-circle">
        <label class="fw-italic"><?php echo $row['title'] . " | " . $row['department'] ?> <br> <span class = "fw-bold"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></span></label>
        <?php } ?>

        <hr>

        <ul class="nav flex-column d-md-block">
        <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded active" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="e_policies" data-toggle="tooltip" title="Policies" ><i class="fa-solid fa-file-lines"></i> Policies</a></li>
            </li>
             </ul>

        </ul>
        <br><br>
      </div>
    </nav>




    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>Employee's Memorandum</h2>
      </div>
      <hr>

      <?php
      include 'dbconn.php';
      $employee_id = $_SESSION['id'];
    $sqlselector = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
    $selectorresult = $conn->query($sqlselector);
    while ($row2 = mysqli_fetch_assoc($selectorresult)){
    $dept = $row2['department'];
  $sql = "SELECT * FROM `bergs_memo` WHERE memo_to = '$employee_id' OR memo_to = '$dept' OR memo_to = 'To All Employees' ORDER BY memo_num DESC";
  $result = mysqli_query($conn, $sql);
  $i = 0; // Initialize the loop index
  $count = 0; // Initialize the counter variable
  while ($row = mysqli_fetch_assoc($result)) {
      $modal_id = "exampleModal" . $i; // Generate a unique ID for the modal
      if ($count % 3 == 0) {
          // Start a new row every three modals
          echo '<div class="row row-cols-3">';
      }
  ?>

        <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-2">
            <div class="card shadow">
              <div class="card-body text-center">
                  <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>"><?php echo $row['memo_subject'] . " | " . date('F d Y', strtotime($row['memo_date']));  ?></button><br>
                  <br>
                  <p class = "text-truncate"><?php echo $row['memo_description']; ?></p>
                  <!-- MODAL -->
                  <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                              <div class="modal-body">
                                <div class="text-center">
                                    <label class="fw-bold fs-5">Memorandum</label>
                                    <hr>
                                </div>
                                <div class="text-start">
                                    <label class="fw-semibold text-start">TO: </label>
                                    <label class="text-start"><?php echo $row['memo_to']; ?></label>
                                    <br>
                                     
                                    <label class="fw-semibold text-start">FROM: </label>
                                    <label class="text-start"><?php echo $row['memo_from']; ?></label>
                                    <br>
                                    
                                    <label class="fw-semibold text-start">DATE: </label>
                                    <label class="text-start"><?php echo date('F d Y', strtotime($row['memo_date'])); ?></label>
                                    <br>
    
                                    <label class="fw-semibold text-start">SUBJECT: </label>
                                    <label class="text-start" id="<?php echo $modal_id; ?>"><?php echo $row['memo_subject']; ?></label>
                                    <br><br>
                                    <p class="lh-base" style="text-indent: 40px; text-align: justify;"><?php echo $row['memo_description']; ?></p>
                                </div>
                              </div>
                              
                              <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <?php
      $i++; // Increment the loop index
      $count++; // Increment the counter variable
      if ($count % 3 == 0) {
          // End the row every three modals
          echo '</div>';
      }
  }
 }
  // Close the last row if there are any remaining modals
  if ($count % 3 != 0) {
      echo '</div>';
  }
  ?>
  
<!--================================================================== END NG OPEN MODAL WAG GAGALAWIN UNLESS JHEMAR DENUEVO O KIAN UBANA ANG PANGALAN MO (PAAYOS NG UI) ================================================-->
     


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
          <label class = "pb-2 fs-5">Payroll</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Payroll Summary" href="e_summary"><i class="fa-solid fa-table-list"></i> Payroll Summary</a>
            </li>
          </ul>

          <hr>

          <label class = "pb-2 fs-5">Board</label>
          <ul class = "list-unstyled fw-normal pb-2 small">
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded active" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
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

<script>
// Check if the URL contains a query string
if (window.location.search) {
// Replace the current URL with the URL without the query string
history.replaceState({}, document.title, window.location.pathname);
}

</script>

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
  $('#table_registered').toggleClass('table-striped');
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>
