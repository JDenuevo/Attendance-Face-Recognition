<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include("dbconn.php");
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_POST['add_btn'])) {
    $errors1 = array();
    // Get data to insert from form submission
        $timetable_name = $_POST['shift_name'];
        $shift_start = $_POST['start_time'];
        $shift_end= $_POST['end_time'];
        $late_time = $_POST['late_time'];
        $leave_early = $_POST['leave_early'];

    $beginning_in = !empty($_POST['beginning_in']) ? $_POST['beginning_in'] : null;
    $end_in = !empty($_POST['end_in']) ? $_POST['end_in'] : null;
    $beginning_out = !empty($_POST['beginning_out']) ? $_POST['beginning_out'] : null;
    $end_out = !empty($_POST['end_out']) ? $_POST['end_out'] : null;
    $beginning_ot_in = !empty($_POST['beginning_ot_in']) ? $_POST['beginning_ot_in'] : null;
    $end_ot_in = !empty($_POST['end_ot_in']) ? $_POST['end_ot_in'] : null;
    $beginning_ot_out = !empty($_POST['beginning_ot_out']) ? $_POST['beginning_ot_out'] : null;
    $end_ot_out = !empty($_POST['end_ot_out']) ? $_POST['end_ot_out'] : null;


        
        // Query database to get last position number
        $sql = "SELECT MAX(shift_num) AS last_shift_number FROM bergs_shift";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_shift_number = $row['last_shift_number'];
          } else {
            $last_shift_number = 0;
          }

        // Increment last position number to generate new position number
        $new_shift_number = $last_shift_number + 1;

        // Insert new position into database
      $sql = "INSERT INTO bergs_shift (shift_num, shift_name, shift_start, shift_end, late_start, leave_early, beginning_in, end_in, beginning_out, end_out, beginning_ot_in, end_ot_in, beginning_ot_out, end_ot_out)
        VALUES ('$new_shift_number', '$timetable_name', '$shift_start', '$shift_end', '$late_time', '$leave_early', ";
            if (empty($beginning_in)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$beginning_in'";
            }
            $sql .= ", ";
            
            if (empty($end_in)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$end_in'";
            }
            $sql .= ", ";
            
            if (empty($beginning_out)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$beginning_out'";
            }
            $sql .= ", ";
            
            if (empty($end_out)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$end_out'";
            }
            $sql .= ", ";
            
            if (empty($beginning_ot_in)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$beginning_ot_in'";
            }
            $sql .= ", ";
            
            if (empty($end_ot_in)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$end_ot_in'";
            }
            $sql .= ", ";
            
            if (empty($beginning_ot_out)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$beginning_ot_out'";
            }
            $sql .= ", ";
            
            if (empty($end_ot_out)) {
              $sql .= "NULL";
            } else {
              $sql .= "'$end_ot_out'";
            }
            
            $sql .= ")";


        if ($conn->query($sql) === TRUE) {
        // Notify user that the insert was successful
        $errors1[] = "Add Shift was successfully added.";
        }else{
          echo("Error description: " . mysqli_error($conn));
        }
        if (!empty($errors1)) {
          // Redirect back to the login page with the error messages
        $errorString1 = implode(',', $errors1);
          header('Location: a_shift?errors1=' . urlencode($errorString1));
          exit();
      }

        // Close database connection and redirect user
        $conn->close();

    }
    ?>
