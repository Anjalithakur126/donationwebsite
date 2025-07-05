<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if (!isset($_SESSION['reset_email'])) {
    header('Location: forgetpaswrd.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];

    if (empty($newPassword)) {
        echo "<script>alert('Please enter a new password');</script>";
    } else {
        $email = $_SESSION['reset_email'];

        $updateQuery = "UPDATE user SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ss', $newPassword, $email);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            unset($_SESSION['reset_email']);
            echo "<script>alert('Password changed successfully. Please login now'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to update password');</script>";
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
    <link rel="stylesheet" href="css/resetpaswrd.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <input type="password" name="password" placeholder="Enter new password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
s