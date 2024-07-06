<?php
include ('dbconn.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$output = '';
date_default_timezone_set('Asia/Manila');

if(isset($_POST['btn_today'])){

$date = date('Y-m-d'); // convert date to MySQL date format
$date_name = date('F-j-Y', strtotime($date));

$sql = "SELECT * FROM `bergs_attendance` WHERE `date` = '$date' ORDER BY date ASC";
$result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours of Work</th>
                        <th>Time In Overtime</th>
                        <th>Time Out Overtime</th>
                        <th>Hours of Overtime</th>
                        <th>Late in Minutes</th>
                        <th>Marked</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                $time_in = $row['time_in'];
                $time_out = $row['time_out'];
                $hours_worked = $row['hours_of_work'];
                $time_in_ot = $row['time_in_OT'];
                $time_out_ot = $row['time_out_OT'];
                $hours_ot = $row['hours_of_overtime'];
                $late = $row['late_min'];
                $marked_as = $row['marked'];
                
                // Time In
                if (!empty($time_in)) {
                    $time_in = date('g:i A', strtotime($row['time_in']));
                } else {
                    $time_in = "--";
                }
                
                // Time Out
                if (!empty($time_out)) {
                    $time_out = date('g:i A', strtotime($row['time_out']));
                } else {
                    $time_out = "--";
                }
                if (!empty($time_in_ot)) {
                    $time_in_ot = date('g:i A', strtotime($row['time_in_OT']));
                } else {
                    $time_in_ot = "--";
                }
                
                // Time Out
                if (!empty($time_out_ot)) {
                    $time_out_ot = date('g:i A', strtotime($row['time_out_OT']));
                } else {
                    $time_out_ot = "--";
                }
                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$time_in.'</td>
                        <td>'.$time_out.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$time_in_ot.'</td>
                        <td>'.$time_out_ot.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$late.'</td>
                        <td>'.$marked_as.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=attendance_today_".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO ATTENDANCE TO BE IMPORT TODAY";
    }
}elseif(isset($_POST['btn_slc_date'])){
    $inputted = $_POST['date'];
    $date = date('Y-m-d', strtotime($inputted)); // convert date to MySQL date format
    $date_name = date('F-j-Y', strtotime($date));
    
    $sql = "SELECT * FROM `bergs_attendance` WHERE `date` = '$date' ORDER BY date ASC";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours of Work</th>
                        <th>Time In Overtime</th>
                        <th>Time Out Overtime</th>
                        <th>Hours of Overtime</th>
                        <th>Late in Minutes</th>
                        <th>Marked</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                $time_in = $row['time_in'];
                $time_out = $row['time_out'];
                $hours_worked = $row['hours_of_work'];
                $time_in_ot = $row['time_in_OT'];
                $time_out_ot = $row['time_out_OT'];
                $hours_ot = $row['hours_of_overtime'];
                $late = $row['late_min'];
                $marked_as = $row['marked'];
                
                // Time In
                if (!empty($time_in)) {
                    $time_in = date('g:i A', strtotime($row['time_in']));
                } else {
                    $time_in = "--";
                }
                
                // Time Out
                if (!empty($time_out)) {
                    $time_out = date('g:i A', strtotime($row['time_out']));
                } else {
                    $time_out = "--";
                }
                if (!empty($time_in_ot)) {
                    $time_in_ot = date('g:i A', strtotime($row['time_in_OT']));
                } else {
                    $time_in_ot = "--";
                }
                
                // Time Out
                if (!empty($time_out_ot)) {
                    $time_out_ot = date('g:i A', strtotime($row['time_out_OT']));
                } else {
                    $time_out_ot = "--";
                }
                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$time_in.'</td>
                        <td>'.$time_out.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$time_in_ot.'</td>
                        <td>'.$time_out_ot.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$late.'</td>
                        <td>'.$marked_as.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=attendance_summary_".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO ATTENDANCE TO BE IN THE DAY $date_name";
    }
}elseif(isset($_POST['btn_slc_monthyear'])){
    $inputted = $_POST['monthyear'];
    $date = date('Y-m', strtotime($inputted)); // convert date to MySQL date format
    $date_name = date('F-Y', strtotime($date));
    
    $sql = "SELECT * FROM `bergs_attendance` WHERE DATE_FORMAT(`date`, '%Y-%m') = '$date' ORDER BY date ASC";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours of Work</th>
                        <th>Time In Overtime</th>
                        <th>Time Out Overtime</th>
                        <th>Hours of Overtime</th>
                        <th>Late in Minutes</th>
                        <th>Marked</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                $time_in = $row['time_in'];
                $time_out = $row['time_out'];
                $hours_worked = $row['hours_of_work'];
                $date1 = date('F j, Y', strtotime($row['date']));
                $time_in_ot = $row['time_in_OT'];
                $time_out_ot = $row['time_out_OT'];
                $hours_ot = $row['hours_of_overtime'];
                $late = $row['late_min'];
                $marked_as = $row['marked'];
                
                // Time In
                if (!empty($time_in)) {
                    $time_in = date('g:i A', strtotime($row['time_in']));
                } else {
                    $time_in = "--";
                }
                
                // Time Out
                if (!empty($time_out)) {
                    $time_out = date('g:i A', strtotime($row['time_out']));
                } else {
                    $time_out = "--";
                }
                if (!empty($time_in_ot)) {
                    $time_in_ot = date('g:i A', strtotime($row['time_in_OT']));
                } else {
                    $time_in_ot = "--";
                }
                
                // Time Out
                if (!empty($time_out_ot)) {
                    $time_out_ot = date('g:i A', strtotime($row['time_out_OT']));
                } else {
                    $time_out_ot = "--";
                }
                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$date1.'</td>
                        <td>'.$time_in.'</td>
                        <td>'.$time_out.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$time_in_ot.'</td>
                        <td>'.$time_out_ot.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$late.'</td>
                        <td>'.$marked_as.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=attendance_summary_".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO ATTENDANCE TO BE IMPORT IN THE MONTH OF $date_name";
    }
}elseif(isset($_POST['btn_payroll_today'])){
    
    $date = date('Y-m-d'); // convert date to MySQL date format
    $date_name = date('F-j-Y', strtotime($date));
    $sql = "SELECT * FROM `bergs_attendance` WHERE date = '$date' ORDER BY date ASC";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Hours of Work</th>
                        <th>Hours of Overtime</th>
                        <th>Total Hours of Late</th>
                        <th>Total Hours of Work</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                 $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                
                if($row['hours_of_work'] !== NULL){
                    if($row['hours_of_work'] == 1){
                        $hours_worked = $row['hours_of_work'] . " hour";
                    }elseif($row['hours_of_work'] > 1){
                        $hours_worked = $row['hours_of_work'] . " hours";
                    }else{
                        $hours_worked = "  ----  ";
                    }
                }else{
                    $hours_worked = "  ----  ";
                }
               
                  if($row['hours_of_overtime'] !== NULL){
                    if($row['hours_of_overtime'] == 1){
                        $hours_ot = $row['hours_of_overtime'] . " hour";
                    }elseif($row['hours_of_overtime'] > 1){
                        $hours_ot = $row['hours_of_overtime'] . " hours";
                    }else{
                         $hours_ot = "  ----  ";
                    }
                }else{
                    $hours_ot = "  ----  ";
                }
                
                $minutes_worked = $row['hours_of_work'] * 60;
                $minutes_ot = $row['hours_of_overtime'] * 60;
                
                $late = $row['late_min'];
                
                // Calculate the total late minutes and format the display
                $hours_late = floor($late / 60);
                $minutes_late = $late % 60;
                $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
                if ($minutes_late > 0) {
                  $total_late .= " & " . $minutes_late . " minutes";
                }
                
                // Calculate the total minutes worked and format the display
                $total_minutes_worked = ($minutes_worked + $minutes_ot) - $late;
                $hrsworked = floor($total_minutes_worked / 60);
                $minutesworked = $total_minutes_worked % 60;
                $total_hours_worked = ($hrsworked > 0 ? $hrsworked . " " . ($hrsworked == 1 ? "hour" : "hours") : "--");
                if ($minutesworked > 0) {
                  $total_hours_worked .= " & " . $minutesworked . " minutes";
                }


                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$total_late.'</td>
                        <td>'.$total_hours_worked.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=payroll_summary_".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO PAYROLL SUMMARY TO BE IMPORT IN THE DATE OF $date_name";
    }
}elseif(isset($_POST['btn_15days'])){
    
    // get the first day of the current month
        $current_month = date('m');
        $current_year = date('Y');
        $first_day = date('Y-m-d', strtotime($current_year.'-'.$current_month.'-01'));
        $date_name=date('F-Y');
        // get the start and end dates for the first half of the month (1-15)
        $start_date = date('Y-m-d', strtotime($first_day));
        $end_date = date('Y-m-d', strtotime($current_year.'-'.$current_month.'-15'));
        
    $sql = "SELECT employee_id, employee_name, 
        SUM(hours_of_work) AS total_hours_worked, 
        SUM(hours_of_overtime) AS total_hours_overtime, 
        SUM(late_min) AS total_late 
        FROM `bergs_attendance` 
        WHERE date BETWEEN '$start_date' AND '$end_date' 
        GROUP BY employee_id, employee_name
        ORDER BY employee_id ASC";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Hours of Work</th>
                        <th>Hours of Overtime</th>
                        <th>Total Hours of Late</th>
                        <th>Total Hours of Work</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                 $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                $date = date('d', strtotime($row['date']));
                if($row['total_hours_worked'] !== NULL){
                    if($row['total_hours_worked'] == 1){
                        $hours_worked = $row['total_hours_worked'] . " hour";
                    }elseif($row['total_hours_worked'] > 1){
                        $hours_worked = $row['total_hours_worked'] . " hours";
                    }else{
                        $hours_worked = "  ----  ";
                    }
                }else{
                    $hours_worked = "  ----  ";
                }
               
                  if($row['total_hours_overtime'] !== NULL){
                    if($row['total_hours_overtime'] == 1){
                        $hours_ot = $row['total_hours_overtime'] . " hour";
                    }elseif($row['total_hours_overtime'] > 1){
                        $hours_ot = $row['total_hours_overtime'] . " hours";
                    }else{
                         $hours_ot = "  ----  ";
                    }
                }else{
                    $hours_ot = "  ----  ";
                }
                
                $minutes_worked = $row['total_hours_worked'] * 60;
                $minutes_ot = $row['total_hours_overtime'] * 60;
                
                $late = $row['total_late'];
                
                // Calculate the total late minutes and format the display
                $hours_late = floor($late / 60);
                $minutes_late = $late % 60;
                $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
                if ($minutes_late > 0) {
                  $total_late .= " & " . $minutes_late . " minutes";
                }
                
                // Calculate the total minutes worked and format the display
                $total_minutes_worked = ($minutes_worked + $minutes_ot) - $late;
                $hrsworked = floor($total_minutes_worked / 60);
                $minutesworked = $total_minutes_worked % 60;
                $total_hours_worked = ($hrsworked > 0 ? $hrsworked . " " . ($hrsworked == 1 ? "hour" : "hours") : "--");
                if ($minutesworked > 0) {
                  $total_hours_worked .= " & " . $minutesworked . " minutes";
                }


                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$total_late.'</td>
                        <td>'.$total_hours_worked.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=payroll_summary_1-15days-of-".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO PAYROLL SUMMARY TO BE IMPORT IN THE DAY 1-15 OF $date_name";
    }
}elseif(isset($_POST['btn_30days'])){
    
       $current_month = date('m');
        $current_year = date('Y');
        $last_day = date('t', strtotime($current_year.'-'.$current_month.'-01'));
        $last_day_date = $current_month.' '.$last_day.' '.$current_year;
        
        // get the start and end dates for the second half of the month (16 to end of month)
        $start_date =$current_year.'-'.$current_month.'-16';
        $end_date = $current_year.'-'.$current_month.'-'.$last_day;
        $date_range = date('F j, Y', strtotime($start_date)) . ' - ' . date('F j, Y', strtotime($end_date));
        $date_name=date('F-Y');
     
        
    $sql = "SELECT employee_id, employee_name, 
        SUM(hours_of_work) AS total_hours_worked, 
        SUM(hours_of_overtime) AS total_hours_overtime, 
        SUM(late_min) AS total_late 
        FROM `bergs_attendance` 
        WHERE date BETWEEN '$start_date' AND '$end_date' 
        GROUP BY employee_id, employee_name
        ORDER BY employee_id ASC";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0 ){
    
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Hours of Work</th>
                        <th>Hours of Overtime</th>
                        <th>Total Hours of Late</th>
                        <th>Total Hours of Work</th>
                    </tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                 $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
                $date = date('d', strtotime($row['date']));
                if($row['total_hours_worked'] !== NULL){
                    if($row['total_hours_worked'] == 1){
                        $hours_worked = $row['total_hours_worked'] . " hour";
                    }elseif($row['total_hours_worked'] > 1){
                        $hours_worked = $row['total_hours_worked'] . " hours";
                    }else{
                        $hours_worked = "  ----  ";
                    }
                }else{
                    $hours_worked = "  ----  ";
                }
               
                  if($row['total_hours_overtime'] !== NULL){
                    if($row['total_hours_overtime'] == 1){
                        $hours_ot = $row['total_hours_overtime'] . " hour";
                    }elseif($row['total_hours_overtime'] > 1){
                        $hours_ot = $row['total_hours_overtime'] . " hours";
                    }else{
                         $hours_ot = "  ----  ";
                    }
                }else{
                    $hours_ot = "  ----  ";
                }
                
                $minutes_worked = $row['total_hours_worked'] * 60;
                $minutes_ot = $row['total_hours_overtime'] * 60;
                
                $late = $row['total_late'];
                
                // Calculate the total late minutes and format the display
                $hours_late = floor($late / 60);
                $minutes_late = $late % 60;
                $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
                if ($minutes_late > 0) {
                  $total_late .= " & " . $minutes_late . " minutes";
                }
                
                // Calculate the total minutes worked and format the display
                $total_minutes_worked = ($minutes_worked + $minutes_ot) - $late;
                $hrsworked = floor($total_minutes_worked / 60);
                $minutesworked = $total_minutes_worked % 60;
                $total_hours_worked = ($hrsworked > 0 ? $hrsworked . " " . ($hrsworked == 1 ? "hour" : "hours") : "--");
                if ($minutesworked > 0) {
                  $total_hours_worked .= " & " . $minutesworked . " minutes";
                }


                
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$total_late.'</td>
                        <td>'.$total_hours_worked.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=payroll_summary_16-28-30-31days-of-".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO PAYROLL SUMMARY TO BE IMPORT IN THE DAY 16-30/31 OF $date_name";
    }
}elseif(isset($_POST['btn_payroll_monthyear'])){
    
        $inputted = $_POST['excel_month']; // convert date to MySQL date format
        $date = date('Y-m', strtotime($inputted));
        $date_name = date('F-Y', strtotime($date));
        
        $sql = "SELECT employee_id, employee_name, 
        SUM(hours_of_work) AS total_hours_worked, 
        SUM(hours_of_overtime) AS total_hours_overtime, 
        SUM(late_min) AS total_late 
        FROM `bergs_attendance` 
        WHERE DATE_FORMAT(`date`, '%Y-%m') = '$date' 
        GROUP BY employee_id, employee_name
        ORDER BY employee_id ASC";

        $result = $conn->query($sql);
        if (!$result) {
    echo "Error executing query: " . mysqli_error($conn);
}
        if (mysqli_num_rows($result) > 0 ){
        
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Total Hours of Work</th>
                        <th>Total Hours of Overtime</th>
                        <th>Total Hours of Late</th>
                    </tr>';
        
            while ($row = mysqli_fetch_assoc($result)) {
                $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
        
                if($row['total_hours_worked'] !== NULL){
                    if($row['total_hours_worked'] == 1){
                        $hours_worked = $row['total_hours_worked'] . " hour";
                    }elseif($row['total_hours_worked'] > 1){
                        $hours_worked = $row['total_hours_worked'] . " hours";
                    }else{
                        $hours_worked = "  ----  ";
                    }
                }else{
                    $hours_worked = "  ----  ";
                }
        
                if($row['total_hours_overtime'] !== NULL){
                    if($row['total_hours_overtime'] == 1){
                        $hours_ot = $row['total_hours_overtime'] . " hour";
                    }elseif($row['total_hours_overtime'] > 1){
                        $hours_ot = $row['total_hours_overtime'] . " hours";
                    }else{
                         $hours_ot = "  ----  ";
                    }
                }else{
                    $hours_ot = "  ----  ";
                }
        
                // Calculate the total late minutes and format the display
                $hours_late = floor($row['total_late'] / 60);
                $minutes_late = $row['total_late'] % 60;
                $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
                if ($minutes_late > 0) {
                  $total_late .= " & " . $minutes_late . " minutes";
                }
        
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$total_late.'</td>
                    </tr>';
            }
        
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=payroll_summary_of_".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO PAYROLL SUMMARY TO BE IMPORT IN THE MONTH OF $date_name";
    }
}elseif(isset($_POST['btn-weekly'])){
    
        $week_num = $_POST['btn-weekly'];
        $start_date = $_POST['start-date-'.$week_num];
        $end_date = $_POST['end-date-'.$week_num];
        $start_date_format = date('Y-m-d', strtotime($start_date)); // convert date to MySQL date format
        $end_date_format = date('Y-m-d', strtotime($end_date));
        $date_name = date('F-Y');
        $date_name1 = date('F Y');
        
        $sql = "SELECT employee_id, employee_name, 
                SUM(hours_of_work) AS total_hours_worked, 
                SUM(hours_of_overtime) AS total_hours_overtime, 
                SUM(late_min) AS total_late 
                FROM `bergs_attendance` 
                WHERE `date` BETWEEN '$start_date_format' AND '$end_date_format' 
                GROUP BY employee_id, employee_name
                ORDER BY employee_id ASC";
        $result = $conn->query($sql);
        
        if (mysqli_num_rows($result) > 0 ){
        
            $output .= '<table class="table" bordered="1">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Total Hours of Work</th>
                        <th>Total Hours of Overtime</th>
                        <th>Total Hours of Late</th>
                    </tr>';
        
            while ($row = mysqli_fetch_assoc($result)) {
                $employee_id = $row['employee_id'];
                $employee_name = $row['employee_name'];
        
                if($row['total_hours_worked'] !== NULL){
                    if($row['total_hours_worked'] == 1){
                        $hours_worked = $row['total_hours_worked'] . " hour";
                    }elseif($row['total_hours_worked'] > 1){
                        $hours_worked = $row['total_hours_worked'] . " hours";
                    }else{
                        $hours_worked = "  ----  ";
                    }
                }else{
                    $hours_worked = "  ----  ";
                }
        
                if($row['total_hours_overtime'] !== NULL){
                    if($row['total_hours_overtime'] == 1){
                        $hours_ot = $row['total_hours_overtime'] . " hour";
                    }elseif($row['total_hours_overtime'] > 1){
                        $hours_ot = $row['total_hours_overtime'] . " hours";
                    }else{
                         $hours_ot = "  ----  ";
                    }
                }else{
                    $hours_ot = "  ----  ";
                }
        
                // Calculate the total late minutes and format the display
                $hours_late = floor($row['total_late'] / 60);
                $minutes_late = $row['total_late'] % 60;
                $total_late = ($hours_late > 0 ? $hours_late . " " . ($hours_late == 1 ? "hour" : "hours") : "--");
                if ($minutes_late > 0) {
                  $total_late .= " & " . $minutes_late . " minutes";
                }
        
                $output .= '<tr>
                        <td>'.$employee_id.'</td>
                        <td>'.$employee_name.'</td>
                        <td>'.$hours_worked.'</td>
                        <td>'.$hours_ot.'</td>
                        <td>'.$total_late.'</td>
                    </tr>';
            }
            
            $output .= '</table>';
            
            // Clear output buffer
            ob_clean();
            
            // Set headers for Excel file
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=payroll_summary_of_week".$week_num." of ".$date_name.".xls");
            
            // Convert special characters back to their original form
            echo $output;
    }else{
        echo "THERE ARE NO PAYROLL SUMMARY TO BE IMPORT IN WEEK $week_num of $date_name1";
    }
}else{
    echo "TRY AGAIN! THERE IS NO FUNCTION IN THIS BUTTON";
}
?>
