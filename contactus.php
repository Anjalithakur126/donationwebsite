<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert the form data into the contact table
    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Your message has been sent successfully.'); window.location.href='contactus.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error sending message. Please try again later.'); window.location.href='contactus.php';</script>";
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
    <link rel="stylesheet" href="css/contactus.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
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
                <li><button class="btn">
                    <?php if (isset($_SESSION['user_email'])) { ?>
                        <a href="userpanel.php">User Panel</a>
                    <?php } else { ?>
                        <a href="login.php">Login</a>
                    <?php } ?>
                </button></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="text-center">
            <h1>Contact Us</h1>
            <div>
                <b>Get in touch with us for any inquiries or support</b> 
                <div>Your feedback is important to us</div>
            </div>
        </div>
        <div class="content">
            <div class="col-1">
                <div class="address-line">
                    <i class="ri-map-pin-line"></i>
                    <div class="contact-info">
                        <div class="contact-info-title">Address</div>
                        <div>DonateHAPPINESS company, plot no57,</div>
                        <div>Jalandhar, Punjab</div>
                        <div>144004</div>
                    </div>
                </div>
                <div class="address-line">
                    <i class="ri-phone-line"></i>
                    <div class="contact-info">
                        <div class="contact-info-title">Phone</div>
                        <div>+91 8134609845</div>
                        <div>+91 6239037167</div>
                    </div>
                </div>
                <div class="address-line">
                    <i class="ri-mail-fill"></i>
                    <div class="contact-info">
                        <div class="contact-info-title">Email</div>
                        <div>DonateHAPPINESS@gmail.com</div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <form action="contactus.php" method="POST">
                    <div class="form-container">
                        <h2>Send Message</h2>
                        <div class="form-row">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-field" required>
                        </div>
                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-field" required>
                        </div>
                        <div class="form-row">
                            <label for="message">Enter your message...</label>
                            <textarea id="message" name="message" class="form-field" required></textarea>
                        </div>
                        <button type="submit" class="contact-button">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
