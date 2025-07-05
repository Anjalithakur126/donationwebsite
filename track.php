<?php
session_start();
include('db_connection.php');

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('No order ID provided'); window.location.href='user_panel.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM cart_item WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<script>alert('Order not found'); window.location.href='user_panel.php';</script>";
    exit();
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-primary py-3">
    <nav class="navbar navbar-expand-lg navbar-dark container">
        <a class="navbar-brand fw-bold" href="#">Donate<span class="text-warning">Happiness</span></a>
        <div class="ms-auto">
            <a href="userpanel.php" class="btn btn-outline-light">Back</a>
        </div>
    </nav>
</header>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="text-center text-primary mb-4">Order Tracking Details</h3>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <img src="uploads/<?= htmlspecialchars($order['image']) ?>" alt="Item Image" class="img-fluid rounded" style="max-height: 200px;">
                </div>
                <div class="col-md-8">
                    <div class="mb-2"><strong>Item Name:</strong> <?= htmlspecialchars($order['item_name']) ?></div>
                    <div class="mb-2"><strong>Category:</strong> <?= htmlspecialchars($order['Category']) ?></div>
                    <div class="mb-2"><strong>Description:</strong> <?= htmlspecialchars($order['Description']) ?></div>
                    <div class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></div>
                    <div class="mb-2"><strong>Quantity:</strong> <?= $order['quantity'] ?></div>
                    <div class="mb-2"><strong>Price per Item:</strong> ₹<?= $order['price'] ?></div>
                    <div class="mb-2"><strong>Total Price:</strong> ₹<?= $order['total_price'] ?></div>
                    <div class="mb-2"><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></div>
                    <div class="mb-2"><strong>Payment:</strong> <?= htmlspecialchars($order['payment']) ?></div>
                    <div class="mb-2"><strong>Delivery Person:</strong> <?= htmlspecialchars($order['delivery_person']) ?></div>
                    <div class="mb-2"><strong>Delivery Contact:</strong> <?= htmlspecialchars($order['delivery_contact']) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
