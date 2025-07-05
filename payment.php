<?php
session_start();
include('db_connection.php'); // assumes db connection is in this file

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user_email'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$grand_total = !empty($cart) ? array_sum(array_column($cart, 'total_price')) : 0;

// Fetch billing address
$stmt = $conn->prepare("SELECT name, email, city, zip, address, contact FROM billing_address WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$billing_address = $result->fetch_assoc();
$stmt->close();

// Update billing address
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_address'])) {
    $new_address = $_POST['billing_address'];
    $new_city = $_POST['city'];
    $new_postal_code = $_POST['postal_code'];
    $new_contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE billing_address SET address = ?, city = ?, zip = ?, contact = ? WHERE email = ?");
    $stmt->bind_param("sssss", $new_address, $new_city, $new_postal_code, $new_contact, $email);
    $stmt->execute();
    $stmt->close();

    header("Location: payment.php");
    exit;
}

// Process payment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pay_now'])) {
    $payment_method = $_POST['payment_method'];
    $cardholder = $_POST['cardholder'];
    $card_no = $_POST['card_no'];
    $exp_date = $_POST['exp_date'];
    $cvv = $_POST['cvv'];
    $paid_at = date("Y-m-d H:i:s");
    $status = 'Success';

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (email, total_amount, order_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $email, $grand_total, $paid_at);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert each cart item
    foreach ($cart as $item) {
        $stmt = $conn->prepare("INSERT INTO cart_item (order_id, item_name, email, Category, Description, price, quantity, total_price, image, product_id, payment) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'successful')");
        $stmt->bind_param("issssiiisi", $order_id, $item['item_name'], $email, $item['category'], $item['description'], $item['price'], $item['quantity'], $item['total_price'], $item['image'], $item['item_id']);
        $stmt->execute();
        $stmt->close();
    }

    // Insert payment record
    $stmt = $conn->prepare("INSERT INTO payment (order_id, method, status, paid_at, cardholder, card_no, exp_date, cvv)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $order_id, $payment_method, $status, $paid_at, $cardholder, $card_no, $exp_date, $cvv);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['cart']);
    echo "<script>alert('Payment Successful. Your order is confirmed.'); window.location.href='Thank_you.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center mb-4">Payment</h2>

        <h5>Billing Address</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($billing_address['name']); ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($billing_address['email']); ?></li>
            <li class="list-group-item"><strong>Street Address:</strong> <?= htmlspecialchars($billing_address['address']); ?></li>
            <li class="list-group-item"><strong>City:</strong> <?= htmlspecialchars($billing_address['city']); ?></li>
            <li class="list-group-item"><strong>Postal Code:</strong> <?= htmlspecialchars($billing_address['zip']); ?></li>
            <li class="list-group-item"><strong>Contact:</strong> <?= htmlspecialchars($billing_address['contact']); ?></li>
        </ul>
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#editAddressModal">Edit Address</button>

        <!-- Modal for editing address -->
        <div class="modal fade" id="editAddressModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="payment.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Billing Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" name="billing_address" value="<?= htmlspecialchars($billing_address['address']); ?>" required>

                            <label class="form-label mt-2">City</label>
                            <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($billing_address['city']); ?>" required>

                            <label class="form-label mt-2">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" value="<?= htmlspecialchars($billing_address['zip']); ?>" required>

                            <label class="form-label mt-2">Contact</label>
                            <input type="text" class="form-control" name="contact" value="<?= htmlspecialchars($billing_address['contact']); ?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="save_address" class="btn btn-success">Save Address</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h5 class="mt-4">Order Summary</h5>
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
        <p><strong>Total Amount:</strong> ₹<?= number_format($grand_total, 2); ?></p>

        <form method="POST" action="payment.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Cardholder Name</label>
                    <input type="text" name="cardholder" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Card Number</label>
                    <input type="text" name="card_no" maxlength="16" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Expiry Date</label>
                    <input type="month" name="exp_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">CVV</label>
                    <input type="password" name="cvv" maxlength="4" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select" required>
                    <option value="card" selected>Credit/Debit Card</option>
                </select>
            </div>

            <button type="submit" name="pay_now" class="btn btn-success w-100">Pay ₹<?= number_format($grand_total, 2); ?> Now</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
