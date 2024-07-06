<!DOCTYPE html>
<html>
<head>
<title>404 - Page Not Found</title>
<link rel="icon" href="../photos/logo.png">
<link rel="stylesheet" href="../css/effect.css">
<link rel="stylesheet" href="../css/style.css">
<!-- JS CSS -->
<link rel="stylesheet" href="../js/bootstrap.js">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
</head>
<body>
<div class="h-100 d-flex align-items-center justify-content-center text-center">
  <div>
    <br>
    <img src="../photos/404.gif" class="img-fluid w-75">
    <?php
    header("HTTP/1.0 404 - Page Not Found");
    echo "<h1><strong>ERROR</strong></h1>";
    echo "<h4>The requested URL was not found on this server.</h4>";
    ?>
    <br>
    <a href="index"><button class="btn btn-lg btn-primary rounded-pill my-2">GO BACK TO FACE RECOGNITION</button></a>
  </div>
  <br>
  <br>
</div>
</body>
</html>
