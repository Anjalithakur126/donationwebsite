<?php
session_start();
include('db_connection.php'); // assumes this file has $conn = new mysqli(...);

// Redirect if user not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];

// Get user info
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

// Get billing address
$addressStmt = $conn->prepare("SELECT * FROM billing_address WHERE email = ?");
$addressStmt->bind_param("s", $email);
$addressStmt->execute();
$addressResult = $addressStmt->get_result();
$address = $addressResult->fetch_assoc();

// Get cart items (Orders)
$orderStmt = $conn->prepare("SELECT * FROM cart_item WHERE email = ?");
$orderStmt->bind_param("s", $email);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-primary py-3">
    <nav class="navbar navbar-expand-lg navbar-dark container">
        <a class="navbar-brand fw-bold" href="#">Donate<span class="text-warning">Happiness</span></a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light me-2">Home</a>
            <a href="logout.php" class="btn btn-light">Logout</a>
        </div>
    </nav>
</header>

<div class="container py-5">
    <div class="mb-4 text-center">
        <h2 class="text-primary">Welcome, <?= htmlspecialchars($user['name']) ?></h2>
    </div>

    <!-- User Info -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mb-3">User Info</h4>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        </div>
    </div>

    <!-- Billing Address -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>Billing Address</span>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAddressModal">Edit</button>
            </h4>
            <?php if ($address): ?>
                <p><strong>Address:</strong> <?= htmlspecialchars($address['address']) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($address['city']) ?></p>
                <p><strong>State:</strong> <?= htmlspecialchars($address['state']) ?></p>
                <p><strong>Zip:</strong> <?= htmlspecialchars($address['zip']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($address['contact']) ?></p>
            <?php else: ?>
                <p class="text-muted">No billing address found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Orders -->
    <div class="card">
        <div class="card-body">
            <h4>Orders</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Track</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $orderResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['item_name']) ?></td>
                                <td><?= htmlspecialchars($row['Category']) ?></td>
                                <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="70" height="70"></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>₹<?= $row['price'] ?></td>
                                <td>₹<?= $row['total_price'] ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><a href="track.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Track</a></td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($orderResult->num_rows == 0): ?>
                            <tr><td colspan="8" class="text-center text-muted">No orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="update_address.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Billing Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <div class="mb-2">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?= $address['address'] ?? '' ?>" required>
                </div>
                <div class="mb-2">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="<?= $address['city'] ?? '' ?>" required>
                </div>
                <div class="mb-2">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="<?= $address['state'] ?? '' ?>" required>
                </div>
                <div class="mb-2">
                    <label>Zip</label>
                    <input type="text" name="zip" class="form-control" value="<?= $address['zip'] ?? '' ?>" required>
                </div>
                <div class="mb-2">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control" value="<?= $address['contact'] ?? '' ?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="update_address" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
