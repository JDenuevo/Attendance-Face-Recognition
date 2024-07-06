<?php
require 's_form_validation.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff List of Employee | BERGS</title>
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
              <a class="nav-link px-3" href="s_dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 active" href="s_list">List of Employees</a>
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
        <h2>List of Employees</h2>
      </div>
      <hr>


      <button class="btn btn-sm btn-outline-primary" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-filter"></i> View
      </button>

      <ul class="dropdown-menu px-2" aria-labelledby="multiSelectDropdown" id ="multiSelectDropdown">
        <li><label><input type="checkbox" value="0" class="checkbox-column"> Employee Image</label></li>
        <li><label><input type="checkbox" value="1" class="checkbox-column" checked> Employee ID</label></li>
        <li><label><input type="checkbox" value="2" class="checkbox-column" checked> Full Name</label></li>
        <li><label><input type="checkbox" value="3" class="checkbox-column" checked> Birth Day</label></li>
        <li><label><input type="checkbox" value="4" class="checkbox-column" checked> Gender </label></li>
        <li><label><input type="checkbox" value="5" class="checkbox-column" checked> Nationality </label></li>
        <li><label><input type="checkbox" value="6" class="checkbox-column" checked> Contact Number</label></li>
        <li><label><input type="checkbox" value="7" class="checkbox-column" checked> Office Tel</label></li>
        <li><label><input type="checkbox" value="8" class="checkbox-column" checked> Address</label></li>
        <li><label><input type="checkbox" value="9" class="checkbox-column" checked> City </label></li>
        <li><label><input type="checkbox" value="10" class="checkbox-column" checked> Email </label></li>
        <li><label><input type="checkbox" value="11" class="checkbox-column" checked> Date of Employment </label></li>
        <li><label><input type="checkbox" value="12" class="checkbox-column" checked> Title</label></li>
        <li><label><input type="checkbox" value="13" class="checkbox-column" checked> Department</label></li>
        <li><label><input type="checkbox" value="14" class="checkbox-column" checked> Privilege</label></li>
        <li><label><input type="checkbox" value="15" class="checkbox-column" checked> Shift</label></li>
        <li><label><input type="checkbox" value="16" class="checkbox-column" checked> Actions</label></li>
      </ul>

      <!--<div class="dropdown mx-1 float-end">-->
      <!--  <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="Click to see Print options">-->
      <!--      Print Options-->
      <!--    </button>-->
          
      <!--    <ul class="dropdown-menu dropdown-menu-light text-small shadow">-->
      <!--      <li><button class="dropdown-item btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#mod-indiv"><i class="fa-solid fa-user"></i> Individual</button></li>-->
      <!--      <li><button class="dropdown-item btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#mod-dept"><i class="fa-solid fa-users"></i> By Department</button></li>-->
      <!--      <li><button class="dropdown-item btn-outline-dark" type="button"><i class="fa-solid fa-users"></i> All</button></li>-->
      <!--    </ul>-->
      <!--</div>-->
         <br>
        <br>

      <div class="pt-2" style="overflow-x:auto">
        <table class="table table-responsive table-hover table-bordered" name="table_registered" id="table_registered">
          <thead>
            <tr class="text-center table-active text-truncate fw-bold">
              <td scope="col" class = "text-center" data-column="0">Employee Image</td>
              <td scope="col" class = "text-center" data-column="1">Employee ID</td>
              <td scope="col" class = "text-center" data-column="2">Full Name</td>
              <td scope="col" class = "text-center" data-column="3">Birth Day</td>
              <td scope="col" class = "text-center" data-column="4">Gender</td>
              <td scope="col" class = "text-center" data-column="5">Nationality</td>
              <td scope="col" class = "text-center" data-column="6">Contact Number</td>
              <td scope="col" class = "text-center" data-column="7">Office Tel.</td>
              <td scope="col" class = "text-center" data-column="8">Address</td>
              <td scope="col" class = "text-center" data-column="9">City</td>
              <td scope="col" class = "text-center" data-column="10">Email</td>
              <td scope="col" class = "text-center" data-column="11">Date of Employment</td>
              <td scope="col" class = "text-center" data-column="12">Title</td>
              <td scope="col" class = "text-center" data-column="13">Department</td>
              <td scope="col" class = "text-center" data-column="14">Privilege</td>
              <td scope="col" class = "text-center" data-column="15">Shift Number</td>
              <td scope="col" class = "text-center" data-column="16">Actions</td>
            </tr>
          </thead>

          <tbody>
            <?php
            $sql="SELECT * FROM bergs_registration WHERE status= 'Active'";
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
              <td data-column="3"><?php echo $row['bday'] ?></td>
              <td data-column="4"><?php echo $row['gender'] ?></td>
              <td data-column="5"><?php echo $row['nationality'] ?></td>
              <td data-column="6"><?php echo $row['contact_number'] ?></td>
              <td data-column="7"><?php echo $row['office_tel'] ?></td>
              <td data-column="8"><?php echo $row['address'] ?></td>
              <td data-column="9"><?php echo $row['city'] ?></td>
              <td data-column="10"><?php echo $row['email'] ?></td>
              <td data-column="11"><?php echo $row['date_of_employment'] ?></td>
              <td data-column="12"><?php echo $row['title'] ?></td>
              <td data-column="13"><?php echo $row['department'] ?></td>
              <td data-column="14"><?php echo $row['privilege'] ?></td>
              <td data-column="15"><?php echo $row['shift_num'] ?></td>

              <td class="d-flex-list justify-content-evenly align-middle" width = "100px" data-column="16">
                <button class="btn btn-sm btn-outline-primary  float-mid " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"  data-placement="down" title="Click to see more">
                  <i class="fa-solid fa-share"></i> Actions
                </button>

              <ul class="dropdown-menu dropdown-menu-light text-small shadow text-center">
                <button class="btn btn-sm btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#updatemodalmodify<?php echo $row['id'] ?>" data-toggle="tooltip" data-placement="left" title="Update Employee">
                  <i class="fa-solid fa-pen-to-square"></i>
                  Update
                </button><br>
                  <button class="btn btn-sm btn-secondary mt-1"data-toggle="tooltip" data-placement="left" data-bs-toggle="modal" data-bs-target="#view_info<?php echo $row['id'] ?>" type="button" title="Click to View Info">
                    <i class="fa-solid fa-file"></i>
                    View Info
                  </button><br>
                  <button class="btn btn-sm btn-danger mt-1" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>');" data-toggle="tooltip" data-placement="left" title="Remove Employee">
                    <i class="fa-solid fa-trash"></i>
                    Remove
                  </button><!--<br>
                  <button class="btn btn-sm btn-primary mt-1" type="button" data-bs-toggle="modal"data-bs-target="#addfacemodal_modify_<?php echo $row['id'] ?>" data-toggle="tooltip" data-placement="left" title="Open Face Recognition Employee">
                    <i class="fa-sharp fa-solid fa-face-smile"></i>
                    Add Face
                  </button>-->
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
        title: 'REMOVE EMPLOYEE!',
        text: 'Do you want to remove the employee?',
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
        title: 'REMOVING EMPLOYEE!',
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

      window.location.href = 's_remove_employee.php?id=' + id;


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

<?php
  $sql = "SELECT * FROM bergs_registration";
  if($rs=$conn->query($sql)){
      while ($row=$rs->fetch_assoc()) {

?>

<form action="s_list_addface.php" method="POST"  enctype="multipart/form-data">
<!-- Modal Add Face-->
  <div class="modal fade modal-lg" id="addfacemodal_modify_<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Face Recognition</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="modal-body h-100 justify-content-center">
          <div class="row">

            <div class="col-12 py-2">
                <div class="container text-center align-items-center">
                  <center>
                  <div class="py-5 shadow border border-opacity-50 text-center fs-1" style = "width: 200px; heigth: 200px;">
                    <div id="preview">
                    </div>
                  </div>
                  </center>
                  <div class="pt-2">
                      <i class="fa-solid fa-camera"></i>
                      <label for="file">File:</label>
                      <input class="btn" type="file" name="file" id="file" data-toggle="tooltip" data-placement="left" title="Click to choose image file" required>
                  </div>
                </div>
                <script>
                        const input = document.getElementById("file");
                        const preview = document.getElementById("preview");

                        input.addEventListener("change", function() {
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.addEventListener("load", function() {
                                    preview.innerHTML = '<img style = "max-width: 200px; max-height: 200px;" src="' + this.result + '" alt="Preview">';
                                });5
                                reader.readAsDataURL(file);
                            }
                        });
                </script>
            </div>
            <div class="col-12 py-2">
              <label>Enter Employee ID</label>
              <input class="form-control" type="text" placeholder="XXXX-XXXX" name="employee_id" value="<?php echo $row['id'] ?>" autocomplete="off" required disable readonly>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <div class="div">
            <button class="btn btn-sm btn-secondary" data-bs-target="#modalint" data-bs-toggle="modal" data-toggle="tooltip" data-placement="left" title="Click to see Instructions"><i class="fa-solid fa-info"></i> Instructions</button>
          </div>
          <div class="div">
            <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            <button class="btn btn-sm btn-success" name="add_face" type="submit" data-toggle="tooltip" data-placement="left" title="Save the image"><i class="fa-solid fa-floppy-disk"></i> Add Face</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
  $(document).ready(function() {
  $('#addfacemodal_modify_<?php echo $row['id'] ?>').on('hidden.bs.modal', function () {
    $('#preview').html(''); // remove the image preview element
  });
});

</script>
<?php
    }
  }
?>
  <!-- Continuous modal for Attendance-->
  <div class="modal fade modal-lg" id="modalint" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Instructions</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label class="text-muted pb-2">Please follow the instructions below</label>
          <br>
          1. Image must be clear.
          <br>
          2. Image must be named as 1.png/jpg/jpeg.
          <br>
          3. Check if the photo of the employee is in the right employee ID
          <br>
          4. You can rewrite the old image by uploading again a new 1.png/jpg/jpeg image.
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-secondary" data-bs-target="#Efacereg" data-bs-toggle="modal"><i class="fa-solid fa-arrow-left"></i> Back to Add Face Recognition</button>
        </div>
      </div>
    </div>
  </div>

  <?php
		// Display error messages if they were passed in the URL
		if (isset($_GET['errors'])) {
			$errors = explode(',', $_GET['errors']);
			foreach ($errors as $error) {
				echo "<script>Swal.fire({
						icon: 'error',
						title: 'ERROR',
						text: '$error'
					});</script>";

        }
        unset($_GET['errors']);
		}
	?>
<?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors1'])) {
    $error1 = $_GET['errors1'];
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'IMAGE IS UPLOADED SUCCESSFULLY!',
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

  <?php
    //     if (isset($_SESSION['open_modal']) == true) {
    //   echo "<script>
    //           jQuery(document).ready(function(){
    //               jQuery('#Eregister').modal('show');
    //           });
    //       </script>";
    //   unset($_SESSION['open_modal']);
    //   $haha= "ew";
    // }
    ?>

    <!-- Modal for Update Employees -->

    <?php
      $sql = "SELECT * FROM bergs_registration";
      if($rs=$conn->query($sql)){
          while ($row=$rs->fetch_assoc()) {
      ?>
      <form class="form" id="form" action="s_update_employee.php" method="post" enctype="multipart/form-data">
        <div class="modal fade modal-lg" id="updatemodalmodify<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Update Personal Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                 <div class="row rows-col-3">
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <select class="form-select" id="department" name="department" required>
                        <option selected disabled>Select Department</option>
                        <?php
                            $sql2 = "SELECT * FROM bergs_department";
                            $result = mysqli_query($conn, $sql2);
                            while($row2 = mysqli_fetch_array($result)) {
                                $selected = ($row['department'] == $row2['dep_name']) ? 'selected' : ''; // Compare selected value with value from database
                            ?>
                            <option value="<?= $row2['dep_name'] ?>" <?= $selected ?>><?= $row2['dep_name'] ?></option>
                        <?php } ?>
                        </select>
                        <script>
                        $(document).ready(function() {
                            var lastDepartment = localStorage.getItem('lastDepartment');
                            if (lastDepartment) {
                            $('select[name="department"]').val(lastDepartment);
                            }
                        });
                        </script>
                        <center><label>Department</label></center>
                    </div>
                
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <select class="form-select" id="shift" name="shift" required>
                            <option selected disabled>Select Shift</option>
                            <?php
                                $sql2 = "SELECT * FROM bergs_shift";
                                $result2 = mysqli_query($conn, $sql2);
                                while($row2 = mysqli_fetch_array($result2)) {
                                    $selected = ($row['shift_num'] == $row2['shift_num']) ? 'selected' : '';
                                    $start_time = date('g:i A', strtotime($row2['shift_start']));
                                    $end_time = date('g:i A', strtotime($row2['shift_end']));
                                ?>
                                    <option value="<?= $row2['shift_num'] ?>" <?= $selected ?>><?= $start_time ?> to <?= $end_time ?></option>
                                <?php
                                }
                                ?>
                        </select>
                         <script>
                        $(document).ready(function() {
                            var lastShift = localStorage.getItem('lastShift');
                            if (lastShift) {
                            $('select[name="shift"]').val(lastShift);
                            }
                        });
                        </script>
                        <center><label>Shift</label></center>
                    </div>
    
                    
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Card Number" name="cardnum" value="<?php echo $row['cardnum'] ?>" autocomplete="off" required>
                        <center><label>Card Number</label></center>
                    </div>
                </div>
                <br>
                <div class="row rows-col-3">
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="date" placeholder="Date of Employment" name="date_of_employment" value="<?php echo $row['date_of_employment'] ?>" autocomplete="off" required>
                        <center><label>Date of Employment</label></center>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Title" name="title" value="<?php echo $row['title'] ?>" autocomplete="off" required>
                        <center><label>Title</label></center>
                    </div>
                     <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Company Name" name="company_name" value="<?php echo $row['company_name'] ?>" autocomplete="off" required>
                    <center><label>Company Name</label></center>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <select class="form-select" name="privilege" autocomplete="off" required>
                            <option value="HR Staff" <?php echo ($row['privilege'] == 'HR Staff') ? 'selected' : ''; ?>>HR Staff</option>
                            <option value="Employee" <?php echo ($row['privilege'] == 'Employee') ? 'selected' : ''; ?>>Employee</option>
                            <option value="Guest" <?php echo ($row['privilege'] == 'Guest') ? 'selected' : ''; ?>>Guest</option>
                        </select>
                        <center><label>Privilege</label></center>
                    </div>
                </div>
                <br>
                <div class="row rows-col-3">
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 ">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                        <input class="form-control" type="text" placeholder="Dela Cruz" name="lname" value="<?php echo $row['lname'] ?>" autocomplete="off" required>
                        <center><label>Last Name</label></center>
                    </div>
                    <script>
                    const lastNameInput = document.querySelector('input[name="lname"]');
                    lastNameInput.addEventListener('keypress', function(event) {
                      const key = event.key;
                      const regex = /[a-z A-Z]/;
                      if (!regex.test(key)) {
                        event.preventDefault();
                      }
                    });
                    </script>
                  
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Juan" name="fname" value="<?php echo $row['fname'] ?>" autocomplete="off" required>
                        <center><label>First Name</label><br></center>
                    </div>
                    <script>
                    const firstNameInput = document.querySelector('input[name="fname"]');
                    firstNameInput.addEventListener('keypress', function(event) {
                      const key = event.key;
                      const regex = /[a-z A-Z]/;
                      if (!regex.test(key)) {
                        event.preventDefault();
                      }
                    });
                    </script>
                  
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Rivera" name="mname" value="<?php echo $row['mname'] ?>" autocomplete="off" required>
                        <center><label>Middle Name</label><br></center>
                    </div>
                    <script>
                    const middleNameInput = document.querySelector('input[name="mname"]');
                    middleNameInput.addEventListener('keypress', function(event) {
                      const key = event.key;
                      const regex = /[a-z A-Z]/;
                      if (!regex.test(key)) {
                        event.preventDefault();
                      }
                    });
                  </script>
                </div>
                <br>
                <div class="row rows-col-3">
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" type="date" name="bday" value="<?php echo $row['bday'] ?>" autocomplete="off" required>
                        <center><label>Birthday</label></center>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                        <select class="form-control centered" name="gender" autocomplete="off" required>
                            <option selected disabled>SELECT GENDER</option>
                            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                        <center><label>Gender</label></center>
                    </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" name="contact_number" value="<?php echo $row['contact_number'] ?>" autocomplete="off" required>
                    <center><label>Contact no.</label></center>
                </div>
                <script>
                  const contactInput = document.querySelector('input[name="contact_number"]');
                  contactInput.addEventListener('input', function() {
                    const regex = /^[0-9]{11}$/;
                    if (!regex.test(contactInput.value)) {
                      contactInput.setCustomValidity('Invalid phone number format');
                    } else {
                      contactInput.setCustomValidity('');
                    }
                  });
                  contactInput.addEventListener('keypress', function(event) {
                    if (isNaN(event.key)) {
                      event.preventDefault();
                    }
                    if (contactInput.value.length >= 11) {
                      event.preventDefault();
                    }
                  });
                </script>
            </div>
            <br>
            <div class="row rows-col-3">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Office Tel" id="" name="office_tel" value="<?php echo $row['office_tel'] ?>"autocomplete="off">
                    <center><label>Office Tel</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                  <select class="form-select" id="nationality" name="nationality" required>
                    <option selected disabled>Select Nationality</option>
                    <option value="American" <?php echo ($row['nationality'] == 'American') ? 'selected' : ''; ?>>American</option>
                    <option value="Cambodian" <?php echo ($row['nationality'] == 'Cambodian') ? 'selected' : ''; ?>>Cambodian</option>
                    <option value="Chinese" <?php echo ($row['nationality'] == 'Chinese') ? 'selected' : ''; ?>>Chinese</option>
                    <option value="Filipino" <?php echo ($row['nationality'] == 'Filipino') ? 'selected' : ''; ?>>Filipino</option>
                    <option value="Indian" <?php echo ($row['nationality'] == 'Indian') ? 'selected' : ''; ?>>Indian</option>
                    <option value="Indonesian" <?php echo ($row['nationality'] == 'Indonesian') ? 'selected' : ''; ?>>Indonesian</option>
                    <option value="Japanese" <?php echo ($row['nationality'] == 'Japanese') ? 'selected' : ''; ?>>Japanese</option>
                    <option value="Korean" <?php echo ($row['nationality'] == 'Korean') ? 'selected' : ''; ?>>Korean</option>
                    <option value="Laotian" <?php echo ($row['nationality'] == 'Laotian') ? 'selected' : ''; ?>>Laotian</option>
                    <option value="Malaysian" <?php echo ($row['nationality'] == 'Malaysian') ? 'selected' : ''; ?>>Malaysian</option>
                    <option value="Myanmar (Burmese)" <?php echo ($row['nationality'] == 'Myanmar (Burmese)') ? 'selected' : ''; ?>>Myanmar (Burmese)</option>
                    <option value="Singaporean" <?php echo ($row['nationality'] == 'Singaporean') ? 'selected' : ''; ?>>Singaporean</option>
                    <option value="Thai" <?php echo ($row['nationality'] == 'Thai') ? 'selected' : ''; ?>>Thai</option>
                    <option value="Vietnamese" <?php echo ($row['nationality'] == 'Vietnamese') ? 'selected' : ''; ?>>Vietnamese</option>
                  </select>
                  <center><label for="nationality">Nationality</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="City" value="<?php echo $row['city'] ?>" name="city" autocomplete="off" required>
                    <center><label>City</label></center><br>
                </div>
                <script>
                const cityInput = document.querySelector('input[name="city"]');
                cityInput.addEventListener('keypress', function(event) {
                  const key = event.key;
                  const regex = /[a-z A-Z]/;
                  if (!regex.test(key)) {
                    event.preventDefault();
                  }
                });
              </script>
            </div>
            <div class="row rows-col-2">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                    <input class="form-control" type="text" placeholder="Home Address" name="address" value="<?php echo $row['address'] ?>" autocomplete="off" required>
                    <center><label>Home Address</label></center><br>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                    <input class="form-control" type="text" placeholder="email@gmail.com" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" required>
                    <center><label>Email</label></center>
                    <?php
                        //     if ($haha == "ew") {
                        // ?>
                        <!-- // <h6 style="color: red;">The Email you enter is already existing!</h6> -->
                        <?php
                      // } $haha = "";
                      ?>
                </div>
                  <script>
                    const emailInput = document.querySelector('input[name="email"]');
                    emailInput.addEventListener('input', function() {
                        const regex = /^[^\s@]+@(gmail|yahoo)\.com$/i;
                        if (!regex.test(emailInput.value)) {
                            emailInput.setCustomValidity('Please enter a valid Gmail or Yahoo email address');
                        } else {
                            emailInput.setCustomValidity('');
                        }
                    });
                  </script>
            </div>
          </div>
          
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="s_update_employee">Update</button>
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
        title: 'UPDATING ACCOUNT!',
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
    }
  ?>

      <!-- Modal for View Info For Employees -->

      <?php
      $sql = "SELECT * FROM bergs_registration";
      if($rs=$conn->query($sql)){
          while ($row=$rs->fetch_assoc()) {
      ?>
        <div class="modal fade modal-lg" id="view_info<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Personal Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <!-- Upload Pic -->

                <form class="form" id="form" action="s_registering_of_accounts.php" method="post" enctype="multipart/form-data">
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
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="department" value="<?php echo $row['department'] ?>" autocomplete="off" readonly>
                    <center><label>Department</label></center>
                </div>

                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
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
                      <input class="form-control" id="inputGroupSelect01" name="shift" type="text" readonly value="<?php echo $selected_shift ?>" required>
                    <center><label>Shift</label><br></center>
                </div>

                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Rivera" name="cardnum" value="<?php echo $row['cardnum'] ?>" autocomplete="off" readonly>
                    <center><label>Card Number</label><br></center>
                </div>

            </div>
            <br>
        <div class="row rows-col-3">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Office Tel" name="office_tel" value="<?php echo $row['office_tel'] ?>"autocomplete="off">
                    <center><label>Office Tel</label></center>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Nationality" name="nationality" value="<?php echo $row['nationality'] ?>" autocomplete="off" readonly>
                    <center><label>Nationality</label><br></center>
                </div>
                
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="City" name="city" value="<?php echo $row['city'] ?>" autocomplete="off" required>
                    <center><label>City</label></center><br>
                </div>
            </div>
            <div class="row rows-col-2">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                    <input class="form-control" type="text" placeholder="Home Address" name="address" value="<?php echo $row['address'] ?>" autocomplete="off" required>
                    <center><label>Home Address</label></center><br>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                    <input class="form-control" type="text" placeholder="email@gmail.com" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" required>
                    <center><label>Email</label></center>
                </div>
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
  
   <!-- Modal for Individual-->
     <div class="modal fade modal-lg" id="mod-indiv" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Print by Invididual</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body h-100 justify-content-center">
            <div class="row">
              <div class="col-12 py-2">
                <input class="form-control" type="text" placeholder="Choose Individual" name="employee_id" autocomplete="off" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            <button class="btn btn-sm btn-success" type="submit" data-toggle="tooltip" data-placement="left" name="" title="Print"><i class="fa-solid fa-print"></i> Print</button>
          </div>
        </div>
      </div>
    </div>
    
     <!-- Modal for Department-->
     <div class="modal fade modal-lg" id="mod-dept" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Print by Department</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
         <div class="modal-body h-100 justify-content-center">
            <div class="row">
              <div class="col-12 py-2">
                <select class="form-control centered" value="department" name="department" autocomplete="off" required>
                    <option selected disabled>Select Department</option>
                    <option value="">Department 1</option>
                    <option value="">Department 2</option>
                    <option value="">Department 3</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab"><i class="fa-solid fa-x"></i> Close</button>
            <button class="btn btn-sm btn-success" type="submit" data-toggle="tooltip" data-placement="left" name="" title="Print"><i class="fa-solid fa-print"></i> Print</button>
          </div>
        </div>
      </div>
    </div>
  
  
  
  
  

<script>
if (window.performance) {
  if (performance.navigation.type == 1) {
    // Reloaded the page using the browser's reload button
    window.location.href = "s_list";
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
