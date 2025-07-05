<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debugging: Check if email and password match directly
    $stmt = $conn->prepare('SELECT * FROM user WHERE email = ? AND password = ?');
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Set session variable for logged in user
        $_SESSION['user_email'] = $user['email'];
        echo "<script>alert('Login successfully');</script>";
        header('Location: index.php');
        exit();
    } else {
        echo "<script>alert('Incorrect email or password'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donateHAPPINESS</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>

<div class="wrapper">
    <form action="" method="POST">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" name="email" placeholder="Email" required>
        <i class="ri-user-fill"></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class="ri-lock-2-fill"></i>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
        <a href="forgetpaswrd.php">Forgot Password</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <div class="register-link">
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        <br>
        <p>Go to home - <a href="index.php">Click here</a></p>
      </div>
    </form>
</div>

</body>
</html>
