<?php 
 
session_start(); 
  
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

require_once "connection.php";

if(isset($_GET['filter'])) 
{
    $filter = intval($_GET['filter']);
    $cases = "SELECT * FROM cases WHERE `type` = $filter";
    $result = mysqli_query($conn, $cases);
    $rows = array();
    $count = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result))
        $rows[] = $row;
}
else
{
    $cases = "SELECT * FROM cases WHERE `status` = 'Active'";
    $result = mysqli_query($conn, $cases);
    $rows = array();
    $count = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result))
        $rows[] = $row;
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
<meta name="description" content="">
<meta name="keywords" content="">

<!-- SITE TITLE -->
<title>Together - Cases</title>

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

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
    	<div class="row">
			<div class="col-12">
            	<div class="row align-items-center mb-4 pb-1">
                    <div class="col-12">

                        <div class="product_header">
                            <div class="product_header_left">
                            </div>
                            <div class="product_header_right">
                            	<div class="products_view">
                                    <a href="javascript:void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                    <a href="javascript:void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

               
                <div class="row shop_container loadmore" data-item="8" data-item-show="4" data-finish-message="No More Item to Show" data-btn="Load More">
             

                <?php foreach ($rows as $key => $item) { ?>

                    <div class="col-lg-3 col-md-4 col-6 grid_item">
                        <div class="product">
                            <div class="product_img">
                                    <img src="assets/images/cases/<?php echo $item['image'] ?>" alt="product_img1" height='200px'>
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart">
                                            <?php if($_SESSION['loggedin'] != true) { ?>
                                            <a href="login.php">
                                                <i class="icon-user"></i> 
                                            </a>
                                            <?php } elseif($_SESSION['id'] == $item['user_id']) { ?>

                                            <?php } else { ?>
                                            <a href="proceed.php?caseID=<?php echo $item['case_id'] ?>">
                                                <i class="icon-check"></i> 
                                            </a>
                                            <?php } ?>
                                        </li>
                                        <li>
                                            <a href="case-details.php?case_id=<?php echo $item['case_id'] ?>" class="">
                                                <i class="icon-magnifier-add"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title">
                                    <a href="case-details.php?case_id=<?php echo $item['case_id'] ?>">
                                        <?php echo $item['case_name'] ?>
                                    </a>
                                </h6>
                                <div class="product_price">
                                    <div class="on_sale">
                                        <span><?php echo $item['type'] ?></span>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="">
                                        <span><?php echo $item['date'] ?></span>
                                    </div>
                                </div>
                                <div class="pr_desc">
                                    <p><?php echo $item['description'] ?></p>
                                </div>
                                <div class="list_product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart">
                                            <?php if($_SESSION['loggedin'] != true) { ?>
                                            <a href="login.php">
                                                LogIn to take
                                            </a>
                                            <?php } elseif($_SESSION['id'] == $item['user_id']) { ?>
                                                <button class="btn btn-secondary" disabled  >Your case</button>
                                            <?php } else { ?>
                                            <a href="proceed.php?caseID=<?php echo $item['case_id'] ?>">
                                                Take Case
                                            </a>
                                            <?php } ?>
                                        </li>
                                        <li class="add-to-cart ">
                                            <a href="case-details.php?case_id=<?php echo $item['case_id'] ?>" class="bg-info">
                                                View Case
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
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
    mysqli_close($conn);
?>

</body>
</html>