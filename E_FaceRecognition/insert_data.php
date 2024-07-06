<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include ('../dbconn.php');

// Set default timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Check if data already exists
$employee_id = $_SESSION['id'];

$current_date = date('Y-m-d');
$cdr = date('Y-m-d', strtotime($current_date));
$current_datetime = strtotime(date('Y-m-d H:i:s'));
$current_time = strtotime(date('H:i:s'));
$time_format = date('H:i:s');
$current_time1 = date('H:i A');
$day_name = date('l');

$join = "SELECT 
    s.shift_num,
    s.shift_start,
    s.shift_end,
    s.beginning_in,
    s.late_start,
    s.end_in,
    s.beginning_out,
    s.end_out,
    r.fname,
    r.lname,
    r.mname 
FROM bergs_shift s
JOIN bergs_registration r ON r.shift_num = s.shift_num
WHERE
    r.id = '$employee_id'
    AND s.shift_num = r.shift_num
    AND (
        (
            TIME(NOW()) >= TIME_FORMAT(s.beginning_in, '%H:%i:%s')
            AND (
                TIME(NOW()) <= TIME_FORMAT(s.end_in, '%H:%i:%s')
                OR TIME_FORMAT(s.beginning_in, '%H:%i:%s') > TIME_FORMAT(s.end_in, '%H:%i:%s')
            )
        )
        OR
        (
            (
                TIME(NOW()) >= '00:00:00'
                AND TIME(NOW()) <= TIME_FORMAT(s.end_in, '%H:%i:%s')
                AND TIME_FORMAT(s.beginning_in, '%H:%i:%s') > TIME_FORMAT(s.end_in, '%H:%i:%s')
            )
        )
    )";

$joinres = $conn->query($join);
if ($joinres === false) {
    // Handle the query error, such as logging or displaying an error message
    echo "Query failed: " . $conn->error;
    exit; // Stop further execution
}
if($joinres->num_rows > 0) {
    $joinrow = $joinres->fetch_assoc();
    $word_shiftstart = date('g:i A',strtotime($joinrow['shift_start']));
    $word_shiftend = date('g:i A', strtotime($joinrow['shift_end']));
    $word_currentdate = date('F j, Y', strtotime($current_date));
    $shift_start = strtotime($joinrow['shift_start']);
    $shift_end = strtotime($joinrow['shift_end']);
    $beginning_in = $joinrow['beginning_in'];
    $end_in = $joinrow['end_in'];
    $late_min = $joinrow['late_start'];
    $shift_num = $joinrow['shift_num'];
    $shifter_start = $joinrow['shift_start'];
    $shifter_end = $joinrow['shift_end'];
    // Get the employee name and time shift details
    $employee_name = $joinrow['fname'] . ' ' . $joinrow['mname'] . ' ' . $joinrow['lname'];
           
            if ($shift_start > $shift_end) {
                // Shift starts before midnight and ends after midnight
                if ($current_time >= $shift_start || $current_time > $shift_end) {
                    // Shift is currently ongoing or user is late
                    $exp_in = date('Y-m-d H:i:s', $shift_start);
                    $exp_out = date('Y-m-d H:i:s', strtotime($joinrow['shift_end'] . ' +1 day'));
                } elseif ($current_time < $shift_end) {
                    // Shift is in the future
                    $exp_in = date('Y-m-d H:i:s', strtotime($joinrow['shift_start'] . ' -1 day'));
                    $exp_out = date('Y-m-d H:i:s', $shift_end);
                }
            } else {
                $exp_in = date('Y-m-d H:i:s', $shift_start);
                $exp_out = date('Y-m-d H:i:s', $shift_end);
            }

  
        // Check if the employee has already clocked in for the shift
        $check_stmt = "SELECT * FROM bergs_attendance 
            WHERE employee_id = '$employee_id' 
            AND (marked = 'Present' OR marked = 'Late' OR marked = 'Early' OR marked = 'Half Day')  
            AND (
             (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
             OR 
             (DATE(exp_time_out) = DATE(NOW()) AND exp_time_out >= NOW()) 
             OR 
             ((DATE(exp_time_in) < DATE(NOW()) OR DATE(time_in) < DATE(NOW())) AND DATE(exp_time_out) > DATE(NOW()))
            )
            ";

        $check_rst = $conn->query($check_stmt);
        if(mysqli_num_rows($check_rst) > 0){
        echo "Notification: Employee $employee_id has already clocked in for the shift.";
        } else {
       $shift_start_time = strtotime($shift_start);
        $late_start_time = strtotime("+{$late_min} minutes", $shift_start);
        $beginning_in = date('H:i:s', strtotime($joinrow['beginning_in']));
        
        if ($shift_start_time > strtotime($beginning_in)) {
            // Convert to Unix timestamps
            $shift_start_timestamp = strtotime($shift_start);
            $beginning_in_timestamp = strtotime($beginning_in);
            
            // Calculate the difference in seconds
            $difference_seconds = $current_time - $shift_start_timestamp;
            
            // Convert the difference to minutes
            $difference_minutes = $difference_seconds / 60;
            
            // Round the result to the nearest whole number
            $difference_minutes = round($difference_minutes);
        } else {
            $difference_minutes = 0;
        }
        
       $late_start_time = strtotime("+{$late_min} minutes", $shift_start);
        $late_minutes = 0;

        if ($current_time > $late_start_time ) {
            // Calculate the difference in seconds
            $difference_seconds = $current_time - $late_start_time;
        
            // Convert the difference to minutes
            $late_minutes = $difference_seconds / 60;
        
            // Round the result to the nearest whole number
            $late_minutes = round($late_minutes);
        }

            
            if ($late_minutes >= $late_min) {
                $late_min = $late_minutes;
                $early = $difference_minutes;
                $marked = 'Late';

            } else if ($late_minutes <= $late_min || $late_minute == $late_min) {
                $late_min = 0;
                $early = $difference_minutes;
                $marked = 'Early';

            }else{
                $late_min = 0;
                $early = 0;
                $marked = 'Present';
            }

        // Insert the new attendance record
        $image = $_POST['image'];
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        // Convert the base64-encoded data to binary
        $imageData = base64_decode($image);

        // Get current date and time
        $currentDateTime = date('Ymd_Hi');

        // Assuming the employee_id is stored in a variable called $employee_id
        $imageName = $employee_id . '_' . $currentDateTime . '.jpg';

        // Save the image to a file
        $file = '../uploads_time_in/' . $imageName;
        file_put_contents($file, $imageData);

        // Open the file and read the contents
        $imageData = file_get_contents($file);

        // Escape the binary data
        $imageDataEscaped = $conn->real_escape_string($imageData);  
        $sql7 = "INSERT INTO bergs_attendance (employee_id, employee_name, shift_num, date, time_in, exp_time_in, exp_time_out, late_min, early, timein_image, marked) 
                VALUES ('$employee_id', '$employee_name', '$shift_num', '$current_date', NOW(), '$exp_in', '$exp_out', $late_min, $early, '$imageDataEscaped', '$marked')";
        $result7 = mysqli_query($conn, $sql7);

            if($result7){
                $files = glob('../uploads_time_in/*'); // get all file names in the folder
                    foreach($files as $file){ // iterate files
                      if(is_file($file)) {
                        unlink($file); // delete file
                      }
                    } 
                echo "Notification: Attendance record for Employee $employee_id logged successfully on $word_currentdate.";
            } else {
                 echo ("Query failed: " . mysqli_error($conn));
              }
            }
           

} else {
    $att = "SELECT * FROM bergs_attendance WHERE employee_id = '$employee_id' 
        AND (
             (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
             OR 
             (DATE(exp_time_out) = DATE(NOW()) AND exp_time_out >= NOW()) 
             OR 
             (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
            )";
    $attres = $conn->query($att);
    if($attres->num_rows > 0){
        $row = $attres->fetch_assoc();
        $employee_id = $row['employee_name'];
        echo "Notification: Attendance record of ($employee_id) already exists within the time shift.";
    }else{
           echo "It is not your shift time yet OR The acceptance of time in during your shift is already ended. Unfortunately, you did not reach the required time."; 
    }
}



?>