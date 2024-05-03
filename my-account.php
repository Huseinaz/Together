<?php

session_start(); 
  
if ($_SESSION['loggedin'] != true)
{ 
header("Location: login.php");
} 
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

require_once "connection.php";

$userID = $_SESSION['id'];
$users = "SELECT * FROM users WHERE `userID` = $userID";
$userResult = mysqli_query($conn, $users);
$userRow = mysqli_fetch_assoc($userResult);

if(isset($_POST['submitUser']))
{
    $id = $_POST['userID'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $roleID = $userRow['roleID'];

    // hashing the password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $userQuery="UPDATE users set address='$address', name='$name', email='$email',  password='$password', phoneNumber='$phoneNumber', roleID='$roleID' WHERE userID='$id'";
    if ( mysqli_query($conn,$userQuery) ) //run the query
    {
        $_SESSION["success"] = "The data saved successfully ";
    }
    else
    {
        $_SESSION["error"] = "The request failed: " . mysqli_error($conn);
    }
            
}

if(isset($_GET['deleteCase']))
{
    $id = $_GET['deleteCase'];
    $query = "DELETE FROM cases where case_id=".$id;
    if(mysqli_query($conn,$query))
    {
        $_SESSION["success"] = "The case deleted successfully!";
    }
    else {
        $_SESSION["error"] = "The request failed: " . mysqli_error($conn);
    }
}

    $cases = "SELECT * FROM cases WHERE `user_id` = $userID ";
    $result = mysqli_query($conn, $cases);
    $rows = array();
    while($row = mysqli_fetch_assoc($result))
    $rows[] = $row;

    $takedcases = "SELECT * FROM takedcases WHERE `userID` = $userID ";
    $takedresult = mysqli_query($conn, $takedcases);
    $takedrows = array();
    while($takedrow = mysqli_fetch_assoc($takedresult))
    $takedrows[] = $takedrow;


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
<title>Together - My Account </title>

<?php
    include('layout/head.html');
?>

<style>
    .dashboard_content .table tbody tr:last-child td {
        padding-bottom: 10px;
    }
</style>
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

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
        <div class="row">
            <div class="row col-md-12">
                <?php if(isset($_SESSION["success"])) { ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION["success"] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION["error"])) { ?>
                    <div id="alert" class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION["error"] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="dashboard_menu">
                    <ul class="nav nav-tabs flex-column" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="ti-layout-grid2"></i>Taken cases</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="ti-check-box"></i>My Cases</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="ti-id-badge"></i>Account details</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="ti-lock"></i>Logout</a>
                      </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="tab-content dashboard_content">
                  	<div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    	<div class="card">
                        	<div class="card-header">
                                <h3>Taken Cases</h3>
                            </div>
                            <div class="card-body">
                    			<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Case Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($takedrows as $takedkey => $takeditem) { 
                                                $case_id = $takeditem['caseID'];
                                                $nameCase = "SELECT * FROM cases WHERE `case_id` = $case_id";
                                                $nameResult = mysqli_query($conn, $nameCase);
                                                $nameRow = mysqli_fetch_assoc($nameResult);
                                            ?>
                                            <tr>
                                                <td><?php echo $nameRow['case_name'] ?></td>
                                                <td><?php echo $takeditem['date'] ?></td>
                                                <td>
                                                    <?php if($takeditem['status'] == 'Taked') { ?>
                                                        <span class="badge bg-default"><?php echo $takeditem['status'] ?></span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-warning"><?php echo $takeditem['status'] ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $takeditem['notes'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  	</div>
                  	<div class="tab-pane fade " id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    	<div class="card">
                        	<div class="card-header">
                                <h3>Cases
                                    <span class="" style="float:right">
                                        <a href="add-case.php" class="btn btn-primary btn-sm">
                                            New
                                        </a>
                                    </span>
                                </h3>
                            </div>
                            <div class="card-body">
                    			<div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Case Name</th>
                                                <th>Type</th>
                                                <th>Phone</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rows as $key => $item) { ?>
                                            <tr>
                                                <td><?php echo $item['case_name'] ?></td>
                                                <td><?php echo $item['type'] ?></td>
                                                <td><?php echo $item['phone'] ?></td>
                                                <td> <img src="assets/images/cases/<?php echo $item['image'] ?>" width="50px;" /> </td>
                                                <td><?php echo $item['date'] ?></td>
                                                <td>
                                                    <?php if($item['status'] == 'Active') { ?>
                                                        <a href="case-details.php?case_id=<?php echo $item['case_id'] ?>" target="_blank" class="text-info "><i class="ti-search"></i></a>
                                                        <a href="edit-case.php?case_id=<?php echo $item['case_id'] ?>" class="text-warning m-2"><i class="ti-pencil-alt"></i></a>

                                                        <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?deleteCase=<?php echo $item['case_id'] ?>" class="text-danger" onclick="return confirm('Are you sure?');">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                    <?php } elseif($item['status'] == 'Pending')  { ?>
                                                        <span class="badge bg-warning"><?php echo $item['status'] ?></span>
                                                    <?php } elseif($item['status'] == 'Taked')  { ?>
                                                        <span class="badge bg-success"><?php echo $item['status'] ?></span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-secondary"><?php echo $item['status'] ?></span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  	</div>
                      
                    <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
						<div class="card">
                        	<div class="card-header">
                                <h3>Account Details</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" name="enq" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <div class="row">
                                        <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="userID">
                                        <div class="form-group col-md-12 mb-3">
                                        	<label>Name <span class="required"></span></label>
                                            <input required="" class="form-control" name="name" type="text" value="<?php echo $userRow['name'] ?>">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                        	<label>Email <span class="required"></span></label>
                                            <input required="" class="form-control" name="email" type="email" value="<?php echo $userRow['email'] ?>">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                        	<label>Address <span class="required"></span></label>
                                            <input class="form-control" name="address" type="text" value="<?php echo $userRow['address'] ?>">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                        	<label>Phone number <span class="required"></span></label>
                                            <input class="form-control" name="phoneNumber" type="phone" value="<?php echo $userRow['phoneNumber'] ?>">
                                        </div>
                                        <div class="form-group col-md-12 mb-3">
                                        	<label>Password <span class="required"></span></label>
                                            <input class="form-control" name="password" type="password" value="<?php echo $userRow['password'] ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-fill-out" name="submitUser" value="Submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->
<script>
    $("#alert").fadeTo(5000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
    });
</script>
<?php
    include('layout/footer.html');
    unset($_SESSION["success"]);
    unset($_SESSION["error"]);
    mysqli_close($conn);
?>

</body>
</html>