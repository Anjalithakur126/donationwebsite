<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donateHAPPINESS</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
</head>

<body>

<header>
    <nav id="navbar">
        <div class="logo">
            <a href="#">Donate<span>Happiness</span></a>
        </div>
        <i class="ri-menu-fill" id="toggle"></i>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
            <li>
                <button class="btn">
                    <?php if (isset($_SESSION['user_email'])) { ?>
                        <a href="userpanel.php">User Panel</a>
                    <?php } else { ?>
                        <a href="login.php">Login</a>
                    <?php } ?>
                </button>
            </li>
        </ul>
    </nav>
</header>

</body>
</html>
