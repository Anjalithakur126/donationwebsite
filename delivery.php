<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['admin_email'])) {
  header("Location: logadmin.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (isset($_POST['update_delivery'])) {
        $status = $_POST['status'];
        $person = $_POST['delivery_person'] ?? '';
        $contact = $_POST['delivery_contact'] ?? '';
        $query = "UPDATE cart_item SET status='$status', delivery_person='$person', delivery_contact='$contact' WHERE id=$id";
        mysqli_query($conn, $query);
    }

    if (isset($_POST['mark_delivered'])) {
        mysqli_query($conn, "UPDATE cart_item SET status='Delivered' WHERE id=$id");
    }

    if (isset($_POST['cancel'])) {
        mysqli_query($conn, "UPDATE cart_item SET status='Cancelled' WHERE id=$id");
    }

    if (isset($_POST['delete'])) {
        mysqli_query($conn, "DELETE FROM cart_item WHERE id=$id");
    }

    header('Location: delivery.php');
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM cart_item");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delivery Requests</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #f5f7fa;
      padding: 2rem;
      color: #333;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    header h1 {
      font-size: 2rem;
      color: #374151;
    }

    header button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    header button:hover {
      background-color: #1e40af;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 1rem;
      text-align: left;
    }

    thead {
      background-color: #e5e7eb;
    }

    tbody tr:hover {
      background-color: #f3f4f6;
    }

    .actions button {
      margin-right: 5px;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.9rem;
    }

    .assign { background-color: #10b981; color: white; }
    .approve { background-color: #3b82f6; color: white; }
    .reject { background-color: #ef4444; color: white; }

    .assign:hover { background-color: #059669; }
    .approve:hover { background-color: #2563eb; }
    .reject:hover { background-color: #dc2626; }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
    }

    .modal-content {
      background: #fff;
      margin: 8% auto;
      padding: 2rem;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .modal-content h3 {
      margin-bottom: 1rem;
      color: #111827;
    }

    .modal-content label {
      display: block;
      margin-bottom: 6px;
      color: #374151;
      font-weight: 600;
    }

    .modal-content input, .modal-content select {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 1rem;
      border: 1px solid #d1d5db;
      border-radius: 6px;
    }

    .modal-content button {
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-right: 10px;
    }

    .save-btn {
      background-color: #10b981;
      color: white;
    }

    .close-btn {
      background-color: #6b7280;
      color: white;
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>

  <header>
    <h1>Delivery Requests</h1>
    <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
  </header>

  <table>
    <thead>
      <tr>
        <th>Item</th>
        <th>Receiver</th>
        <th>quantity</th>
        <th>total price</th>
        <th>payment</th>
        <th>Status</th>
        <th>Delivery Person</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?= $row['item_name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td><?= $row['total_price'] ?></td>
          <td><?= $row['payment'] ?></td>
          <td><?= $row['status'] ?></td>
          <td><?= $row['delivery_person'] ?: 'Not Assigned' ?></td>
          <td class="actions">
            <button class="assign" onclick='openModal(<?= json_encode($row) ?>)'>Status</button>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button class="approve" name="mark_delivered">Delivered</button>
              <button class="reject" name="cancel">Cancel</button>
              <button class="reject" name="delete">Delete</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Modal -->
  <div id="assignModal" class="modal">
    <div class="modal-content">
      <form method="POST">
        <h3>Edit Delivery</h3>
        <input type="hidden" name="id" id="modal_id">

        <label>Status</label>
        <select name="status" id="modal_status" onchange="toggleDeliveryInputs(this.value)">
          <option value="Pending">Pending</option>
          <option value="Assigned">Assigned</option>
          <option value="Parcel Shipped">Parcel Shipped</option>
          <option value="Delivered">Delivered</option>
          <option value="Cancelled">Cancelled</option>
        </select>

        <div id="deliveryInfo" class="hidden">
          <label>Delivery Person</label>
          <input type="text" name="delivery_person" id="modal_person">
          <label>Contact</label>
          <input type="text" name="delivery_contact" id="modal_contact">
        </div>

        <button type="submit" name="update_delivery" class="save-btn">Save</button>
        <button type="button" class="close-btn" onclick="closeModal()">Cancel</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(data) {
      document.getElementById("assignModal").style.display = "block";
      document.getElementById("modal_id").value = data.id;
      document.getElementById("modal_status").value = data.status;
      document.getElementById("modal_person").value = data.delivery_person || "";
      document.getElementById("modal_contact").value = data.delivery_contact || "";
      toggleDeliveryInputs(data.status);
    }

    function closeModal() {
      document.getElementById("assignModal").style.display = "none";
    }

    function toggleDeliveryInputs(status) {
      const deliveryInfo = document.getElementById("deliveryInfo");
      deliveryInfo.classList.toggle("hidden", status !== "Parcel Shipped");
    }

    window.onclick = function(e) {
      const modal = document.getElementById("assignModal");
      if (e.target === modal) closeModal();
    };
  </script>

</body>
</html>
