<?php
session_start();
include 'dbconn.php';

if(!isset($_SESSION["loggedinasguest"]) || $_SESSION["loggedinasguest"] !== true){
    header("location: index.php");
    exit;
}
?>