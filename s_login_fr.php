<?php
session_start();
include 'dbconn.php';


if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$username=addslashes($_POST["username"]);
	$password=md5($_POST["password"]);

	$sql = "SELECT * FROM bergs_login WHERE email = '$username'";

	$result=mysqli_query($conn,$sql);

	$row=mysqli_fetch_array($result);

	if (mysqli_num_rows($result) == 0) {
    echo '<script>alert("Incorrect Username or Password!")</script>';
    echo '<script>window.location.href="s_attendance";</script>';
    exit;
} elseif ($row["position"] == "Face Recognition") {
    $_SESSION["loggedinasfacerecog"] = true;
    $_SESSION["id"]=$row["id"];
    header("location:s_facerecog");
    exit;
} else {
    echo '<script>alert("Invalid Role!")</script>';
    echo '<script>window.location.href="s_attendance";</script>';
    exit;
}
}
 ?>
