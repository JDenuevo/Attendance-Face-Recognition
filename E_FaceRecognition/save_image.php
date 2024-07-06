<?php
session_start();
include ('../dbconn.php');
date_default_timezone_set('Asia/Manila');
$employee_id = $_SESSION['id']; // replace with actual employee id


$sql2 = "SELECT * FROM bergs_attendance WHERE employee_id = '$employee_id' AND (
  (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
  OR 
  (DATE(exp_time_out) = DATE(NOW()) AND ADDTIME(exp_time_out, '10:00:00') >= NOW()) 
  OR 
  (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
)";
            if($rs2=$conn->query($sql2)){
                while ($row=$rs2->fetch_assoc()) {
                  $i++;

                  $start_time = $row['time_in'];
                  $end_time = $row['time_out'];

                  // Convert the start and end times to UNIX timestamps
                  $start_timestamp = strtotime($start_time);
                  $end_timestamp = strtotime($end_time);

                  // Calculate the difference between the start and end times in seconds
                  $HoW = $row['hours_of_work'];

                  if($row['time_out'] != null){

                    $time2 = strtotime($row['time_out']); // convert the time string to a Unix timestamp
                    $time_out = date('F d Y, g:i A', $time2);

                    }else{
                      $time_out = $row['time_out'];
                    }

                    if($row['time_in'] != null){

                      $time1 = strtotime($row['time_in']); // convert the time string to a Unix timestamp
                      $time_in = date('F d Y, g:i A', $time1);

                      }else{
                        $time_in = $row['time_in'];
                      }

            // TIME IN AND TIME OUT TOTAL HOURS OF WORK COMPUTATION
                // Convert the datetime strings to DateTime objects
                $time_in_dt = new DateTime($time_in);
                $time_out_dt = new DateTime($time_out);

                // Calculate the time difference
                $time_diff = $time_out_dt->diff($time_in_dt);

                // Get the total number of hours worked as a decimal value
                $total_hours = $time_diff->h + ($time_diff->i / 60);

                // Get the number of minutes remaining after calculating total hours
                $total_minutes = ($total_hours - floor($total_hours)) * 60;

                // Get the total number of hours worked as an integer value
                $total_hours = floor($total_hours);
// TIME IN AND TIME OUT TOTAL HOURS OF WORK END OF COMPUTATION

                  $current_Date = strtotime(date('Y-m-d H:i:s'));
                  $dataURL = $_POST['dataURL'];
                  $data = explode(',', $dataURL);
                  $imageData = base64_decode($data[1]);
                  $currentDateTime = date('Ymd_Hi');
                  $filename = '../uploads_time_out/' . $employee_id . '_' . $currentDateTime . '.jpg';
                  $errors = array();

                  // Write the image data to the file
                  if (file_put_contents($filename, $imageData)) {
                  // Open the file and read the contents
                  $awit = file_get_contents($filename, $imageData);

                  // Escape the binary data
                  $imageDataEscaped = $conn->real_escape_string($awit);  

                  $sql = "UPDATE bergs_attendance SET time_out = NOW(), hours_of_work = '$total_hours', timeout_image = '$imageDataEscaped' WHERE employee_id = '$employee_id' AND (
                    (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
                    OR 
                    (DATE(exp_time_out) = DATE(NOW()) AND ADDTIME(exp_time_out, '10:00:00') >= NOW()) 
                    OR 
                    (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
                  )";
                  if ($rst = $conn->query($sql) === TRUE) {
                  if($rst){
                    $files = glob('../uploads_time_out/*'); // get all file names in the folder
                    foreach($files as $file){ // iterate files
                      if(is_file($file)) {
                        unlink($file); // delete file
                      }
                    }
                    $errors[] = 'Time Out Success';
                    $errorString = implode(',', $errors);
                    header('Location: ./e_facerecog.php?errors=' . urlencode($errorString));
                    exit();
                  }
                  } else {
                    echo 'Error: ' . $conn->error;
                  }

                  } else {
                    echo "Failed to save image";
                  }
                }
              }
?>
