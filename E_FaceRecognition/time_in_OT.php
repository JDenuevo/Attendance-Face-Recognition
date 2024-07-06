<?php
session_start();
include('../dbconn.php');
date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_Date = strtotime(date('Y-m-d H:i:s'));
    $employee_id = $_SESSION['id']; // replace with actual employee id
    $errors = array();

    $checking = "SELECT * FROM bergs_attendance WHERE employee_id = '$employee_id' AND (
        (DATE(exp_time_in) = DATE(NOW()) AND exp_time_in <= NOW()) 
        OR 
        (DATE(exp_time_out) = DATE(NOW()) AND ADDTIME(exp_time_out, '10:00:00') >= NOW()) 
        OR 
        (DATE(exp_time_in) < DATE(NOW()) AND DATE(exp_time_out) > DATE(NOW()))
       )";
    if ($chkrst = $conn->query($checking)) {
        $row = $chkrst->fetch_assoc();
        if ($row['exp_time_out'] >= $current_Date) {
                    $sql = "UPDATE bergs_attendance SET time_out = exp_time_out, time_in_OT = exp_time_out,
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
                            WHERE employee_id = '$employee_id' ORDER BY date DESC LIMIT 1";
                        if ($rst = $conn->query($sql) === TRUE) {
                            $errors[] = 'Time In OT Success';
                            $errorString = implode(',', $errors);
                            header('Location: ./e_facerecog.php?errors=' . urlencode($errorString));
                            exit();
                        } else {
                            echo 'Error: ' . $conn->error;
                        }
            
        } elseif ($row['exp_time_out'] < $current_Date) {
                 $sql = "UPDATE bergs_attendance SET time_out = exp_time_out, time_in_OT = NOW(),
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
                             WHERE employee_id = '$employee_id' ORDER BY date DESC LIMIT 1";
                        if ($rst = $conn->query($sql) === TRUE) {
                            $errors[] = 'Time In OT Success';
                            $errorString = implode(',', $errors);
                            header('Location: ./e_facerecog.php?errors=' . urlencode($errorString));
                            exit();
                        } else {
                            echo 'Error: ' . $conn->error;
                        }
                
           
        }
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>
