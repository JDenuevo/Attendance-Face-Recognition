<?php
include("dbconn.php");
session_start();

$remove_account = $_GET['id'];
$status = "Inactive";

// Update the status column of the row identified by $remove_account
$sql_update = "UPDATE bergs_login SET status = '$status' WHERE id = '$remove_account'";
$result = $conn->query($sql_update);

if (!$result) {
    echo "Error: " . $sql_update . "<br>" . $conn->error;
}else{
    
$sql_update2 = "UPDATE bergs_registration SET status = '$status' WHERE id = '$remove_account'";
$result2 = $conn->query($sql_update2);

if(!$result2){
    $errors3[] = "Account status was successfully updated.";
    header('Location: a_account');
    exit();
}else{
    
// Notify user that the update was successful
$errors3[] = "Account status was successfully updated.";
    header('Location: a_account');
    exit();
if (!empty($errors3)) {
    // Redirect back to the login page with the error messages
    $errorString3 = implode(',', $errors3);
    header('Location: a_account?errors3=' . urlencode($errorString3));
    exit();
}
}
}

// Close database connection and redirect user
$conn->close();
?>