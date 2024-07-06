<?php
include 'dbconn.php';
session_start();

$shift_num_to_delete = $_GET['shift_num'];

// Delete the row from the database
$sql_delete = "DELETE FROM bergs_shift WHERE shift_num = '$shift_num_to_delete'";
$conn->query($sql_delete);

// Notify user that the delete was successful
session_start();
$_SESSION['message'] = "Time Shift was successfully deleted!";

// Close database connection and redirect user
$conn->close();
header("location: a_shift");
exit;
?>
