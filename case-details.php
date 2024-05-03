<?php 

session_start(); 

if ($_SESSION['loggedin'] != true)
{ 
header("Location: login.php");
} 
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

require_once "connection.php";

    $case_id = $_GET['case_id'];
    $cases = "SELECT * FROM cases WHERE `case_id` = $case_id";
	$result = mysqli_query($conn, $cases);
    $row = mysqli_fetch_assoc($result);
    
?>


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
<title>Together - Case Details</title>

<?php
    include('layout/head.html');
?>

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

<!-- START SECTION BLOG -->
<div class="section">
	<div class="container">
    	<div class="row">
        	<div class="col-xl-8 offset-2">
            	<div class="single_post">
                    
                    <div class="blog_img">
                        <img src="assets/images/cases/<?php echo $row['image'] ?>" height="400px">
                    </div>
                    <div class="blog_content">
                        <div class="blog_text">
                	        <h2><?php echo $row['case_name'] ?></h2>
                            <p><?php echo $row['description'] ?></p>
                            <p> Phone number: <?php echo $row['phone'] ?></p>
                            <blockquote class="blockquote_style3">
                            	<p><?php echo $row['type'] ?></p>
                            </blockquote>
                           
                        	<div class="blog_post_footer">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <div class="tags">
                                            <a href="cases.php">Go back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BLOG -->

</div>
<!-- END MAIN CONTENT -->

<?php
    include('layout/footer.html');
    mysqli_close($conn);
?>

</body>
</html>