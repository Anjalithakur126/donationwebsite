<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'donation');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['admin_email'] = $email;
        header("Location: dashboard.php"); 
        exit();
    } else {
        $error_message = "Invalid credentials, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Donation Website</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans&family=Hanken+Grotesk&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
  <link rel="stylesheet" href="../css/logadmin.css">
</head>
<body>
  <div class="container">
    <!-- Admin Login Page -->
    <section id="login-section" class="login-section">
      <div class="login-box">
        <h2>Admin Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)) { ?>
          <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST">
          <label>Email
            <input type="email" name="email" placeholder="admin@example.com" required />
          </label>
          <label>Password
            <input type="password" name="password" placeholder="••••••••" required />
          </label>
          <button type="submit">Login</button>
        </form>
        <a href="../index.php">Back to home</a>
      </div>

      <div class="carousel-box">
        <h1>Welcome Admin</h1>
        <div id="splide-carousel" class="splide">
          <div class="splide__track">
            <ul class="splide__list">
              <li class="splide__slide">"Manage second-hand donations easily."</li>
              <li class="splide__slide">"Approve new entries with one click."</li>
              <li class="splide__slide">"Track delivery requests."</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
  <script>
    // Initialize the carousel
    new Splide('#splide-carousel').mount();
  </script>
</body>
</html>
