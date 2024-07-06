<?php
include 'dbconn.php';
session_start();
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$event_num_to_delete = $_POST['event_num'];
$errors3 = array();


// Delete the row from the database
$sql_delete = "DELETE FROM bergs_event WHERE event_num = '$event_num_to_delete'";
$conn->query($sql_delete);

// Retrieve the remaining rows, ordering them by their original order
$sql_select = "SELECT event_num FROM bergs_event ORDER BY event_num ASC";
$result = $conn->query($sql_select);

if ($result) {
  // Return a success response
  echo json_encode(array('status' => 'success'));
} else {
  // Return an error response
  echo json_encode(array('status' => 'error', 'message' => $conn->error));
}
// Update the event_num column with consecutive numbering
$i = 1;
while ($row = $result->fetch_assoc()) {
    $event_num = $row['event_num'];
    $sql_update = "UPDATE bergs_event SET event_num = '$i' WHERE event_num = '$event_num'";
    $conn->query($sql_update);
    $i++;
}

  // Close database connection and redirect user
  $conn->close();

?>