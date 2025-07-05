<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'donation');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Handle already donor check
if (isset($_POST['check_donor'])) {
    $email = $_POST['donor_email'];

    $stmt = $conn->prepare("SELECT * FROM donarinfo WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: donate.php");
        exit();
    } else {
        echo "<script>alert('Email not found. Please fill the form to register.');</script>";
    }
}

// Handle new donor form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['phone_no'];
    $pincode = $_POST['pincode'];

    $stmt = $conn->prepare("INSERT INTO donarinfo (name, gender, email, address, contact, pincode) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $gender, $email, $address, $contact, $pincode);

    if ($stmt->execute()) {
        echo "<script>alert('Successfully registered!');
            window.location.href = 'donate.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Donor Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      margin-top: 50px;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .modal-header .btn-close {
      margin: -1rem -1rem -1rem auto;
    }
  </style>
</head>

<body>

<div class="container">
  <!-- Already Donor Button -->
  <div class="text-end mt-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#donorModal">Already a Donor?</button>
  </div>

  <!-- Registration Form -->
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="form-container mt-4">
        <h3 class="text-center mb-4">Donor Registration</h3>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Gender *</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="Male" required>
              <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="Female" required>
              <label class="form-check-label">Female</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact No *</label>
            <input type="text" name="phone_no" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Pincode *</label>
            <input type="text" name="pincode" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="donorModal" tabindex="-1" aria-labelledby="donorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="donorModalLabel">Check Donor Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="email" name="donor_email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="modal-footer">
          <button type="submit" name="check_donor" class="btn btn-primary">Check</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
