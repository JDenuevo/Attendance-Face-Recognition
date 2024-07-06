<?php
session_start();
// Include database connection
include ('../dbconn.php');
date_default_timezone_set('Asia/Manila');

// Retrieve employee ID from session
$employee_id = $_SESSION['id'];
$current_time = strtotime(date('H:i:s'));

$sql2 = "SELECT s.shift_start, s.shift_end, s.shift_num, r.fname, r.lname, r.mname
FROM bergs_shift s
JOIN bergs_registration r ON s.shift_num = r.shift_num
WHERE r.id = '$employee_id'";

$result2= $conn->query($sql2);

if (mysqli_num_rows($result2) > 0) {
$row = mysqli_fetch_assoc($result2);

// Get the employee name and time shift details
$employee_name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
$shift_start = strtotime($row['shift_start']);
$shift_end = strtotime($row['shift_end']);
// Get the employee name and time shift details
$employee_name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
if (strtotime($row['shift_start']) > strtotime($row['shift_end'])) {
// Shift starts before midnight and ends after midnight
if ($current_time >= $shift_start || $current_time > $shift_end) {
// Shift is currently ongoing or user is late
$exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
$exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end'] . ' +1 day'));
} elseif($current_time < $shift_end) {
// Shift is in the future
$exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start'] . ' -1 day'));
$exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
}
} else {
// Shift starts and ends on the same day
if ($current_time >= $shift_start && $current_time <= $shift_end) {
// Shift is currently ongoing
$exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
$exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
} elseif ($current_time < $shift_start) {
// Shift is in the future (later today or tomorrow)
$exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
$exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
}
}
$shift_num = $row['shift_num'];

 $rows = array();
 // Query to retrieve attendance records for the employee
 $sql2 = "SELECT a.time_in, a.time_out, a.time_in_OT, a.time_out_OT, a.exp_time_out, s.shift_end, s.leave_early, s.beginning_out, s.end_out, s.beginning_ot_in, s.beginning_ot_out, s.end_ot_in, s.end_ot_out FROM bergs_attendance a 
        JOIN bergs_shift s ON s.shift_num = a.shift_num
        WHERE employee_id = '$employee_id' AND (
    (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
    OR 
    (DATE(exp_time_out) = DATE(NOW()) AND ADDTIME(exp_time_out, '10:00:00') >= NOW()) 
    OR 
    (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
   )";
 $result2 = $conn->query($sql2);
 
 // Check if the query returned any results
 if ($result2->num_rows > 0) {
     // Fetch all attendance data

     while ($row = $result2->fetch_assoc()) {
         $rows[] = $row;
     }
          
          // Set the content type header to JSON
     header('Content-Type: application/json');
     // Return an empty JSON object
     echo json_encode($rows);
    
 } else{
          // Set the content type header to JSON
     header('Content-Type: application/json');
     // Return an empty JSON object
     echo json_encode($rows);
 }

 
}


?>
