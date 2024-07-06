<?php
session_start();
include 'dbconn.php';

// Get data to update from form submission
$id = $_GET['id'];
$p_title = trim($_POST['p_title']);
$p_description = trim($_POST['p_description']);

// Check if there are changes in the input
$sql = "SELECT * FROM bergs_policies WHERE policy_id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['policy_name'] == $p_title && $row['policy_descriptions'] == $p_description) {
  // If there are no changes, don't do anything
  $_SESSION['message'] = "No changes made.";
  header("location: s_policies");
  exit;
}

// Update data in MySQL
$sql = "UPDATE bergs_policies SET policy_name='$p_title', policy_descriptions='$p_description' WHERE policy_id='$id'";

if ($conn->query($sql) === TRUE) {
  // Notify user that the update was successful
  $_SESSION['message'] = "Policy was successfully updated!";
  header("location: s_policies");
  exit;
} else {
  $_SESSION['error'] = "Error updating policy: " . $conn->error;
}

// Close database connection
$conn->close();
?>
