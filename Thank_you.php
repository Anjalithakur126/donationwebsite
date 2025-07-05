<?php
session_start();

unset($_SESSION['cart']);

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thank You page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico">

    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="spinner-container">
        <div class="spinner"></div>
    </div>

    <!-- Thank You Message -->
    <div class="container thank-you-container" style="height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h1 class="success-title">
            <span class="icon-success">&#10004;</span> Thank You for Your Order!
        </h1>
        <p class="confirmation-text">Your order has been placed successfully.<br>You will receive a confirmation email shortly.</p>
        <a href="userpanel.php" class="btn-primary" style="padding: 10px; margin-top: 10px; background-color: white;">Go to My Orders</a>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn-top">&#8679;</a>

    <script src="javs.js"></script>
</body>
</html>
