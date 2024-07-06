<!DOCTYPE html>
<html>
<head>
<title>404 - Page Not Found</title>
<link rel="icon" href="photos/logo.png">
<link rel="stylesheet" href="css/effect.css">
<link rel="stylesheet" href="css/style.css">
<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">

<script src="https://kit.fontawesome.com/4b9ba14b0f.js" crossorigin="anonymous"></script>

</head>
<body style = "background-color: #4f96fe;">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
.far{
  font-size: 150px;
}

.num{
  font-size: 170px;
  font-family: 'Poppins', sans-serif;
}
</style>
<div class="h-100 d-flex align-items-center justify-content-center text-center">
    <br>
    <br>
    <div class="container">
        <br>
        <br>
        <?php
        header("HTTP/1.0 404 - Page Not Found");
        echo "<h1><strong>ERROR</strong></h1>";
        echo "<h4>The requested URL was not found on this server.</h4>";
        ?>
        <br>
        <div class = "justify-content-around text-center">
            <div class="far num text-white mx-1">4</div>
            <i class="far fa-question-circle fa-spin text-white mx-1"></i>
            <div class="far num text-white mx-1">4</div>
        </div>    
        <br>
        <div class="msg">Maybe this page moved? Got deleted? Never existed in the first place?<p>Let's go <a class="text-white" href="index">Dashboard</a> and try from there.</p></div>
    </div>

    
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
