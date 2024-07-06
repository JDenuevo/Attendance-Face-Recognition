<?php
session_start();
include 'dbconn.php';

if(!isset($_SESSION["loggedinasemployee"]) || $_SESSION["loggedinasemployee"] !== true){
    header("location: index.php");
    exit;
}
?>
