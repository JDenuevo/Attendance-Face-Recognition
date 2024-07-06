<?php
include 'dbconn.php';
session_start();

if (isset($_POST['change_password'])) {
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $check_pass = "SELECT * FROM bergs_login WHERE email = '$email' AND password = '$password'";
    $check_pass_result = mysqli_query($conn, $check_pass);
    $errors = array();


    
    if ($new_password == $confirm_password) {
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        $update_password = "UPDATE bergs_login SET password = '$new_password' WHERE email = '$email'";
        mysqli_query($conn, $update_password);
        
        $update_password2 = "UPDATE bergs_registration SET password = '$new_password' WHERE email = '$email'";
        mysqli_query($conn, $update_password2);
        
        // echo "Password changed successfully.";
        $errors[] = "Password has been changed!";
    }  else {
        echo "<script>alert('Your new password does not match!'); window.location.href = 'g_account.php';</script>";
    }if (!empty($errors)) {
        // Redirect back to the login page with the error messages
        $errorString = implode(',', $errors);
        header('Location: g_account.php?errors=' . urlencode($errorString));
        exit();

    }

}

// Close database connection and redirect user
$conn->close();
?>
