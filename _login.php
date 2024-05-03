<?php 

    session_start(); 
  
require_once "connection.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    // Get the data from the form
	$email = $_POST['email'];
	$pass = $_POST['password'];

    // escape username and pass for security
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    $getPasswordSql = "SELECT * FROM users WHERE email = '$email'";
	$res = mysqli_query($conn, $getPasswordSql);

    // Get the password from the database
    $row = mysqli_fetch_assoc($res);

    $dbPass = $row['password'];

	// Verify the password 
    if (password_verify($pass, $dbPass)) {
        if (mysqli_num_rows($res) === 1) {
            if ($row['email'] === $email) {
                if($row['status'] === 'Blocked') {
                    $_SESSION["error"] = "Sorry, you account is blocked!";
                    header("Location: login.php");
                    exit();
                }
                // set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['phone'] = $row['phoneNumber'];
                $_SESSION['role'] = $row['roleID'];
                $_SESSION['id'] = $row['userID'];

                setcookie("user_login", $email, time() + (10 * 365 * 24 * 60 * 60));
                // Password is stored as cookie for 10 years as 
                // 10years * 365days * 24hrs * 60mins * 60secs
                setcookie("user_password", $pass, time() + (10 * 365 * 24 * 60 * 60));

                if(isset($_SESSION['role']) && $_SESSION['role'] == 1) {
                    header("Location: dashboard.php");
                }
                else{
                header("Location: cases.php");
                exit();
                }
                
            }else{
                // show error message 
                $_SESSION["error"] = "Error: " . $res . "<br>" . mysqli_error($conn);
                header("Location: login.php");
            }
        }else{
            // show error message 
            $_SESSION["error"] = "Error2: " . $res . "<br>" . mysqli_error($conn);
            header("Location: login.php");
        }
    }else{
        header("Location: login.php");
        exit();
    }     
}