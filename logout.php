<?php

session_start();

unset($_SESSION['user_name']);
unset($_SESSION['name']);
unset($_SESSION['id']);
unset($_SESSION['position']);
unset($_SESSION["loggedinasadmin"]);
unset($_SESSION["loggedinasstaff"]);
unset($_SESSION["loggedinasemployee"]);
unset($_SESSION["loggedinasguest"]);
unset($_SESSION['employee_id']);



$_SESSION['usertype'] = "";

header("location: index.php");

exit;
?>
