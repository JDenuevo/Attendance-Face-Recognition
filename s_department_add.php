<?php
include("dbconn.php");
session_start();

if (isset($_POST['add_btn'])) {
    $errors1 = array();

    // Get data to insert from form submission
        $dep_name = trim($_POST['dep_name']);

        // Query database to get last position number
        $sql = "SELECT MAX(dep_num) AS last_dep_number FROM waps_department";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_dep_number = $row['last_dep_number'];
          } else {
            $last_dep_number = 0;
          }

        // Increment last position number to generate new position number
        $new_dep_number = $last_dep_number + 1;

        // Insert new position into database
        $sql = "INSERT INTO waps_department (dep_num, dep_name) VALUES ('$new_dep_number', '$dep_name')";

        if ($conn->query($sql) === TRUE) {
        // Notify user that the insert was successful
        $errors1[] = "Department was successfully added.";

        }  if (!empty($errors1)) {
          // Redirect back to the login page with the error messages
          $errorString1 = implode(',', $errors1);
          header('Location: s_department?errors1=' . urlencode($errorString1));
          exit();
      }

        // Close database connection and redirect user
        $conn->close();

    }
    ?>
