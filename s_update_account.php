<?php
session_start();
include('dbconn.php');

$id = trim($_POST['id']);
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$errors2 = array();

// Check if the account exists
$sql = "SELECT * FROM bergs_login WHERE id = '$id' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 1) { // Check if query is successful

    // Check if the password input is empty
    if (empty($password)) {
        // If password input is empty, do not update password field in MySQL
        $sql2 = "UPDATE bergs_login SET id='$id', email='$email', full_name='$full_name' WHERE id='$id'";
    } else {
        // Convert the password to md5 hash value
        $password = md5($password);
        // Update data in MySQL including password field
        $sql2 = "UPDATE bergs_login SET id='$id', email='$email', password='$password', full_name='$full_name' WHERE id='$id'";
    }

    if ($conn->query($sql2) === TRUE) {
        // Notify user that the update was successful
        $errors2[] = "Account was successfully updated.";

    }
    if (!empty($errors2)) {
        // Redirect back to the login page with the error messages
        $errorString2 = implode(',', $errors2);
        header('Location: s_account?errors2=' . urlencode($errorString2));
        exit();

    }

}

// Close database connection and redirect user
$conn->close();
?>
