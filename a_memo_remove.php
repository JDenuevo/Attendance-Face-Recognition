<?php
include 'dbconn.php';
session_start();
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$memo_num_to_delete = $_POST['memo_num'];
$errors3 = array();


// Delete the row from the database
$sql_delete = "DELETE FROM bergs_memo WHERE memo_num = '$memo_num_to_delete'";
$conn->query($sql_delete);

// Retrieve the remaining rows, ordering them by their original order
$sql_select = "SELECT memo_num FROM bergs_memo ORDER BY memo_num ASC";
$result = $conn->query($sql_select);

if ($result) {
  // Return a success response
  echo json_encode(array('status' => 'success'));
} else {
  // Return an error response
  echo json_encode(array('status' => 'error', 'message' => $conn->error));
}
// Update the memo_num column with consecutive numbering
$i = 1;
while ($row = $result->fetch_assoc()) {
    $memo_num = $row['memo_num'];
    $sql_update = "UPDATE bergs_memo SET memo_num = '$i' WHERE memo_num = '$memo_num'";
    $conn->query($sql_update);
    $i++;
}


  // Close database connection and redirect user
  $conn->close();

?>
