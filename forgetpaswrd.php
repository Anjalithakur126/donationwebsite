<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "<script>alert('Please enter your email');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } else {
        $checkQuery = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $_SESSION['reset_email'] = $email;
            header('Location: resetpaswrd.php');
            exit();
        } else {
            echo "<script>alert('Email not found in our records');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donateHAPPINESS</title>
    <link rel="stylesheet" href="css/forgetpaswrd.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
</head>
    
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Enter your email address</p>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
