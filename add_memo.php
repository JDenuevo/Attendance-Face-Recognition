<?php
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include("dbconn.php");
session_start();
date_default_timezone_set('Asia/Manila');
$adminid = $_SESSION['id'];

$sqladmin = "SELECT * FROM bergs_login WHERE id = '$adminid'";
$resadmin = $conn->query($sqladmin);
while($rowadmin=$resadmin->fetch_assoc()){
    $fullname = $rowadmin['full_name'];

if (isset($_POST['add_memo']) && $_POST['select-deduction'] === "indiv") {
    $errors1 = array();
    $errors2 = array();

    // Get data to insert from form submission
        $memo_sub = $_POST['m_subject'];
        $memo_desc = $_POST['m_description'];
        $memo_desc = str_replace(",", "&#44", $memo_desc); 
        $memo_desc = str_replace(";", "&#59", $memo_desc); 
        $memo_desc = str_replace("'", "&#39", $memo_desc); 
        $memo_desc = str_replace("+", " ", $memo_desc);
        $memo_desc = nl2br($memo_desc); // convert line breaks to <br> tags

        $employee_id = trim($_POST['employee_id']);
        $current_date = date('Y-m-d');

        $sql = "SELECT * FROM bergs_registration WHERE id = '$employee_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Loop through the results and add memouctions for each employee
          $row = $result->fetch_assoc();
              // Get the employee ID
              $employee_id = $row['id'];
        


        // Query database to get last position number
        $sql = "SELECT MAX(memo_num) AS last_memo_num FROM bergs_memo";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_memo_num = $row['last_memo_num'];
          } else {
            $last_memo_num = 0;
          }

        // Increment last position number to generate new position number
        $new_memo_num = $last_memo_num + 1;

        // Insert new position into database
            $sql = "INSERT INTO bergs_memo (memo_num, memo_subject, memo_date, memo_to, memo_from, memo_description) VALUES ('$new_memo_num','$memo_sub', '$current_date', '$employee_id', '$fullname', '$memo_desc')";

        if ($conn->query($sql) === TRUE) {
        // Notify user that the insert was successful
        $errors1[] = "Memorandum was successfully added.";


        }
        if (!empty($errors1)) {
          // Redirect back to the login page with the error messages
          $errorString1 = implode(',', $errors1);
          header('Location: a_memo?errors1=' . urlencode($errorString1));
          exit();
      }

        // Close database connection and redirect user
        $conn->close();

    } else {
      $errors2[] = "No employees with that Employee ID found in the database";
      $errorString1 = implode(',', $errors2);
      header('Location: a_memo?errors2=' . urlencode($errorString1));
      exit();
  }
}
//==========================================================END INDIVIDUAL==========================================================

//==========================================================BY DEPT==========================================================

    else if (isset($_POST['add_memo']) && $_POST['select-deduction'] === "by-dept") {
      $errors1 = array();
      $errors2 = array();
  
      // Get data to insert from form submission
          $memo_sub = $_POST['m_subject'];
          $memo_desc = $_POST['m_description'];
        $memo_desc = str_replace(",", "&#44", $memo_desc); 
        $memo_desc = str_replace(";", "&#59", $memo_desc); 
        $memo_desc = str_replace("'", "&#39", $memo_desc); 
        $memo_desc = str_replace("+", " ", $memo_desc);
        $memo_desc = nl2br($memo_desc); // convert line breaks to <br> tags

          $dep_name = trim($_POST['select-dept']);
          $current_date = date('Y-m-d');

    
            // Query database to get last position number
                $sql2 = "SELECT MAX(memo_num) AS last_memo_num FROM bergs_memo";
                $result2 = $conn->query($sql2);
        
        
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $last_memo_num = $row2['last_memo_num'];
                  } else {
                    $last_memo_num = 0;
                  }
        
                // Increment last position number to generate new position number
                $new_memo_num = $last_memo_num + 1;
                
                // Query to insert the memouction into the second database
                $sql = "INSERT INTO bergs_memo (memo_num, memo_subject, memo_date, memo_to, memo_from, memo_description) VALUES ('$new_memo_num','$memo_sub', '$current_date', '$dep_name', '$fullname', '$memo_desc')";
    
                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    $success = 'okay';
                } else {
                  $success = 'no';
                }
            

            if($success == 'okay'){
              $errors1[] = "Memorandum added to all Employees in " . $dep_name;
              $errorString1 = implode(',', $errors1);
              header('Location: a_memo?errors1=' . urlencode($errorString1));
              exit();
            }else if($success == 'no') {
              $errors2[] = "Something went wrong!";
              $errorString1 = implode(',', $errors2);
              header('Location: a_memo?errors2=' . urlencode($errorString1));
              exit();
            }

    }
    //==========================================================END BY DEPT==========================================================

    //========================================================== TO ALL ==========================================================
    else if (isset($_POST['add_memo']) && $_POST['select-deduction'] === "to-all") {
      $errors1 = array();
      $errors2 = array();
  
      // Get data to insert from form submission
          $memo_to = "To All Employees";
          $memo_sub = $_POST['m_subject'];
          $memo_desc = $_POST['m_description'];
        $memo_desc = str_replace(",", "&#44", $memo_desc); 
        $memo_desc = str_replace(";", "&#59", $memo_desc); 
        $memo_desc = str_replace("'", "&#39", $memo_desc); 
        $memo_desc = str_replace("+", " ", $memo_desc);
        $memo_desc = nl2br($memo_desc); // convert line breaks to <br> tags


          $current_date = date('Y-m-d');
        
    
                // Query database to get last position number
                $sql2 = "SELECT MAX(memo_num) AS last_memo_num FROM bergs_memo";
                $result2 = $conn->query($sql2);
        
        
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $last_memo_num = $row2['last_memo_num'];
                  } else {
                    $last_memo_num = 0;
                  }
        
                // Increment last position number to generate new position number
                $new_memo_num = $last_memo_num + 1;
                
                // Query to insert the memouction into the second database
                $sql = "INSERT INTO bergs_memo (memo_num, memo_subject, memo_date, memo_to, memo_from, memo_description) VALUES ('$new_memo_num','$memo_sub', '$current_date' ,'$memo_to', '$fullname', '$memo_desc')";
    
                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    $success = 'okay';
                } else {
                  $success = 'no';
                }
            

            if($success == 'okay'){
              $errors1[] = "Memorandum added to all Employees";
              $errorString1 = implode(',', $errors1);
              header('Location: a_memo?errors1=' . urlencode($errorString1));
              exit();
            }else if($success == 'no') {
              $errors2[] = "Something went wrong!";
              $errorString1 = implode(',', $errors2);
              header('Location: a_memo?errors2=' . urlencode($errorString1));
              exit();
            }

    }
    //==========================================================END TO ALL==========================================================
}
    ?>