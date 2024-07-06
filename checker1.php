<?php
    include ('dbconn.php');
    // Get the current date and time
    date_default_timezone_set('Asia/Manila');
    // Get current time
        $current_date = date('Y-m-d');
        $cdr = date('Y-m-d', strtotime($current_date));
        $current_datetime = strtotime(date('Y-m-d H:i:s'));
        $time_format = date('H:i:s');
        $day_name = date('l');
   $sql = "SELECT DISTINCT employee_id, marked FROM bergs_attendance 
        WHERE time_out IS NULL 
        AND NOW() >= DATE_ADD(exp_time_out, INTERVAL 30 MINUTE) 
        AND (marked = 'Present' OR marked = 'Late')";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $employee_id = $row["employee_id"];
                $sql_update = "UPDATE bergs_attendance 
                        SET time_out = exp_time_out,
                            hours_of_work = ROUND(
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        CAST(exp_time_out AS TIME), 
                                        CASE 
                                            WHEN TIMEDIFF(
                                                CAST(time_in AS TIME),
                                                CONCAT(
                                                    DATE_FORMAT(CAST(time_in AS DATETIME), '%H:'),
                                                    FLOOR(DATE_FORMAT(CAST(time_in AS DATETIME), '%i') / 10) * 10,
                                                    ':00'
                                                )
                                            ) <= DATE_ADD(exp_time_in, INTERVAL 10 MINUTE) 
                                            THEN CAST(DATE_FORMAT(CAST(time_in AS DATETIME), '%Y-%m-%d %H:%i:00') AS TIME)
                                            ELSE CAST(time_in AS TIME)
                                        END
                                    )
                                ) / 3600
                            )
                        WHERE employee_id = '$employee_id' AND time_out IS NULL";


                        if ($conn->query($sql_update) === TRUE) {
                            echo "bergs_attendance table updated successfully for employee $employee_id";
                        } else {
                            echo "Error updating bergs_attendance table for employee $employee_id: " . $conn->error;
                        }
        }
}else{
        $current_date = date('Y-m-d');
        $cdr = date('Y-m-d', strtotime($current_date));
        $current_datetime = strtotime(date('Y-m-d H:i:s'));
        $time_format = date('H:i:s');
        $current_time = strtotime(date('H:i:s'));
        
        $sql1 = "SELECT 
                r.id,
                s.shift_start, 
                s.shift_end, 
                s.shift_num,
                s.start_date,
                s.end_date,
                s.rest_days,
                r.fname, 
                r.lname, 
                r.mname 
            FROM 
                bergs_shift s 
            JOIN 
                bergs_registration r ON s.shift_num = r.shift_num 
            LEFT JOIN 
                bergs_attendance t ON t.employee_id = r.id AND t.shift_num = s.shift_num AND DATE(t.date) = '$current_date'
            WHERE 
                s.rest_days NOT LIKE CONCAT('%', '$day_name', '%')
                AND ('$cdr' >= s.start_date AND '$cdr' <= s.end_date)
                AND s.shift_num = r.shift_num
                AND s.start_date <= '$current_date'
                AND s.end_date >= '$current_date'
                AND s.shift_end <= '$current_datetime'
                AND t.employee_id IS NULL ";
    
    
    $result1 = $conn->query($sql1);
    
    if($result1->num_rows > 0){
        while($row = mysqli_fetch_assoc($result1)){
            $employee_id = $row['id'];
            $exp_ins = date('g:i A',strtotime($row['shift_start']));
            $exp_outs = date('g:i A', strtotime($row['shift_end']));
            $cd = date('F j, Y', strtotime($current_date));
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
                }else{
                     $exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start'] . ' -1 day'));
                    $exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
                }
            }else{
                    // Shift starts and ends on the same day
                if ($current_time >= $shift_start && $current_time <= $shift_end) {
                        // Shift is currently ongoing
                    $exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
                    $exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
                } elseif ($current_time < $shift_start) {
                        // Shift is in the future (later today or tomorrow)
                    $exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
                    $exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
                }else{
                    $exp_in = date('Y-m-d H:i:s', strtotime($row['shift_start']));
                    $exp_out = date('Y-m-d H:i:s', strtotime($row['shift_end']));
                }
            }
    
            
              $shift_num = $row['shift_num'];
              

             $marked = 'Absent';

            if($current_time > $shift_end){
                 $sql7 = "INSERT INTO bergs_attendance (employee_id, employee_name, shift_num, date, exp_time_in, exp_time_out, marked) 
                    VALUES ('$employee_id', '$employee_name', '$shift_num', '$current_date', '$exp_in', '$exp_out', '$marked')";
            $result7 = mysqli_query($conn, $sql7);
            }else{
                return;
            }
             
            
        }
    
    }else{
        echo "No Record Found!";
    }
    
}
    
    
    
    
    // Close database connection
    $conn->close();
  
  


?>

