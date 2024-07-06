<?php

session_start();
include 'dbconn.php';

if(!isset($_SESSION["loggedinasstaff"]) || $_SESSION["loggedinasstaff"] !== true){
    header("location: index.php");
    exit;
}
?>

