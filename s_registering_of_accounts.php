<?php
session_start();
include 'dbconn.php';

$haha="";
if (isset($_POST['register'])) {
  $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
  $department = $_POST['department'];
  $shift = $_POST['shift'];
  $cardnum = $_POST['cardnum'];
  $date_of_employment = trim($_POST['date_of_employment']);
  $title = trim($_POST['title']);
  $company_name = trim($_POST['company_name']);
  $privilege = trim($_POST['privilege']);
  $lname = trim($_POST['lname']);
  $fname = trim($_POST['fname']);
  $mname = trim($_POST['mname']);
  $bday = trim($_POST['bday']); // not req
  $gender = trim($_POST['gender']);
  $contact_number = trim($_POST['contact_number']); // not req
  $office_tel = trim($_POST['office_tel']);
  $nationality = trim($_POST['nationality']);
  $city = trim($_POST['city']);
  $address = trim($_POST['address']); // not req
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password_md5 = md5($password);
  $confirm_password = trim($_POST['confirm_password']);
  $_SESSION['form_data'] = $_POST;
  
  $fullname = $fname . ' ' . $mname . ' ' . $lname;

   // Check if the email already exists in the database
   $query_check = "SELECT * FROM bergs_registration WHERE email='$email'";
   $result_check = mysqli_query($conn, $query_check);
   $count = mysqli_num_rows($result_check);

   if ($count > 0) {
     // If email already exists, redirect back to modal with error message
      $_SESSION['open_modal'] = true;
      $haha="ew";
      // Get the selected position from the form
      $department = $_POST['department'];
      $shift = $_POST['shift'];
      $image = $_SESSION['form_data']['image'];
      // Store the selected position in the session
      $_SESSION['form-data']['department'] = $department;
      $_SESSION['form-data']['shift'] = $shift;
      $_SESSION['form-data']['image'] = $image;
      // Redirect to the next page
      header("Location: s_account");
   } else {
     // If email does not exist, insert new user into database
     $year = date('y');
     $month = date('m');
    
     // Get the highest number used for this year and month
     $sql = "SELECT MAX(RIGHT(id, 3)) AS max_number FROM bergs_registration WHERE LEFT(id, 4) = '$year$month'";
     $result = $conn->query($sql);
     $row = $result->fetch_assoc();
     $max_number = $row['max_number'];

     // Set the starting number for this year and month
     $start_number = 1;
     if ($max_number !== null) {
         $start_number = $max_number + 1;
     }
     // Generate the ID with leading zeros
    $number_part = sprintf('%02d', $start_number);
    if ($privilege == "HR Staff") {
      $id = "HR".$year.$month.$number_part;
    }elseif ($privilege == "Employee") {
      $id = sprintf('%02d%02d%04d', $year, $month, $number_part);
    }elseif ($privilege == "Guest") {
      $id = sprintf('%02d%02d%04d', $year, $month, $number_part);
    }
    
     $query1 = "INSERT INTO bergs_registration SET
     `id`='$id',
     `image`= '$file',
     `department`='$department',
     `shift_num`='$shift',
     `cardnum`='$cardnum',
     `date_of_employment`='$date_of_employment',
     `title`='$title',
     `company_name`='$company_name',
     `privilege`='$privilege',
     `lname`='$lname',
     `fname`='$fname',
     `mname`='$mname',
     `bday`='" . ($bday ? $bday : '') . "',
     `gender`='$gender',
     `contact_number`='" . ($contact_number ? $contact_number : '') . "',
     `address`='" . ($address ? $address : '') . "',
     `office_tel`='$office_tel',
     `nationality`='$nationality',
     `city`='$city',
     `email`='$email',
     `password`='$password_md5',
     `status`='Active'";
    $query_run1 = mysqli_query($conn, $query1);
    
    $query2 = "INSERT INTO bergs_login SET
      `id`='$id',
      `image`= '$file',
      `email`='$email',
      `password`='$password_md5',
      `full_name`='$fullname',
      `position`='$privilege',
      `status`='Active'";
    $query_run2 = mysqli_query($conn, $query2);
    
    
     unset($_SESSION['form_data']);
     header("location: s_account");
     exit;
   }
 }
 ?>
