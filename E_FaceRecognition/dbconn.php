<?php
$servername = "localhost";
$username = "ruhslzsa_bsit3b2022";
$password = "5fwaTmrW{[EX";
$dbname = "ruhslzsa_bsit3b";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
