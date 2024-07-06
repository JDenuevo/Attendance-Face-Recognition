<?php
session_start();
include 'dbconn.php';

// Get data to update from form submission
$dep_id = trim($_POST['dep_id']);
$dep_name = trim($_POST['dep_name']);
$errors2 = array();

// Check if there are changes in the input
$sql = "SELECT * FROM bergs_department WHERE dep_id = $dep_id LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['dep_id'] == $dep_id && $row['dep_name'] == $dep_name) {
  // If there are no changes, don't do anything
  header("location: a_department.php");
  exit;
}

// Update data in MySQL
$sql = "UPDATE bergs_department SET dep_name='$dep_name' WHERE dep_id='$dep_id'";

if ($conn->query($sql) === TRUE) {
  // Notify user that the update was successful
  $errors2[] = "Department was successfully updated.";
} if (!empty($errors2)) {
  // Redirect back to the login page with the error messages
  $errorString2 = implode(',', $errors2);
  header('Location: a_department?errors2=' . urlencode($errorString2));
  exit();
}

// Close database connection and redirect user
$conn->close();


?>
