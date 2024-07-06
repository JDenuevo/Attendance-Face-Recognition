<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("dbconn.php");
session_start();
date_default_timezone_set('Asia/Manila');

if (isset($_POST['update'])) {
    $errors2 = array();
    // Get data to insert from form submission
    $timetable_name = $_POST['shift_name'];
    $shift_num = $_POST['shift_num'];
    $shift_start = $_POST['start_time'];
    $shift_end = $_POST['end_time'];
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

    // Update shift in the database
$sql = "UPDATE bergs_shift SET shift_name = '$timetable_name', shift_start = '$shift_start', shift_end = '$shift_end', late_start = '$late_time', leave_early = '$leave_early', beginning_in = ";
if (empty($beginning_in)) {
    $sql .= "NULL";
} else {
    $sql .= "'$beginning_in'";
}
$sql .= ", end_in = ";
if (empty($end_in)) {
    $sql .= "NULL";
} else {
    $sql .= "'$end_in'";
}
$sql .= ", beginning_out = ";
if (empty($beginning_out)) {
    $sql .= "NULL";
} else {
    $sql .= "'$beginning_out'";
}
$sql .= ", end_out = ";
if (empty($end_out)) {
    $sql .= "NULL";
} else {
    $sql .= "'$end_out'";
}
$sql .= ", beginning_ot_in = ";
if (empty($beginning_ot_in)) {
    $sql .= "NULL";
} else {
    $sql .= "'$beginning_ot_in'";
}
$sql .= ", end_ot_in = ";
if (empty($end_ot_in)) {
    $sql .= "NULL";
} else {
    $sql .= "'$end_ot_in'";
}
$sql .= ", beginning_ot_out = ";
if (empty($beginning_ot_out)) {
    $sql .= "NULL";
} else {
    $sql .= "'$beginning_ot_out'";
}
$sql .= ", end_ot_out = ";
if (empty($end_ot_out)) {
    $sql .= "NULL";
} else {
    $sql .= "'$end_ot_out'";
}
$sql .= " WHERE shift_num = '$shift_num'"; // Add the condition for shift_num


    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Notify user that the update was successful
        $errors2[] = "Shift was successfully updated.";
    } else {
        echo ("Error description: " . mysqli_error($conn));
    }
    if (!empty($errors2)) {
        // Redirect back to the login page with the error messages
        $errorString2 = implode(',', $errors2);
        header('Location: a_shift?errors2=' . urlencode($errorString2));
        exit();
    }

    // Close database connection and redirect user
    $conn->close();
}
?>