<?php
session_start();
include 'dbconn.php';

if (isset($_SESSION['id'])) {
  $employee_id = $_SESSION['id'];
  $current_date = date('Y-m-d');
  $time_now = date('H:i:s');
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


    
    $sql = "SELECT * FROM bergs_attendance WHERE employee_id = '$employee_id' AND (
      (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
      OR 
      (DATE(exp_time_out) = DATE(NOW()) AND ADDTIME(exp_time_out, '10:00:00') >= NOW()) 
      OR 
      (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
     )";

    $result = $conn->query($sql);
    $attendance_records = array();
    while ($row = $result->fetch_assoc()) {
        $_SESSION['exp_time_out'] = $row['exp_time_out'];
      $filename = $row['timein_image'];
      // Get base64-encoded string of the saved image
      $image_data_base64 = base64_encode($filename);

      if($row['time_in_OT'] != null){
                     
        $time3 = strtotime($row['time_in_OT']); // convert the time string to a Unix timestamp
        $time_in_OT = date('F d Y, g:iA', $time3);

        }else{
          $time_in_OT = $row['time_in_OT'];
        }
      
        if($row['time_out_OT'] != null){
         
          $time4 = strtotime($row['time_out_OT']); // convert the time string to a Unix timestamp
          $time_out_OT = date('F d Y, g:iA', $time4);

          }else{
            $time_out_OT = $row['time_out_OT'];
          }

      if($row['time_out_OT'] != null){
      
        $time2 = strtotime($row['time_out']); // convert the time string to a Unix timestamp
        $time_out = date('F d Y, g:iA', $time2);

        }else{
          $time_out = $row['time_out'];
        }

        if($row['time_out_OT'] != null){
      
          $time1 = strtotime($row['time_in']); // convert the time string to a Unix timestamp
          $time_in = date('F d Y, g:iA', $time1);

          }else{
            $time_in = $row['time_in'];
          }
      
      // Store the attendance record data in an array
      $attendance_record = array(
          'employee_id' => $row['employee_id'],
          'employee_name' => $employee_name,
          'time_in' => $time_in,
          'time_out' => $time_out,
          'time_in_OT' => $time_in_OT,
          'time_out_OT' => $time_out_OT,
          'image_data_base64' => $image_data_base64,
      );
      array_push($attendance_records, $attendance_record);
    }

    // If there are no attendance records, create a single empty record
    if (count($attendance_records) === 0) {
      $empty_record = array(
          'employee_id' => '',
          'employee_name' => '',
          'time_in' => '',
          'time_out' => '',
          'time_in_OT' => '',
          'time_out_OT' => '',
          'image_data_base64' => '',
      );
      array_push($attendance_records, $empty_record);
    }

    // Check if user is already timed out
    $timed_out = false;
    foreach ($attendance_records as $record) {
      if ($record['time_out'] === null) {
        $timed_out = true;
        break;
      }
    }

        // Encode the attendance records array as JSON and echo it
        $attendance_records_json = json_encode($attendance_records);
        echo $attendance_records_json;

    } else{
        echo "ebarag par";
    }
}
?>
