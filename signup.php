<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">

<!-- SITE TITLE -->
<title>Together - SignUp</title>

<?php
    include('layout/head.html');
?>

<script>
      function validate() {

      if (!document.getElementById("password").value == document.getElementById("confirmPassword").value) alert("Passwords do no match");
      return document.getElementById("password").value == document.getElementById("confirmPassword").value;
      return false;
   }
</script>

</head>

<body>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END LOADER -->

<?php
    include('layout/header.php');
?>

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START LOGIN SECTION -->
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
            		<div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Create an Account</h3>
                        </div>
                        <form action="_signup.php" method="Post">
                            <div class="form-group mb-3">
                                <input type="text" required="" class="form-control" name="name" placeholder="Enter Your Name">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" required="" class="form-control" name="email" placeholder="Enter Your Email">
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" required="" type="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" required="" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" required="" class="form-control" name="phone" placeholder="Enter Your Phone Number">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" required="" class="form-control" name="address" placeholder="Enter Your Address">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-fill-out btn-block" name="register">Register</button>
                            </div>
                        </form>

                        <div class="form-note text-center">Already have an account? <a href="login.php">Log in</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN SECTION -->

</div>
<!-- END MAIN CONTENT -->

<?php
    include('layout/footer.html');
?>

</body>
</html>