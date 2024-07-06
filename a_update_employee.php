<?php
include("dbconn.php");
session_start();

if (isset($_POST['update_employee'])){

  $id = trim($_POST['id']);
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
    $fullname = $fname . " " . $mname . " " . $lname;
  $update = "SELECT * FROM bergs_registration WHERE id = '$id'";
  $result = $conn->query($update);

  $errors2 = array();


if($result->num_rows > 0){
    $sql = "UPDATE bergs_registration SET department='$department',shift_num='$shift',cardnum='$cardnum',date_of_employment='$date_of_employment',title='$title',company_name='$company_name',privilege='$privilege', lname = '$lname', fname = '$fname', mname = '$mname', bday = '$bday', gender = '$gender', contact_number = '$contact_number',office_tel = '$office_tel',nationality = '$nationality',  city = '$city',address = '$address', email = '$email' WHERE id = '$id'";

    if ($result1 = $conn->query($sql) === TRUE) {

        $sql2= "UPDATE bergs_login SET email='$email', position='$privilege', full_name='$fullname' WHERE id='$id'";
        $result2 = $conn->query($sql2);

        // Notify user that the update was successful
        $errors2[] = "Employee was successfully updated.";
        
    } if (!empty($errors2)) {
        // Redirect back to the login page with the error messages
        $errorString2 = implode(',', $errors2);
        header('Location: a_list?errors2=' . urlencode($errorString2));
        exit();
      }
    }
}
      // Close database connection and redirect user
      $conn->close();

?>