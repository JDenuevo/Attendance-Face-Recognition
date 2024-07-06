<?php
require 'e_form_validation.php';
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Policies | BERGS</title>
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

       <a class="navbar-brand" href="e_dashboard">
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
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded active" href="e_policies" data-toggle="tooltip" title="Policies" ><i class="fa-solid fa-file-lines"></i> Policies</a></li>
            </li>
             </ul>

        </ul>
        <br><br>
      </div>
    </nav>

    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
      <br><br><br>
      <div class="page-header pt-2">
        <h2>Employee's Policies</h2>
      </div>
      <hr>

      <form action="add_policy.php" method="post">
        <div class="modal fade" id="createPolicy" tabindex="-1" aria-labelledby="createPolicy1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title fw-bold">Create a new policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <input class="form-control" type="text" placeholder="Enter your Policy Title" name="p_title" autocomplete="off" required>
              </div>

              <div class="modal-body">
                <textarea class="form-control" placeholder="Enter your Policy Description" id="p_description" name="p_description"></textarea>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                <button type="submit" class="btn btn-success" data-bs-toggle="modal" name="add_policy" data-toggle="tooltip" data-placement="left" title="Add new policy now!"><i class="fa-solid fa-plus"></i> Add Policy</button>
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
        title: 'ADDING POLICIES!',
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
  $sql = "SELECT * FROM `bergs_policies`";
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
                  <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>"><?php echo $row['policy_name']; ?></button><br>
                  <br>
                  <p><?php echo $row['policy_descriptions']; ?></p>
                  <!-- MODAL -->
                  <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title fw-bold" id="<?php echo $modal_id; ?>Label"><?php echo $row['policy_name']; ?></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <p><h5 class="modal-title"><?php echo $row['policy_descriptions']; ?></p>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
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
  // Close the last row if there are any remaining modals
  if ($count % 3 != 0) {
      echo '</div>';
  }
  ?>
        
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
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Memo!" href="e_memo"><i class="fa-solid fa-message"></i> Memorandum</a>
            </li>
            <li class="nav-item pb-1">
              <a class="nav-link list-group-item border text-truncate rounded" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="e_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
            </li>
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded active" href="e_policies" data-toggle="tooltip" title="Policies" ><i class="fa-solid fa-file-lines"></i> Policies</a></li>
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