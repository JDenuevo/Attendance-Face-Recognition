<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include("dbconn.php");
session_start();
date_default_timezone_set('Asia/Manila');


//==========================================================BY DEPT==========================================================

    if (isset($_POST['s_add_event']) && $_POST['select-deduction'] === "by-dept") {
      $errors1 = array();
      $errors2 = array();
  
      // Get data to insert from form submission
          $event_sub = $_POST['e_subject'];
          $event_desc = $_POST['e_description'];
          $date = $_POST['e_date'];
        $event_desc = str_replace(",", "&#44", $event_desc); 
        $event_desc = str_replace(";", "&#59", $event_desc); 
        $event_desc = str_replace("'", "&#39", $event_desc); 
        $event_desc = str_replace("+", " ", $event_desc);
        $event_desc = nl2br($event_desc); // convert line breaks to <br> tags
          $dep_name = trim($_POST['select-dept']);

    
            // Query database to get last position number
                $sql2 = "SELECT MAX(event_num) AS last_event_num FROM bergs_event";
                $result2 = $conn->query($sql2);
        
        
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $last_event_num = $row2['last_event_num'];
                  } else {
                    $last_event_num = 0;
                  }
        
                // Increment last position number to generate new position number
                $new_event_num = $last_event_num + 1;
                
                // Query to insert the eventuction into the second database
                $sql = "INSERT INTO bergs_event (event_num, event_date, event_subject, event_to, event_description) VALUES ('$new_event_num', '$date', '$event_sub', '$dep_name', '$event_desc')";
    
                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    $success = 'okay';
                } else {
                  $success = 'no';
                }
            

            if($success == 'okay'){
              $errors1[] = "Event added to all Employees in " . $dep_name;
              $errorString1 = implode(',', $errors1);
              header('Location: s_event?errors1=' . urlencode($errorString1));
              exit();
            }else if($success == 'no') {
              $errors2[] = "Something went wrong!";
              $errorString1 = implode(',', $errors2);
              header('Location: s_event?errors2=' . urlencode($errorString1));
              exit();
            }

    }
    //==========================================================END BY DEPT==========================================================

    //========================================================== TO ALL ==========================================================
    else if (isset($_POST['s_add_event']) && $_POST['select-deduction'] === "to-all") {
      $errors1 = array();
      $errors2 = array();
  
      // Get data to insert from form submission
          $event_to = "To All Employees";
          $event_sub = $_POST['e_subject'];
          $event_desc = $_POST['e_description'];
          $date = $_POST['e_date'];
        $event_desc = str_replace(",", "&#44", $event_desc); 
        $event_desc = str_replace(";", "&#59", $event_desc); 
        $event_desc = str_replace("'", "&#39", $event_desc); 
        $event_desc = str_replace("+", " ", $event_desc);
        $event_desc = nl2br($event_desc); // convert line breaks to <br> tags


        
    
                // Query database to get last position number
                $sql2 = "SELECT MAX(event_num) AS last_event_num FROM bergs_event";
                $result2 = $conn->query($sql2);
        
        
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $last_event_num = $row2['last_event_num'];
                  } else {
                    $last_event_num = 0;
                  }
        
                // Increment last position number to generate new position number
                $new_event_num = $last_event_num + 1;
                
                // Query to insert the eventuction into the second database
                $sql = "INSERT INTO bergs_event (event_num, event_date, event_subject, event_to, event_description) VALUES ('$new_event_num', '$date', '$event_sub', '$event_to', '$event_desc')";
    
                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    $success = 'okay';
                } else {
                  $success = 'no';
                }
            

            if($success == 'okay'){
              $errors1[] = "Event added to all Employees";
              $errorString1 = implode(',', $errors1);
              header('Location: s_event?errors1=' . urlencode($errorString1));
              exit();
            }else if($success == 'no') {
              $errors2[] = "Something went wrong!";
              $errorString1 = implode(',', $errors2);
              header('Location: s_event?errors2=' . urlencode($errorString1));
              exit();
            }

    }
    //==========================================================END TO ALL==========================================================

    ?>