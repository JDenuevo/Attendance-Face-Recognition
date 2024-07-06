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

      <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" >
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
    <nav class="col-md-2 col-lg-2 d-md-block sidebar border-end">
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

      <button class="btn btn-sm btn-outline-primary my-1" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="View Filter">
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
    
      <button class="btn btn-sm btn-outline-primary float-end my-1 mx-1" data-bs-toggle="modal" data-bs-target="#Eregister" data-toggle="tooltip" data-placement="left" title="Register Account">
        <i class="fa-solid fa-plus"></i> Register Account
      </button>

     <a style = "text-decoration: none;" href="a_account_deleted">
      <button class="btn btn-sm btn-outline-secondary float-end my-1 mx-1" data-toggle="tooltip" data-placement="left" title="See removed Accounts">
        <i class="fa-solid fa-trash"></i> See removed Accounts
      </button></a>

      <br>
        <br>
      <div class="mt-3" style = "overflow-x:auto">
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
            $sql="SELECT * FROM `bergs_login` WHERE status = 'Active'";
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
                  <button class="btn btn-sm btn-outline-primary" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" data-placement="left" title="Click to see more Actions">
                    <i class="fa-solid fa-share"></i> Actions
                  </button>
                  <ul class="dropdown-menu dropdown-menu-light text-small shadow text-center">
                  <?php if($row['position'] !== 'Administrator'){?>
                      <button class="btn btn-sm btn-primary mt-1 mt-auto" data-toggle="tooltip" data-placement="left" data-bs-toggle="modal" data-bs-target="#updatemodal_modify_<?php echo $row['id'] ?>" type="button" title="Update info">
                          <i class="fa-solid fa-pen-to-square"></i>
                          Update
                      </button>
                  <?php } ?>
                  <button class="btn btn-sm btn-secondary mt-1" data-toggle="tooltip" data-placement="left" data-bs-toggle="modal" data-bs-target="#view_info<?php echo $row['id'] ?>" type="button" title="Click to View Info">
                      <i class="fa-solid fa-file"></i>
                      View Info
                  </button>
                  <?php if($row['position'] !== 'Administrator'){?>
                      <button class="btn btn-sm btn-danger mt-1" onclick="showDeleteConfirmation('<?php echo $row['id']; ?>');"data-toggle="tooltip" data-placement="left" title="Remove">
                          <i class="fa-solid fa-trash"></i>
                          Remove
                      </button>
                  <?php } ?>
              </ul>


                </div>
              </td>
            </tr>

            <script>
              function showDeleteConfirmation(id) {
                Swal.fire({
                    title: 'REMOVE ACCOUNT!',
                    text: 'Do you want to remove the account?',
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
                    title: 'REMOVING ACCOUNT!',
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

                  window.location.href = 'a_remove_account?id=' + id;


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
    <?php
        if (isset($_SESSION['open_modal']) == true) {
      echo "<script>
              jQuery(document).ready(function(){
                  jQuery('#Eregister').modal('show');
              });
          </script>";
      unset($_SESSION['open_modal']);
      $haha= "ew";
    } ?>

    <!-- Modal for Employees -->
    <div class="modal fade modal-lg" id="Eregister" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registration for Employees</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- Upload Pic -->

            <form class="form" id="form" action="a_registering_of_accounts.php" method="post" enctype="multipart/form-data">
              <div class="upload" id="upload">
                <center>
                  <div id="idbox" class="shadow border border-opacity-50">
                      <?php if(isset($_SESSION['form-data']['image'])): ?>
                          <img src="<?php echo $_SESSION['form-data']['image']; ?>" alt="Uploaded Image">
                      <?php endif; ?>
                  </div>
                  <div class="btn rounded">
                      <i class="fa-solid fa-camera"></i>
                      <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required>
                  </div>
                </center>
              </div>
                <script>
                    const image_input = document.querySelector("#image");
                    var uploaded_image = "";

                    image_input.addEventListener("change", function() {
                        const reader = new FileReader();
                        reader.addEventListener("load", () => {
                            uploaded_image = reader.result;
                            document.querySelector("#idbox").style.backgroundImage = `url('${uploaded_image}')`;
                        });
                        reader.readAsDataURL(this.files[0]);
                    })
                </script>
            <br>
            
            <div class="row rows-col-3">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <select class="form-select" id="department" name="department" required>
                    <option selected disabled>Select Department</option>
                    <?php
                        $last_department = '';
                        if (isset($_SESSION['form-data']['department'])) {
                        $last_department = $_SESSION['form-data']['department'];
                        // Store the last selected department in local storage
                        echo "<script>localStorage.setItem('lastDepartment', '$last_department');</script>";
                        } else {
                        // Retrieve the last selected department from local storage
                        echo "<script>var lastDepartment = localStorage.getItem('lastDepartment');</script>";
                        $last_department = "<script>document.write(lastDepartment);</script>";
                        }
                        $sql = "SELECT * FROM bergs_department";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)) {
                        $selected = ($row['dep_name'] == $last_department) ? 'selected' : '';
                    ?>
                        <option value="<?= $row['dep_name'] ?>" <?= $selected ?>><?= $row['dep_name'] ?></option>
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
                        $last_shift = '';
                        if (isset($_SESSION['form-data']['shift'])) {
                            $last_shift = $_SESSION['form-data']['shift'];
                            // Store the last selected position in local storage
                            echo "<script>localStorage.setItem('lastShift', '$last_shift');</script>";
                        } else {
                            // Retrieve the last selected position from local storage
                            echo "<script>var lastShift = localStorage.getItem('lastShift');</script>";
                            $last_shift = "<script>document.write(lastShift);</script>";
                        }
                        $sql = "SELECT * FROM bergs_shift";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $selected = ($row['shift_num'] == $last_shift) ? 'selected' : '';
                            $start_time = date('g:i A', strtotime($row['shift_start']));
                            $end_time = date('g:i A', strtotime($row['shift_end']));
                            ?>
                            <option value="<?= $row['shift_num'] ?>" <?= $selected ?>><?= $start_time ?> to <?= $end_time ?></option>
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
                    <input class="form-control" type="text" placeholder="Card Number" name="cardnum" value="<?php echo isset($_SESSION['form_data']['cardnum']) ? $_SESSION['form_data']['cardnum'] : ''; ?>" autocomplete="off" required>
                    <center><label>Card Number</label></center>
                </div>
            </div>
            <br>
            <div class="row rows-col-3">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="date" placeholder="Date of Employment" name="date_of_employment" value="<?php echo isset($_SESSION['form_data']['date_of_employment']) ? $_SESSION['form_data']['date_of_employment'] : ''; ?>" autocomplete="off" required>
                    <center><label>Date of Employment</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Title" name="title" value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : ''; ?>" autocomplete="off" required>
                    <center><label>Title</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Company Name" name="company_name" value="<?php echo isset($_SESSION['form_data']['company_name']) ? $_SESSION['form_data']['company_name'] : ''; ?>" autocomplete="off" required>
                    <center><label>Company Name</label></center>
                </div>
            </div>
            <br>
            <div class="row rows-col-3">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <select class="form-select" value="<?php echo isset($_SESSION['form_data']['privilege']) ? $_SESSION['form_data']['privilege'] : ''; ?>" name="privilege" autocomplete="off" required>
                        <option selected disabled>Select Privilege</option>
                        <option value="Administrator" <?php echo (isset($_SESSION['form_data']['privilege']) && $_SESSION['form_data']['privilege'] == 'Administrator') ? 'selected' : ''; ?>>Administrator</option>
                        <option value="HR Staff" <?php echo (isset($_SESSION['form_data']['privilege']) && $_SESSION['form_data']['privilege'] == 'HR Staff') ? 'selected' : ''; ?>>HR Staff</option>
                        <option value="Employee" <?php echo (isset($_SESSION['form_data']['privilege']) && $_SESSION['form_data']['privilege'] == 'Employee') ? 'selected' : ''; ?>>Employee</option>
                        <option value="Guest" <?php echo (isset($_SESSION['form_data']['privilege']) && $_SESSION['form_data']['privilege'] == 'Guest') ? 'selected' : ''; ?>>Guest</option>
                    </select>
                    <center><label>Privilege</label></center>
                </div>
            </div>    
            <br>
            <div class="row rows-col-3">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Dela Cruz" name="lname" value="<?php echo isset($_SESSION['form_data']['lname']) ? $_SESSION['form_data']['lname'] : ''; ?>" autocomplete="off" required>
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Juan" name="fname" value="<?php echo isset($_SESSION['form_data']['fname']) ? $_SESSION['form_data']['fname'] : ''; ?>" autocomplete="off" required>
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Rivera" name="mname" value="<?php echo isset($_SESSION['form_data']['mname']) ? $_SESSION['form_data']['mname'] : ''; ?>" autocomplete="off" required>
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="date" value="<?php echo isset($_SESSION['form_data']['bday']) ? $_SESSION['form_data']['bday'] : ''; ?>" placeholder="Month / Day / Year" name="bday" autocomplete="off">
                    <center><label>Birthday</label></center>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <select class="form-select" value="<?php echo isset($_SESSION['form_data']['gender']) ? $_SESSION['form_data']['gender'] : ''; ?>" name="gender" autocomplete="off" required>
                    <option selected disabled>Select Gender</option>
                    <option value="Male" <?php echo (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
                    <center><label>Gender</label></center>
                </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="text" value="<?php echo isset($_SESSION['form_data']['contact_number']) ? $_SESSION['form_data']['contact_number'] : ''; ?>" placeholder="09XX-XXX-XXXX" name="contact_number" autocomplete="off">
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
                <input class="form-control" type="text" placeholder="Office Tel" id="" name="office_tel" value="<?php echo isset($_SESSION['form_data']['office_tel']) ? $_SESSION['form_data']['office_tel'] : ''; ?>"autocomplete="off">
                <center><label>Office Tel</label></center>
            </div>
            <div class="col-12 col-lg-4 col-md-4 col-sm-12">
              <select class="form-select" id="nationality" value="<?php echo isset($_SESSION['form_data']['nationality']) ? $_SESSION['form_data']['nationality'] : ''; ?>" name="nationality" required>
                <option selected disabled>Select Nationality</option>
                <option value="American" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'American') ? 'selected' : ''; ?>>American</option>
                <option value="Cambodian" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Cambodian') ? 'selected' : ''; ?>>Cambodian</option>
                <option value="Chinese" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Chinese') ? 'selected' : ''; ?>>Chinese</option>
                <option value="Filipino" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Filipino') ? 'selected' : ''; ?>>Filipino</option>
                <option value="Indian" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Indian') ? 'selected' : ''; ?>>Indian</option>
                <option value="Indonesian" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Indonesian') ? 'selected' : ''; ?>>Indonesian</option>
                <option value="Japanese" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Japanese') ? 'selected' : ''; ?>>Japanese</option>
                <option value="Korean" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Korean') ? 'selected' : ''; ?>>Korean</option>
                <option value="Laotian" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Laotian') ? 'selected' : ''; ?>>Laotian</option>
                <option value="Malaysian" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Malaysian') ? 'selected' : ''; ?>>Malaysian</option>
                <option value="Myanmar (Burmese)" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Myanmar (Burmese)') ? 'selected' : ''; ?>>Myanmar (Burmese)</option>
                <option value="Singaporean" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Singaporean') ? 'selected' : ''; ?>>Singaporean</option>
                <option value="Thai" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Thai') ? 'selected' : ''; ?>>Thai</option>
                <option value="Vietnamese" <?php echo (isset($_SESSION['form_data']['nationality']) && $_SESSION['form_data']['nationality'] == 'Vietnamese') ? 'selected' : ''; ?>>Vietnamese</option>
              </select>
              <center><label for="nationality">Nationality</label></center>
            </div>
            <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="text" placeholder="City" value="<?php echo isset($_SESSION['form_data']['city']) ? $_SESSION['form_data']['city'] : ''; ?>" name="city" autocomplete="off" required>
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
            <div class="col-lg-6 col-md-6 col-sm-12">
                <input class="form-control" type="text" placeholder="Home Address" value="<?php echo isset($_SESSION['form_data']['address']) ? $_SESSION['form_data']['address'] : ''; ?>" name="address" autocomplete="off">
                <center><label>Home Address</label></center><br>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <input class="form-control" type="text" placeholder="email@gmail.com" value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>" name="email" autocomplete="off" required>
                    <center><label>Email</label></center>
                    <?php
                        if ($haha == "ew") {
                    ?>
                    <h6 style="color: red;">The Email you enter is already existing!</h6>
                    <?php } $haha = "";?>
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
        <div class="row rows-col-3">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="text" placeholder="Password" id="password" name="password" autocomplete="off" required>
                <center><label>Password</label></center>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <input class="form-control" type="text" placeholder="Confirm Password" id="confirm_password" name="confirm_password" autocomplete="off" required>
                <center><label>Confirm Password</label></center>
            </div>
            <script>
              const passwordInput = document.querySelector('#password');
              const confirmInput = document.querySelector('#confirm_password');

              confirmInput.addEventListener('input', function() {
                  if (confirmInput.value !== passwordInput.value) {
                      confirmInput.setCustomValidity('Passwords do not match');
                  } else {
                      confirmInput.setCustomValidity('');
                  }
              });

              document.querySelector('form').addEventListener('submit', function() {
                  if (confirmInput.value !== passwordInput.value) {
                      confirmInput.setCustomValidity('Passwords do not match');
                  } else if (passwordInput.value.length < 6) {
                      passwordInput.setCustomValidity('Password must be at least 6 characters long');
                  } else {
                      confirmInput.setCustomValidity('');
                      passwordInput.setCustomValidity('');
                  }
              });
          </script>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a class="btn btn-primary w-100" onclick="generatePassword()"><i class="fa-solid fa-key"></i> Generate</a><br><br>
            </div>

            <script>
               function generatePassword() {
                 const length = 15; // Change this to adjust password length
                 const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                 let password = "";

                 for (let i = 0; i < length; i++) {
                   const randomIndex = Math.floor(Math.random() * charset.length);
                   password += charset[randomIndex];
                 }

                 document.getElementById("password").value = password;
                 document.getElementById("confirm_password").value = password;
               }
             </script>

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-success" name="register">Register</button>
      </div>
    </div>
  </div>
</div>
</form>
    <!-- Modal for Update Account-->
<?php
  $sql = "SELECT * FROM bergs_login";
  if($rs=$conn->query($sql)){
      while ($row=$rs->fetch_assoc()) {
?>

<form action="a_update_account.php" method="POST">
  <div class="modal fade modal-lg" id="updatemodal_modify_<?php echo $row['id'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down modal-fullscreen-md-down">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row row-col-2">
              <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
                <label>Employee ID</label>
                <input class="form-control" type="text" name="id" value="<?php echo $row['id'] ?>" autocomplete="off" readonly>
              </div>
              <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
                 <label>Fullname</label>
                 <input class="form-control" type="text" name="full_name" value="<?php echo $row['full_name'] ?>" autocomplete="off" required>
             </div>
        </div>
            <div class="row row-col-2">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
                 <label>Email</label>
                 <input class="form-control" type="text" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" readonly>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 py-2">
                 <label>Password</label>
                 <input class="form-control" type="text"value="" placeholder="Input your Password" name="password" autocomplete="off" id="acc_password">
                </div>
            </div>
          </div>
        <div class="modal-footer ">
          <div class="div">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
            <button type="submit" class="btn btn-sm btn-primary" name="update_account" data-toggle="tooltip" data-placement="left" title="Update Account">Update</button>
          </div>
        </div>
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
      $sql = "SELECT * FROM bergs_login";
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
            <div class="row">
                <div class="col-12 col-lg-4 col-md-4 col-sm-12 ">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <input class="form-control" type="text" placeholder="Juan Dela Cruz" name="full_name" value="<?php echo $row['full_name'] ?>" autocomplete="off" readonly>
                    <center><label>Full Name</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="email@gmail.com" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" readonly>
                    <center><label>Email</label></center>
                </div>
                <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                    <input class="form-control" type="text" placeholder="Role" name="role" value="<?php echo $row['position'] ?>" autocomplete="off" readonly>
                    <center><label>Role</label></center>
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
    window.location.href = "a_account";
  }
}</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>
