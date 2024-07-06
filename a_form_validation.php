<?php

session_start();
include 'dbconn.php';

if(!isset($_SESSION["loggedinasadmin"]) || $_SESSION["loggedinasadmin"] !== true){
    header("location: index.php");
    exit;
}
?>
