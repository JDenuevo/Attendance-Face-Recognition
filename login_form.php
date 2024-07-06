<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BERGS Attendance Monitoring System</title>
<link rel="stylesheet" href="css/effect.css">
<link rel="icon" href="photos/bergslogo.png">

<!-- Login Page CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- JS CSS -->
<link rel="stylesheet" href="js/bootstrap.js">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

<body>
<form action="login.php" method="POST" >
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body text-center p-5 shadow-lg">

              <img src="photos/bergs.png" class="img-fluid px-1">
              <hr class = "mb-3">
              <div class = "text-start">
                  
                  <label class="form-label" for="email">Email</label>
                  <div class="input-group form-outline mb-4">
                        <input type="text" id="typeEmailX-2" name ="email" value = "<?php if(isset($_COOKIE['fnbkn'])) echo $_SESSION['fnbkn']; ?>"class="form-control rounded" required/>
                  </div>
                  
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group form-outline mb-4">
                      <input type="password" id="password" value="<?php if(isset($_COOKIE['qbtuyqug'])) echo $_SESSION['qbtuyqug']; ?>" name="password" class="form-control" required />
                      <span class="input-group-text"> <i class="fa-solid fa-eye" id="togglePassword" data-toggle="tooltip" data-placement="left" title="Show/Hide password" style="cursor: pointer"></i></span>
                  </div>
              </div> 
              
              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-start mb-4">
                <input class="form-check-input" type="checkbox" value="1" name ="remember" <?php if(isset($_COOKIE['fnbkn'])){echo "checked='checked'"; } ?> id="remember" />
                <label class="form-check-label ms-2" for="remember" name ="remember"> Remember Me</label>
              </div>

              <!--<div class="d-flex justify-content-center">-->
              <!--  <div class="g-recaptcha" data-sitekey="6LdENq4lAAAAABmZuC89e_urWxQQx2OdXEvqzVjB"></div>-->
              <!--</div>-->
              
              <label class="text-muted">Please enter captcha before logging in.</label>
              <div class = "row text-center py-2">
                <div class="col-6">
                     <?php $challenge = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6); ?>
                     <div class="captcha"><?php echo $challenge; ?></div>
                    <input type="text" id="captchaChallenge" class="form-control form-control-md" name="captcha_challenge" value="<?php echo $challenge; ?>" hidden />
                </div>
                <div class="col-6">
                    <input type="text" id="captchaResponse" placeholder="Enter captcha" class="form-control" name="captcha_response" oninput="this.value = this.value.toUpperCase()" required/>
                </div>
              </div>
                <button type="submit" class="btn btn-primary my-2 btn-block w-100" id="submit">Login</button>
            </div>
          </div>
        </div>
        <br><br>
        <label class="text-center fw-semibold mt-3">You don't have the app? Download it now!</label>
        <br>
        <button type="button" class="btn btn-primary w-50 my-2" onclick="window.open('bergs.apk', '_blank');"><i class="fa-solid fa-download"></i> DOWNLOAD APP</button>
      </div>
    </div>
  </section>
</form>

<?php
		// Display error messages if they were passed in the URL
		if (isset($_GET['errors'])) {
			$errors = explode(',', $_GET['errors']);
			foreach ($errors as $error) {
				echo "<script>Swal.fire({
						icon: 'error',
						title: 'ERROR',
						text: '$error'
					});</script>";

        }
        unset($_GET['errors']);
		}
	?>

  <?php
  // Display error messages if they were passed in the URL
  if (isset($_GET['errors1'])) {
    $error1 = $_GET['errors1'];
    echo "<script>
      Swal.fire({
        icon: 'info',
        title: 'ARE YOU A BOT?',
        text: '$error1',
        showConfirmButton: false,
        showClass: {
          popup: 'animate__animated animate__fadeIn'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOut'
        }
      });
      setTimeout(function() {
        Swal.close();
      }, 4000);
    </script>";

    unset($_GET['errors1']);
  }
?>

<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function(e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    togglePassword.classList.toggle('fa-eye-slash');
    console.log(togglePassword.classList);
  });
</script>

<script>
  // Tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script>
if (window.performance) {
  if (performance.navigation.type == 1) {
    // Reloaded the page using the browser's reload button
    window.location.href = "index.php";
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  </body>
</html>
