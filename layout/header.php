<?php 
session_start();

$activePage = basename($_SERVER['PHP_SELF'], ".php"); 
?>

<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar bg-light">

    <div class="bottom_header dark_skin main_menu_uppercase">
    	<div class="container">
            <nav class="navbar navbar-expand-lg"> 
                <a class="navbar-brand" href="index.php">
                    <img class="logo_light" src="assets/images/Togeher.png" alt="logo" />
                    <img class="logo_dark" src="assets/images/Together.png" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false"> 
                    <span class="ion-android-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                            <li class="dropdown">
                                <a href="index.php" class="nav-link <?= ($activePage == 'index') ? 'active':''; ?>">Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="about.php" class="nav-link <?= ($activePage == 'about') ? 'active':''; ?>">About us</a>
                            </li>
                            <li class="dropdown">
                                <a href="donate.php" class="nav-link <?= ($activePage == 'donate') ? 'active':''; ?>">Donate</a>
                            </li>
                            <li>
                                <a href="contact.php" class="nav-link <?= ($activePage == 'contact') ? 'active':''; ?>">Contact us</a>
                            </li> 
                            <li class="dropdown">
                                <a href="cases.php" class="nav-link <?= ($activePage == 'cases') ? 'active':''; ?>">Cases</a>
                            </li>

                            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                            <li class="dropdown">
                                <a href="add-case.php" class="nav-link <?= ($activePage == 'add-case') ? 'active':''; ?>">Add case</a>
                            </li>
                            <li class="dropdown">
                                <a href="my-account.php" class="nav-link <?= ($activePage == 'my-account') ? 'active':''; ?>">My account</a>
                            </li>
                            <li>
                                <a href='logout.php' class="nav-link">Logout</a>
                            </li>
                            <?php } ?>
                    </ul>
                </div>

                <ul class="navbar-nav attr-nav align-items-center">
                    <?php if(empty($_SESSION['loggedin'])) { ?>
                    <li class="dropdown cart_dropdown">
                                
                                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                    <i class="ti-user"></i>
                                </a>
                                <div class="cart_box dropdown-menu dropdown-menu-right">
                                    <ul class="cart_list">
                                        <a href="login.php" class="">
                                            <li>
                                                Sign In
                                            </li>
                                        </a>
                                        <a href="signup.php" class="">
                                            <li>
                                                Sign Up
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>

</header>
<!-- END HEADER -->