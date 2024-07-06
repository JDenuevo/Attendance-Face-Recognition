<?php
require 'a_form_validation.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Policies | BERGS</title>
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
                <a class="nav-link list-group-item border text-truncate rounded active" href="a_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
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
        <h2>Admin Policies</h2>
      </div>
      <hr>

      <div class="text-end">
        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#createPolicy" type="button" data-toggle="tooltip" data-placement="left" title="Create new Policies!"> <i class="fa-solid fa-plus"></i> Create New</button>
      </div>

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
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#my-modal-<?php echo $row['policy_id']; ?>" onclick="changeModalId('<?php echo $modal_id; ?>')" data-toggle="tooltip" data-placement="left" title="Update policy description now!"><i class="fa-solid fa-pen-to-square"></i> Update</button>
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

            <script>
            function changeModalId(newId) {
              // Get the modal element
              const modal = document.querySelector('#my-modal');

              // Change the id attribute to the new ID
              modal.setAttribute('id', newId);

              // Update the data-bs-target attribute of the button to match the new ID
              const button = document.querySelector('[data-bs-target="#my-modal"]');
              button.setAttribute('data-bs-target', `#${newId}`);
            }
            </script>
  <?php
  $sql1 = "SELECT * FROM `bergs_policies`";
  $result1 = mysqli_query($conn, $sql1);
  while ($row1 = mysqli_fetch_assoc($result1)) {
  ?>
      <form class="" action="a_update_policy.php?id=<?php echo $row1['policy_id']; ?>" method="post">
          <div class="modal fade" id="my-modal-<?php echo $row1['policy_id']; ?>" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title fw-bold"><?php echo "Edit ".$row1['policy_name']; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <input class="form-control" type="text" value="<?php echo $row1['policy_name']; ?>" name="p_title" autocomplete="off" required>
                </div>

                <div class="modal-body">
                  <textarea class="form-control" id="message-text" name="p_description"><?php echo $row1['policy_descriptions']; ?></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                  <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="left"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors2'])) {
    $error2 = $_GET['errors2'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'UPDATING POLICIES!',
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

        <?php
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
                <a class="nav-link list-group-item border text-truncate rounded active" href="a_policies"data-toggle="tooltip" title="Policies"><i class="fa-solid fa-file-lines"></i> Policies</a>
            </li>
            
            
            <li class="nav-item pb-1">
                <a class="nav-link list-group-item border text-truncate rounded" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
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

<script>
// Check if the URL contains a query string
if (window.location.search) {
// Replace the current URL with the URL without the query string
history.replaceState({}, document.title, window.location.pathname);
}

</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
