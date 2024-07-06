<?php
session_start();

if (!isset($_SESSION["loggedinasemployee"]) && !isset($_SESSION["loggedinasguest"]) && !isset($_SESSION["loggedinasstaff"]) && !isset($_SESSION["loggedinasadmin"])) {
    header("location: ../index");
    $_SESSION['employee_id'] = $_SESSION['id'];
    date_default_timezone_set('Asia/Manila');
    exit;
}
?>
