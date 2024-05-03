<?php 
 
	session_start(); 
   
require_once "connection.php";

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {

	// Get the data from the form
	$email =  $_POST['email'];
	$pass =  $_POST['password'];
	$name =  $_POST['name'];
	$phone =  $_POST['phone'];
	$address =  $_POST['address'];
	

	// hashing the password
    $pass = password_hash($pass, PASSWORD_DEFAULT);
	
    // check if user with that email already exists
	$sql = "SELECT * FROM users WHERE email = '$email' ";

	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		header("Location: signup.php");
	    exit();
	}else {
        $sql2 = "INSERT INTO users(email, password, address, name, phoneNumber, roleID)
		VALUES('$email', '$pass', '$address' ,'$name', '$phone', 2)";
        $result2 = mysqli_query($conn, $sql2);
        // show error if something went wrong
        if (!$result2) {
            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
        }else{
            header("Location: login.php");
            exit();
        }
	}
}else{
	header("Location: signup.php");
	exit();
}