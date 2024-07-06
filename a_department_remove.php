<?php
include 'dbconn.php';

$dep_num_to_delete = $_GET['dep_num'];
$errors3 = array();


// Delete the row from the database
$sql_delete = "DELETE FROM bergs_department WHERE dep_num = '$dep_num_to_delete'";
$conn->query($sql_delete);

// Retrieve the remaining rows, ordering them by their original order
$sql_select = "SELECT dep_num, dep_name FROM bergs_department ORDER BY dep_id ASC";
$result = $conn->query($sql_select);

if (!$result) {
    echo "Error: " . $sql_select . "<br>" . $conn->error;
}

// Update the pos_num column with consecutive numbering
$i = 1;
while ($row = $result->fetch_assoc()) {
    $dep_num = $row['dep_num'];
    $sql_update = "UPDATE bergs_department SET dep_num = '$i' WHERE dep_num = '$dep_num'";
    $conn->query($sql_update);
    $i++;
}

// Notify user that the delete was successful
$errors3[] = "Department was successfully removed.";

if (!empty($errors3)) {
    // Redirect back to the login page with the error messages
    $errorString3 = implode(',', $errors3);
    header('Location: a_department?errors3=' . urlencode($errorString3));
    exit();
}

  // Close database connection and redirect user
  $conn->close();
