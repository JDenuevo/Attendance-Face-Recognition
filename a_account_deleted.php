<?php
require 'a_form_validation.php';
$haha = "";
$haha1 = "";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Manage Accounts | BERGS</title>
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

<link rel="stylesheet" href="css/display_image2.css">

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
              <a class="nav-link px-3" href="a_attendance">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 active" href="a_account">Account</a>
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
            <a class="nav-link list-group-item border text-truncate rounded " data-toggle="tooltip" data-placement="left" title="Set a Event!" href="a_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
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
        <h2>Manage Accounts</h2>
      </div>
      <hr>

      <button class="btn btn-sm btn-outline-primary" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="View Filter">
        <i class="fa-solid fa-filter"></i> Filter by
      </button>

      <ul class="dropdown-menu px-2" aria-labelledby="multiSelectDropdown" id ="multiSelectDropdown">
        <li><label><input type="checkbox" value="0" class="checkbox-column" checked> Employee ID</label></li>
        <li><label><input type="checkbox" value="1" class="checkbox-column" checked> Full Name</label></li>
        <li><label><input type="checkbox" value="2" class="checkbox-column" checked> Email</label></li>
        <li><label><input type="checkbox" value="3" class="checkbox-column" checked> Role</label></li>
        <li><label><input type="checkbox" value="4" class="checkbox-column" checked> Status</label></li>
      </ul>

      <!-- Button trigger modal -->

 <a style = "text-decoration: none;" href="a_account">
      <button class="btn btn-sm btn-outline-primary float-end me-3" data-toggle="tooltip" data-placement="left" title="See Active Accounts">
        <i class="fa-solid fa-file"></i> See Active Accounts
      </button></a>

      <br>

      <div class="pt-2" style = "overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered" name="table_registered" id="table_registered">
          <thead>
            <tr class="text-center table-active text-truncate fw-bold">
              <td scope="col" class = "text-center" data-column="0" >Employee ID</td>
              <td scope="col" class = "text-center" data-column="1" >Full Name</td>
              <td scope="col" class = "text-center" data-column="2" >Email</td>
              <td scope="col" class = "text-center" data-column="3" >Role</td>
              <td scope="col" class = "text-center" data-column="4" >Status</td>
              <td scope="col" class = "text-center" data-column="5" >Action</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql="SELECT * FROM `bergs_login` WHERE status = 'Inactive'";
            $result1=mysqli_query($conn, $sql);
              while ($row=mysqli_fetch_assoc($result1)) {

                ?>
            <tr class = "text-center align-middle text-wrap">
              <td class = "align-middle" data-column="0"><?php echo $row['id'] ?></td>
              <td class = "align-middle" data-column="1"><?php echo $row['full_name'] ?></td>
              <td class = "align-middle" data-column="2"><?php echo $row['email'] ?></td>
              <td class = "align-middle" data-column="3"><?php echo $row['position'] ?></td>
              <td class = "align-middle" data-column="4"><?php echo $row['status'] ?></td>

              <td class="d-flex-list justify-content-evenly align-middle" width = "100px" data-column="5">
                <div class="btn-group">
                  <button class="btn btn-sm btn-outline-primary  float-mid " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" data-placement="down" title="Click to see more actions">
                    <i class="fa-solid fa-share"></i> Actions
                  </button>
                  <ul class="dropdown-menu dropdown-menu-light text-small shadow text-center">
                  <button class="btn btn-sm btn-secondary mt-1" data-toggle="tooltip" data-placement="left"data-bs-toggle="modal" data-bs-target="#view_info<?php echo $row['id'] ?>" type="button" title="Click to View Info">
                      <i class="fa-solid fa-file"></i>
                      View Info
                  </button>
                  <?php if($row['position'] !== 'Administrator' && $row['position'] !== 'Owner'){?>
                      <button class="btn btn-sm btn-danger mt-1" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>');"data-toggle="tooltip" data-placement="left" title="Remove">
                          <i class="fa-solid fa-file"></i>
                          Activate
                      </button>
                  <?php } ?>
              </ul>


                </div>
              </td>
            </tr>

            <script>
              function showDeleteConfirmation(id) {
                Swal.fire({
                    title: 'ACTIVATE ACCOUNT!',
                    text: 'Do you want to reactivate this account?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reactivate it!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion
                        Swal.fire({
                    icon: 'success',
                    title: 'ACTIVATING ACCOUNT!',
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

                  window.location.href = 'a_reactivate_account?id=' + id;


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
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

 <!-- Modal for View Information Account-->
 <?php
  $sql = "SELECT * FROM bergs_login";
  if($rs=$conn->query($sql)){
      while ($row=$rs->fetch_assoc()) {
  ?>
 <form class="form" id="form1" action="" method="post" enctype="multipart/form-data">
  <div class="modal fade modal-lg" id="view_info<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down modal-fullscreen-md-down">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Account Information</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
              <div class="py-1">
                <label>Employee ID</label>
                <input class="form-control" type="text" id ="employee_id" name="employee_id" value="<?php echo $row['id'] ?>" name="acc_user" autocomplete="off" readonly>
                <?php
                        // if ($haha1 == "ew") {
                    ?>
                    <!-- <h6 style="color: red;">The Username you enter is already existing!</h6> -->
                  <?php
                  // } $haha1 = "";
                  ?>
              </div>
              <div class="py-1">
                 <label>Fullname</label>
                 <input class="form-control" type="text" id ="full_name" name="full_name" value="<?php echo $row['full_name'] ?>" autocomplete="off" readonly >
             </div>
             <div class="py-1">
                 <label>Email</label>
                 <input class="form-control" type="text" id ="email" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" readonly>
             </div>
            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
              <div class="py-1">
                <label>Status</label>
                <input class="form-control" type="text" id ="status" name="status" value="<?php echo $row['status'] ?>" autocomplete="off" readonly>
              </div>
              <!-- <script>
            const fullName = document.querySelector('input[name="acc_fullname"]');
            fullName.addEventListener('keypress', function(event) {
              const key = event.key;
              const regex = /[a-z A-Z]/;
              if (!regex.test(key)) {
                event.preventDefault();
              }
            });
          </script> -->
              <div class="py-1">
                <label>Roles</label>
                <input class="form-control" type="position" value="<?php echo $row['position'] ?>" autocomplete="off" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer ">
          <div class="div">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
          </div>

          <!-- <script>
          function generatePasswordForAccount() {

            event.preventDefault();

            // Define the characters that can be used in the password
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{};:,.<>?";

            // Define the length of the password
            const length = 12;

            let password = "";

            // Loop through the length of the password and randomly select a character from the defined characters
            for (let i = 0; i < length; i++) {
              const randomIndex = Math.floor(Math.random() * chars.length);
              password += chars[randomIndex];
            }

            // Set the value of the input fields with the generated password
            document.getElementById("acc_password").value = password;
            document.getElementById("acc_confirm_password").value = password;
          }

          // Add a click event listener to the button to call the generatePassword function
          document.querySelector("#generate-password-btn").addEventListener("click", generatePasswordForAccount);
          </script>
          <div class="div">
            <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            <button class="btn btn-sm btn-success" type="submit" id="submit-btn" name="save" data-toggle="tooltip" data-placement="left"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
          </div>
          <script>
          const submitBtn = document.querySelector('#submit-btn');

          submitBtn.addEventListener('click', function() {
          const passwordInput = document.querySelector('#acc_password');
          const confirmInput = document.querySelector('#acc_confirm_password');

          if (confirmInput.value !== passwordInput.value) {
            confirmInput.setCustomValidity('Passwords do not match');
          } else if (passwordInput.value.length < 6) {
            passwordInput.setCustomValidity('Password must be at least 6 characters long');
          } else {
            confirmInput.setCustomValidity('');
            passwordInput.setCustomValidity('');
          }
          };
            </script> -->
        </div>
      </div>
    </div>
  </div>
</form>
<?php
  }
}?>

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

          <label class = "pb-2 fs-5">Manage</label>

          <li class="nav-item dropdown dropup-center dropup" id="myDropdown">

            <a class="nav-link list-group-item border text-truncate rounded dropdown-toggle" data-placement="left" title="Modify" href="#" data-bs-toggle="dropdown" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-gear"></i> Modify
            </a>

            <ul class="dropdown-menu">

            <li><a class="dropdown-item" href="a_department">Department</a></li>

            <li><a class="dropdown-item" href="a_policies"> Policies</a></li>
            
            <li><a class="dropdown-item" href="a_restdays"> Manage Rest Days</a></li>
            
           <li><a class="dropdown-item" href="a_shift"> Shift Maintenance</a></li>

            </ul>

          </li>

        </ul>
      </div>
    </div>
  </div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // get the modal element
    var modal = document.getElementById("Eregister");

    // when the modal is closed, reset the form
    modal.addEventListener("hidden.bs.modal", function(event) {
      document.getElementById("form").reset();
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // get the modal element
    var modal1 = document.getElementById("Eaccount");

    // when the modal is closed, reset the form
    modal1.addEventListener("hidden.bs.modal", function(event) {
      document.getElementById("form2").reset();
    });
  });
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

<script>
  let table = new DataTable('#table_registered');
</script>

<script>
if (window.performance) {
  if (performance.navigation.type == 1) {
    // Reloaded the page using the browser's reload button
    window.location.href = "a_account_deleted";
  }
}</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>
