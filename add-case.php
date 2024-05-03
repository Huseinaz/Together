<?php 

session_start(); 

if ($_SESSION['loggedin'] != true)
{ 
header("Location: login.php");
} 
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $case_name = $_POST['case_name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $phone = $_POST['phone'];
    $status = 'Pending';
    $date = date('Y-m-d');
    $image = basename($_FILES['image']['name']);
    $userID = $_SESSION['id'];

    if($image != NULL)
    {
        $target_dir = "assets/images/cases/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $_SESSION["imageError"] = "The file is not an image!";
                $uploadOk = 0;
            }
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["imageError"] = "Sorry, file already exists!";
            $uploadOk = 0;
        }
         // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION["imageError"] = "Sorry, your file is too large!";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION["imageError"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!";
            $uploadOk = 0;
        }
    }

    $query="INSERT INTO cases VALUES ('', '$status', '$image','$case_name','$description','$type','$phone', '$date', '$userID')";

    if ($uploadOk == 0) {
        $_SESSION["error"] = "Sorry, your file was not uploaded!";
    }
    else 
    {
        if ( mysqli_query($conn,$query) ) //run the query
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) 
            {
                $_SESSION["imageSuccess"] = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            } 
            else 
            {
                $_SESSION["imageError"] = "Sorry, there was an error uploading your file!";
            }
            $_SESSION["success"] = "The case added successfully!";
        }
        else
        {
            $_SESSION["error"] = "The request failed: " . mysqli_error($conn);
        }
    }

}

    // $case_id = $_GET['case_id'];
    // $cases = "SELECT * FROM cases WHERE `case_id` = $case_id";
	// $result = mysqli_query($conn, $cases);
    // $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<link rel="shortcut icon" type="image/x-icon" href="assets/images/together.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">

<!-- SITE TITLE -->
<title>Together - Add Case</title>

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
        	<div class="col-xl-8 offset-2">
            	<div class="heading_s1">
            		<h4>Add case</h4>
                    <?php if(isset($_SESSION["success"])) { ?>
                    <div id="alert" class="alert alert-success" role="alert">
                        <?php echo $_SESSION["success"] ?>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION["error"])) { ?>
                    <div id="alert" class="alert alert-danger" role="alert">
                        <?php echo $_SESSION["error"]; ?>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION["imageError"])) { ?>
                    <div id="alert" class="alert alert-danger" role="alert">
                        <?php echo $_SESSION["imageError"]; ?>
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION["imageSuccess"])) { ?>
                    <div id="alert" class="alert alert-success" role="alert">
                        <?php echo $_SESSION["imageSuccess"]; ?>
                    </div>
                    <?php } ?>
                </div>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <input type="text" required class="form-control" name="case_name" placeholder="Case name">
                    </div>
                    <div class="form-group mb-3">
                        <select name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="Medical">Medical</option>
                            <option value="Human">Human</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="description" placeholder="Description" required>
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" type="text" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" type="file" name="image" placeholder="Image">
                    </div>
                    <div class="col-md-6 offset-3">
                        <button type="submit" name="submit" class="btn btn-fill-out btn-block">Add the case</button>                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->


</div>
<!-- END MAIN CONTENT -->

<script>
    $("#alert").fadeTo(8000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
    });
</script>

<?php
    include('layout/footer.html');
    unset($_SESSION["success"]);
    unset($_SESSION["error"]);
    unset($_SESSION["imageError"]);
    unset($_SESSION["imageSuccess"]);
    mysqli_close($conn);
?>

</body>
</html>