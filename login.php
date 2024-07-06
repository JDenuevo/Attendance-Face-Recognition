<?php
session_start();
include 'dbconn.php';
// sanitize inputs

$emailVal = $_POST["email"];
$passwordVal = $_POST["password"];
$captcha_challenge = $_POST['captcha_challenge'];
$captcha_response = $_POST['captcha_response'];
$errors = array();


if ($captcha_challenge !== $captcha_response) {
  $errors[] = "Captcha is not answered correctly!";
}

$cookie_time = 60 * 60 * 24 * 30; // 30 days
if (isset($_POST['remember'])) {
    $escapedRemember = mysqli_real_escape_string($conn, $_POST['remember']);
    $cookie_time_Onset = time() + $cookie_time; // Calculate the expiration time

    if (isset($escapedRemember)) {
        /*
         * Set Cookie from here for one month
         * Hash the email and password using md5() before setting the cookie
         * */
        setcookie("fnbkn", md5($emailVal), $cookie_time_Onset, '/'); // Set cookie with correct expiration time
        setcookie("qbtuyqug", md5($passwordVal), $cookie_time_Onset, '/'); // Set cookie with correct expiration time

        $_SESSION['fnbkn'] = $emailVal;
        $_SESSION['qbtuyqug'] = $passwordVal;
    }
} else {
    $cookie_time_fromOffset = time() - $cookie_time; // Calculate the expiration time
    setcookie("fnbkn", '', $cookie_time_fromOffset, '/'); // Unset cookie with correct expiration time
    setcookie("qbtuyqug", '', $cookie_time_fromOffset, '/'); // Unset cookie with correct expiration time

    $_SESSION['fnbkn'] = '';
    $_SESSION['qbtuyqug'] = '';
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
    
    $uname = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        $errors[] = "Email is required!";
    }

    if (empty($pass)) {
        $errors[] = "Password is required!";
    }

    if (empty($pass) OR empty($uname)) {
        $errors[] = "Please fill the empty fields!";
    }

    if (!empty($errors)) {
        // Redirect back to the login page with the error messages
        $errorString = implode(',', $errors);
        header('Location: login_form?errors=' . urlencode($errorString));
        exit();
    }

    // hashing the password
    $pass = md5($pass);

    $sql = "SELECT * FROM bergs_login WHERE email='$uname' AND status = 'Active'";
    if ($rs = $conn->query($sql)) {
        if ($rs->num_rows > 0) {
            $row = $rs->fetch_assoc();
            $user_name = $row['email'];
            $name = $row['full_name'];
            $id = $row['id'];
            $position = $row['position'];

            // authenticate the user
            if ($row['password'] === $pass && $row['position'] === $position) {
                $_SESSION['user_name'] = $row['email'];
                $_SESSION['name'] = $row['full_name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['position'] = $row['position'];

                if ($row['position'] === "Administrator") {
                    $_SESSION["loggedinasadmin"] = true;
                    header("Location: a_dashboard");
                    exit();

                } else if ($row['position'] === "HR Staff") {
                    $_SESSION["loggedinasstaff"] = true;
                    header("Location: s_dashboard");
                    exit();
                } else if ($row['position'] === "Employee") {
                    $_SESSION["loggedinasemployee"] = true;
                    header("Location: e_dashboard");
                    exit();
                } else if ($row['position'] === "Guest") {
                    $_SESSION["loggedinasguest"] = true;
                    header("Location: g_dashboard");
                    exit();
                } else {
                    $errors[] = "Invalid Usertype! Please contact the help desk.";
                }
                } else {
                $errors[] = "Incorrect Password!";
                }
                } else {
                $errors[] = "Email not found. Please try again!";
                }
                } else {
                $errors[] = "Something went wrong. Please try again later.";
                }

        // check for errors
if (!empty($errors)) {
    // Redirect back to the login page with the error messages
    $errorString = implode(',', $errors);
    header('Location: login_form?errors=' . urlencode($errorString));
    exit();
}
} else {
// if the email or password is not set, redirect back to the login page
header('Location: login_form');
exit();
}

?>
