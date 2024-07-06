<?php
require 'a_form_validation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin List of Deleted Employee | BERGS</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">


<!-- Jquery Table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">

<!-- Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
          <img src="photos/bergs.png">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

          <ul class="navbar-nav m-auto">
            <li class="nav-item">
              <a class="nav-link px-3" href="a_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 active" href="a_list">List of Employees</a>
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
        <h2>List Deleted Employees</h2>
      </div>
      <hr>


      <button class="btn btn-sm btn-outline-primary" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-filter"></i> View
      </button>

      <ul class="dropdown-menu px-2" aria-labelledby="multiSelectDropdown" id ="multiSelectDropdown">
        <li><label><input type="checkbox" value="0" class="checkbox-column"> Employee Image</label></li>
        <li><label><input type="checkbox" value="1" class="checkbox-column" checked> Employee ID</label></li>
        <li><label><input type="checkbox" value="2" class="checkbox-column" checked> Full Name</label></li>
        <li><label><input type="checkbox" value="3" class="checkbox-column" checked> Gender </label></li>
        <li><label><input type="checkbox" value="4" class="checkbox-column" checked> Contact Number</label></li>
        <li><label><input type="checkbox" value="5" class="checkbox-column" checked> Address</label></li>
        <li><label><input type="checkbox" value="6" class="checkbox-column" checked> Postal Code</label></li>
        <li><label><input type="checkbox" value="7" class="checkbox-column" checked> Position</label></li>
        <li><label><input type="checkbox" value="8" class="checkbox-column" checked> Department</label></li>
        <li><label><input type="checkbox" value="9" class="checkbox-column" checked> Job Title</label></li>
        <li><label><input type="checkbox" value="10" class="checkbox-column" checked> Shift</label></li>
      </ul>

        <a style = "text-decoration: none;" href="a_list">
          <button class="btn btn-sm btn-outline-secondary float-end my-1 mx-1" data-toggle="tooltip" data-placement="left" title="See Active Accounts">
            <i class="fa-solid fa-trash"></i> See Active Accounts
          </button>
        </a>
 <br>
        <br>
      <div class="pt-2" style="overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered" name="table_registered" id="table_registered">
          <thead>
            <tr class="text-center table-active text-truncate fw-bold">
              <td scope="col" class = "text-center" data-column="0">Employee Image</td>
              <td scope="col" class = "text-center" data-column="1">Employee ID</td>
              <td scope="col" class = "text-center" data-column="2">Full Name</td>
              <td scope="col" class = "text-center" data-column="3">Gender</td>
              <td scope="col" class = "text-center" data-column="4">Contact Number</td>
              <td scope="col" class = "text-center" data-column="5">Address</td>
              <td scope="col" class = "text-center" data-column="6">Postal Code</td>
              <td scope="col" class = "text-center" data-column="7">Position</td>
              <td scope="col" class = "text-center" data-column="8">Department</td>
              <td scope="col" class = "text-center" data-column="9">Job Title</td>
              <td scope="col" class = "text-center" data-column="10">Shift Number</td>
              <td scope="col" class = "text-center" data-column="11">Actions</td>
            </tr>
          </thead>

          <tbody>
            <?php
            $sql="SELECT * FROM bergs_registration WHERE status= 'Inactive'";
            $result1=mysqli_query($conn, $sql);
              while ($row=mysqli_fetch_assoc($result1)) {
                $image_data = $row['image'];
                // Convert image data to base64-encoded string
                $image_data_base64 = base64_encode($image_data);
                ?>
            <tr data-id="<?php echo $row['id']; ?>" class = "text-center align-middle text-wrap">
              <td data-column="0" scope="row"><img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" class="rounded text-center" width="100px"></td>
              <td data-column="1"><?php echo $row['id'] ?></td>
              <td data-column="2"><?php echo $row['lname'] . ', ' . $row['fname'] . ' '. $row['mname'] ?></td>
              <td data-column="3"><?php echo $row['gender'] ?></td>
              <td data-column="4"><?php echo $row['contact_number'] ?></td>
              <td data-column="5"><?php echo $row['address'] ?></td>
              <td data-column="6"><?php echo $row['postal_code'] ?></td>
              <td data-column="7"><?php echo $row['position'] ?></td>
              <td data-column="8"><?php echo $row['department'] ?></td>
              <td data-column="9"><?php echo $row['job_title'] ?></td>
              <td data-column="10"><?php echo $row['shift_num'] ?></td>

              <td class="d-flex-list justify-content-evenly align-middle" width = "100px" data-column="11">
                <button class="btn btn-sm btn-outline-primary" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"  data-placement="down" title="Click to see more">
                  <i class="fa-solid fa-share"></i> Actions
                </button>

              <ul class="dropdown-menu dropdown-menu-light text-small shadow text-center">
                  <button class="btn btn-sm btn-secondary mt-1"data-toggle="tooltip" data-placement="left"data-bs-toggle="modal" data-bs-target="#view_info<?php echo $row['id'] ?>" type="button" title="Click to View Info">
                    <i class="fa-solid fa-file"></i>
                    View Info
                  </button><br>
                  <button class="btn btn-sm btn-primary mt-1" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>');" data-toggle="tooltip" data-placement="left" title="Activate Employee">
                    <i class="fa-solid fa-file"></i>
                    Activate
                  </button><br>
                </ul>
              </td>
            </tr>
            <?php
            }
            ?>

          </tbody>
        </table>
      </div>
      <script>
function showDeleteConfirmation(id) {
    Swal.fire({
        title: 'ACTIVATE EMPLOYEE!',
        text: 'Do you want to reactivate the employee?',
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
        title: 'ACTIVATE EMPLOYEE!',
        text: 'Data Activated Successfully',
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

      window.location.href = 'a_reactivate_employee.php?id=' + id;


        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Handle cancel button click event
            Swal.fire(
                'Cancelled',
                'Your data is safe ',
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
                <a class="nav-link list-group-item border text-truncate rounded" href="a_shift" data-toggle="tooltip" title="Shift Maintenance"><i class="fa-sharp fa-solid fa-rotate"></i> Shift Maintenance</a>
            </li>

        </ul>
      </div>
    </div>
  </div>

      <!-- Modal for View Infor For Employees -->

      <?php
      $sql = "SELECT * FROM bergs_registration";
      if($rs=$conn->query($sql)){
          while ($row=$rs->fetch_assoc()) {
      ?>
        <div class="modal fade modal-lg" id="view_info<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Personal Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <!-- Upload Pic -->

                <form class="form" id="form" action="a_registering_of_accounts.php" method="post" enctype="multipart/form-data">
                  <div class="upload" id="upload">
                    <center>
                      <div style="width:200px; height: 200px;" class="shadow border border-opacity-50">
                        <?php
                        $image_data = $row['image'];
                        // Convert image data to base64-encoded string
                        $image_data_base64 = base64_encode($image_data);
                        ?>
                        <img src="data:image/jpeg;base64,<?php echo $image_data_base64; ?>" alt="Uploaded Image" style="width:200px; height: 200px; object-fit: contain; object-position: center;">
                      </div>
                    </center>
                  </div>
        <br>

            <div class="row rows-col-3">
                <div class="col-lg-4 col-md-4 col-sm-12 ">

                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <input class="form-control" type="text" placeholder="Dela Cruz" name="lname" value="<?php echo $row['lname'] ?>" autocomplete="off" readonly>
                    <center><label>Last Name</label></center>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Juan" name="fname" value="<?php echo $row['fname'] ?>" autocomplete="off" readonly>
                    <center><label>First Name</label><br></center>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Rivera" name="mname" value="<?php echo $row['mname'] ?>" autocomplete="off" readonly>
                    <center><label>Middle Name</label><br></center>
                </div>

            </div>
            <br>
            <div class="row rows-col-3">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="date" value="<?php echo $row['bday'] ?>" autocomplete="off" readonly>
                    <center><label>Birthday</label></center>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="gender" value="<?php echo $row['gender'] ?>" autocomplete="off" readonly>
                    <center><label>Gender</label></center>
                </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="text"value="<?php echo $row['contact_number'] ?>" autocomplete="off" readonly>
                <center><label>Contact no.</label></center>
            </div>

        </div>
        <br>
        <div class="row rows-col-3">
            <div class="col-lg-6 col-md-4 col-sm-12">
                <input class="form-control" type="text" placeholder="Address" value="<?php echo $row['address'] ?>" autocomplete="off" readonly>
                <center><label>Address</label></center><br>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-12">
                <input class="form-control" type="text" placeholder="City" value="<?php echo $row['city'] ?>" autocomplete="off" readonly>
                <center><label>City</label></center><br>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-12">
                <input class="form-control" type="number" placeholder="XXXX" name="postal_code" max="9999" value="<?php echo $row['postal_code'] ?>" autocomplete="off" readonly>
                <center><label>Postal Code</label></center>
            </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <input class="form-control" type="text" placeholder="email@gmail.com" value="<?php echo $row['email'] ?>" autocomplete="off" readonly>
            <center><label>Email</label></center>

          </div>

                  </div>
        <br>
        <br>
        <div class="input-group mb-4">
            <label class="input-group-text">Position</label>
            <input class="form-control" type="position" value="<?php echo $row['position'] ?>" autocomplete="off" readonly>
        </div>

          <div class="input-group mb-4">
          <label class="input-group-text">Department</label>
          <input class="form-control" type="department" value="<?php echo $row['department'] ?>" autocomplete="off" readonly>
        </div>

        <div class="input-group mb-4">
          <label class="input-group-text">Job Title</label>
          <input class="form-control" type="jobtitle" value="<?php echo $row['job_title'] ?>" autocomplete="off" readonly>
        </div>

        <div class="input-group mb-4">
          <label class="input-group-text">Shift</label>
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
          <input class="form-control" id="shift" name="shift" type="text" readonly value="<?php echo $selected_shift ?>" required>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<?php
    }
    }
  ?>

  <script>
if (window.performance) {
  if (performance.navigation.type == 1) {
    // Reloaded the page using the browser's reload button
    window.location.href = "a_list_deleted";
  }
}
</script>
<script>
  // Tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
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
  let table = new DataTable('#table_registered');
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
