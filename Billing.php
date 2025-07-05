<?php
session_start();
ob_start();
include("db_connection.php");

// Redirect to login if session is not set
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";
$email = $_SESSION['user_email'];

// Check if billing info already exists
$stmt = $conn->prepare("SELECT * FROM billing_address WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: payment.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $zip = trim($_POST['zip']);
    $contact = trim($_POST['contact']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);

    $stmt = $conn->prepare("INSERT INTO billing_address (name, email, address, zip, contact, state, city)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $address, $zip, $contact, $state, $city);

    if ($stmt->execute()) {
        header("Location: payment.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Donate Happiness - Billing Address</title>
  <link rel="stylesheet" href="css/payment.css">
  <style>
    body { font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px; }
    .container { background-color: #fff; padding: 30px; max-width: 500px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; color: #333; }
    input[type=text], input[type=email] {
      width: 100%; padding: 12px; margin: 8px 0 20px 0; display: inline-block;
      border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
    }
    .btn {
      background-color: #4CAF50; color: white; padding: 14px 20px;
      border: none; border-radius: 4px; cursor: pointer; width: 100%;
    }
    .btn:hover { background-color: #45a049; }
    .message { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
    .success { background-color: #dff0d8; color: #3c763d; }
    .error { background-color: #f2dede; color: #a94442; }
  </style>
</head>
<body>

<div class="container">
  <h2>Billing Address</h2>
  <p>Everything on our platform is free! We only charge a small delivery fee.</p>

  <?php if ($success): ?>
    <div class="message success"><?php echo $success; ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="message error"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="User Name" required>

    <label for="email">Email</label>
    <input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" placeholder="542 W. 15th Street" required>

    <label for="zip">Zip</label>
    <input type="text" id="zip" name="zip" placeholder="10001" required>

    <label for="contact">Contact No</label>
    <input type="text" id="contact" name="contact" placeholder="12345*****" required>

    <label for="state">State</label>
    <input type="text" id="state" name="state" placeholder="Delhi" required>

    <label for="city">City</label>
    <input type="text" id="city" name="city" placeholder="Jalandhar" required>

    <button type="submit" class="btn">Submit</button>
  </form>
</div>

</body>
</html>
