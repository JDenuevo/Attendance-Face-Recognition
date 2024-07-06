<?php
require 'a_form_validation.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Events | BERGS</title>
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
  <nav class="navbar navbar-expand-lg navbar-expand-md  shadow p-1 rounded fixed-top" id="navbar" style="background-color: #DAEAF1;">
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
            <a class="nav-link list-group-item border text-truncate rounded active" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="a_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
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
        <h2>Manage an Event</h2>
      </div>
      <hr>

       <div class="text-end">
        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#createevent" type="button" data-toggle="tooltip" data-placement="left" title="Create new Event!"> <i class="fa-solid fa-plus"></i> Create New</button>
      </div>
      
      
      
      
      
      
<!--================================================================== DONT TOUCH THIS TAPOS NA TO (JHEMAR LANG AAYOS NG UI NITO)=====================================================================================================-->
      <form action="add_event.php" method="post">
        <div class="modal fade modal-lg" id="createevent" tabindex="-1" aria-labelledby="creatememo1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title fw-bold">Create a new Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="row">
                    <div class="col-12 py-2">
                         <input class="form-control" type="text" placeholder="Enter your Event Subject" name="e_subject" autocomplete="off" required>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-12 py-2">
                         <label>WHEN:</label>
                         <input class="form-control" type="date" placeholder="Enter A Date" name="e_date" autocomplete="off" required>
                    </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-6 py-2">
                        <select class="form-select" name="select-deduction" id="select-deduction" required>
                          <option value="wala to" id="wala to" selected disabled>Select Event options</option>
                          <option value="to-all" id="to-all"><i class="fa-solid fa-people-group"></i> To All</option>
                          <option value="by-dept" id="by-dept"><i class="fa-solid fa-building-user"></i> By Department</option>
                        </select>
                    </div>
                    <div class="col-6 py-2 text-start">
                        <select class="form-select" name="select-dept" id="select-dept" required>
                         <option value="" id="" selected disabled>Select Department options</option>
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
                    </div>
                
                </div>
              </div>

              <div class="modal-body">
                <textarea class="form-control" placeholder="Enter your Event Description" id="e_description" name="e_description"></textarea>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                <button type="submit" class="btn btn-success" data-bs-toggle="modal" name="add_event" data-toggle="tooltip" data-placement="left" title="Add new Event now!"><i class="fa-solid fa-plus"></i> Add Event</button>
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
          title: 'ADDING EVENT!',
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
      // Display error messages if they were passed in the URL
      if (isset($_GET['errors2'])) {
        $error2 = $_GET['errors2'];
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'ADDING EVENT!',
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
<!--================================================================== END NG ADD MODAL (JHEMAR LANG AAYOS NG UI NITO)=====================================================================================================-->







<!--================================================================== START NG OPEN MODAL WAG GAGALAWIN UNLESS JHEMAR DENUEVO O KIAN UBANA ANG PANGALAN MO (PAAYOS NG UI) ================================================-->

      <?php
  $sql = "SELECT * FROM `bergs_event` ORDER BY event_num DESC";
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

   <div class="col-12 col-lg-4 col-md-4 col-sm-12 py-2" id="pevent">
          <div class="card shadow">
              <div class="card-body text-center">
                  <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>"><?php echo $row['event_subject'] . " | " . date('F d Y', strtotime($row['event_date']));  ?></button><br>
                  <br>
                  <p class = "text-truncate"><?php echo $row['event_description']; ?></p>
                  <!-- MODAL -->
                  <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                              <div class="modal-body">
                                 <div class="text-center">
                    
                                    <label class="fw-bold fs-5">Event</label>
                                    <hr>
                                </div>
                                <div class="text-start">
                                    <label class="fw-semibold text-start">TO: </label>
                                    <label class="text-start"><?php echo $row['event_to']; ?></label>
                                    <br>
                                    
                                    <label class="fw-semibold text-start">WHEN: </label>
                                    <label class="text-start"><?php echo date('F d Y', strtotime($row['event_date'])); ?></label>
                                    <br>
    
                                    <label class="fw-semibold text-start">SUBJECT: </label>
                                    <label class="text-start" id="<?php echo $modal_id; ?>"><?php echo $row['event_subject']; ?></label>
                                    <br><br>
                                    <p class="lh-base" style="text-indent: 40px; text-align: justify;"><?php echo $row['event_description']; ?></p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Close Tab">Close</button>
                                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" onclick="showDeleteConfirmation('<?php echo $row['event_num']; ?>');" data-toggle="tooltip" data-placement="left" title="Remove this Event??"><i class="fa-solid fa-trash"></i> Remove</button>
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
  
<!--================================================================== END NG OPEN MODAL WAG GAGALAWIN UNLESS JHEMAR DENUEVO O KIAN UBANA ANG PANGALAN MO (PAAYOS NG UI) ================================================-->
        <script>
            function showDeleteConfirmation(event_num) {
                  Swal.fire({
                    title: 'REMOVE EVENT!',
                    text: 'Do you want to remove this event?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // Send AJAX request to delete the data
                      $.ajax({
                        type: 'POST',
                        url: 'a_event_remove.php',
                        data: {event_num: event_num},
                        dataType: 'json',
                        success: function(response) {
                          // Handle success response
                          Swal.fire({
                            icon: 'success',
                            title: 'REMOVING EVENT!',
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
                          // Reload the page to reflect the changes
                          location.reload();
                        },
                        error: function(xhr, status, error) {
                          // Handle error response
                          Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: 'Please try again later.'
                          });
                        }
                      });
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
              <a class="nav-link list-group-item border text-truncate rounded active" data-toggle="tooltip" data-placement="left" title="Set a Event!" href="a_event"><i class="fa-solid fa-calendar-week"></i> Event</a>
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

<script>
// Select the relevant DOM elements
const selectDeduction = document.querySelector('#select-deduction');
const selectDept = document.querySelector('#select-dept');




// Disable the select-dept and employee_id inputs by default
    selectDept.disabled = true;
    selectDept.style.display = 'none';




// Add an event listener to the select-deduction element to listen for changes
selectDeduction.addEventListener('change', (event) => {
  const selectedValue = event.target.value;

   if (selectedValue === 'to-all') {
    // Disable both select-dept and employee_id inputs
    selectDept.disabled = true;
    selectDept.style.display = 'none';


  } else if (selectedValue === 'by-dept') {
    // Disable employee_id input and enable select-dept input
    selectDept.disabled = false;
    selectDept.style.display = 'block';


  }
});


</script>

</body>
</html>
