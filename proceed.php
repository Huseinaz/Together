<?php 

    session_start(); 
  
  if ($_SESSION['loggedin'] != true)
  { 
    header("Location: login.php");
  } 
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

require_once "connection.php";
$caseID = $_GET['caseID'];

$cases = "select * from cases where case_id=".$caseID;
$result = mysqli_query($conn,$cases);
$row = mysqli_fetch_array($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['id'];
    $caseID = $_GET['caseID'];
    $notes = $_POST['notes'];
    $status = 'Pending';
    $date = date("Y-m-d");

    $query="INSERT INTO takedcases VALUES ('','$userID','$caseID','$notes','$status','$date')";
    $query1="UPDATE cases set status='Taked' WHERE case_id='$caseID'";

    if ( mysqli_query($conn,$query) && mysqli_query($conn,$query1) ) //run the query
    {
        header("Location: completed.html");
    }
    else
    {
        $_SESSION["error"] = "The request failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=".">
<meta name="keywords" content="">

<?php include_once('layout/head.html'); ?>

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

<?php include_once('layout/header.php'); ?>

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
        <div class="row">
            
            <?php if(isset($_SESSION["error"])) { ?>
                <div id="alert" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION["error"] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        	<div class="col-md-6">
                <form method="post" accept="self">
                    <div class="heading_s1">
                        <h4>Additional information</h4>
                    </div>
                    <div class="form-group mb-0">
                        <textarea rows="5" class="form-control" placeholder="Add your notes here..." name="notes"></textarea>
                    </div>
                
            </div>
            <div class="col-md-6">
                <div class="order_review">
                    <div class="heading_s1">
                        <h4>Case Information</h4>
                    </div>
                    <div class="table-responsive order_table">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><?php echo $row['case_name'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $row['type'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $row['date'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="payment_method">
                        <div class="payment_option">
                            <div class="form-check">
                                <input class="form-check-input" required="" type="checkbox">
                                <label class="form-check-label" for="">Terms and Conditions</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="proceed" class="btn btn-fill-out btn-block">Proceed</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

<?php
    include('layout/footer.html');
    unset($_SESSION["error"]);
    mysqli_close($conn);
?>
<script>
    $("#alert").fadeTo(8000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
    });
</script>
</body>
</html>