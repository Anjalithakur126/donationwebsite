<?php
session_start();
include("../db_connection.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: logadmin.php");
    exit();
}

// Approve / Reject
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = ($_GET['action'] === 'approve') ? 'Approved' : 'Rejected';
    mysqli_query($conn, "UPDATE items SET status = '$status' WHERE id = $id");
    header("Location: items.php");
    exit();
}

// Update Item
if (isset($_POST['update_item'])) {
    $id = intval($_POST['edit_id']);
    $pname = $_POST['edit_pname'];
    $category = $_POST['edit_category'];
    $donarmail = $_POST['edit_donarmail'];
    $status = $_POST['edit_status'];
    $description = $_POST['edit_description'];
    $price = $_POST['edit_price'];

    mysqli_query($conn, "UPDATE items SET pname='$pname', category='$category', donarmail='$donarmail', status='$status', description='$description', price='$price' WHERE id=$id");
    header("Location: items.php");
    exit();
}

// Delete Item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM items WHERE id = $id");
    header("Location: items.php");
    exit();
}

// Add New Item
if (isset($_POST['add_item'])) {
    $pname = $_POST['pname'];
    $category = $_POST['category'];
    $donarmail = $_POST['donarmail'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    mysqli_query($conn, "INSERT INTO items (pname, category, donarmail, status, description, price, image) VALUES ('$pname', '$category', '$donarmail', '$status', '$description', '$price', '$image')");
    header("Location: items.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Donations</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans&family=Hanken+Grotesk&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #737a5d;
      --dark-primary-color: #ffffff;
      --secondary-color: #ccbfa3;
      --text-color: #010816;
      --divider-color: #02111b;
      --accent-font: 'Hanken Grotesk', sans-serif;
      --default-font: 'DM Sans', sans-serif;
      --transition: all 0.3s ease-in-out;
    }

    body {
      font-family: var(--default-font);
      background-color: var(--dark-primary-color);
      color: var(--text-color);
      padding: 2rem;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .btn {
      padding: 0.5rem 1rem;
      background-color: #0277bd;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 1rem;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: var(--secondary-color);
      font-family: var(--accent-font);
    }

    tr:hover {
      background-color: #f7f7f7;
    }

    .actions button {
      margin-right: 5px;
      padding: 6px 10px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
    }

    .approve { background-color: green; color: white; }
    .reject { background-color: red; color: white; }
    .edit { background-color: #ff9800; color: white; }
    .delete { background-color: #9c27b0; color: white; }

    #editModal, #addModal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      z-index: 999;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      width: 400px;
    }

    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }

    .modal-btn {
      margin-top: 10px;
      padding: 8px 12px;
    }
  </style>
</head>
<body>

<header>
  <h1>Manage items</h1>
  <div>
    <button class="btn" onclick="document.getElementById('addModal').style.display='block'">Add New Item</button>
    <button class="btn" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
  </div>
</header>

<table>
  <thead>
    <tr>
      <th>Image</th>
      <th>Item</th>
      <th>Description</th>
      <th>Category</th>
      <th>Price</th>
      <th>Donor</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="" width="60"></td>
        <td><?= htmlspecialchars($row['pname']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= htmlspecialchars($row['price']) ?></td>
        <td><?= htmlspecialchars($row['donarmail']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td class="actions">
          <?php if ($row['status'] !== 'Approved'): ?>
            <a href="?action=approve&id=<?= $row['id'] ?>"><button class="approve">Approve</button></a>
          <?php endif; ?>
          <?php if ($row['status'] !== 'Rejected'): ?>
            <a href="?action=reject&id=<?= $row['id'] ?>"><button class="reject">Reject</button></a>
          <?php endif; ?>
          <button class="edit" onclick='editItem(<?= json_encode($row) ?>)'>Edit</button>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')"><button class="delete">Delete</button></a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Add Modal -->
<form method="POST" enctype="multipart/form-data">
  <div id="addModal">
    <h3>Add New Item</h3>
    <input type="text" name="pname" placeholder="Item Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="text" name="category" placeholder="Category" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="email" name="donarmail" placeholder="Donor Email" required>
    <select name="status" required>
      <option value="Pending">Pending</option>
      <option value="Approved">Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
    <input type="file" name="image" required>
    <button type="submit" name="add_item" class="modal-btn">Add</button>
    <button type="button" class="modal-btn" onclick="document.getElementById('addModal').style.display='none'">Cancel</button>
  </div>
</form>

<!-- Edit Modal -->
<form method="POST">
  <div id="editModal">
    <h3>Edit Item</h3>
    <input type="hidden" name="edit_id" id="edit_id">
    <input type="text" name="edit_pname" id="edit_pname" required>
    <textarea name="edit_description" id="edit_description" required></textarea>
    <input type="text" name="edit_category" id="edit_category" required>
    <input type="number" name="edit_price" id="edit_price" required>
    <input type="email" name="edit_donarmail" id="edit_donarmail" required>
    <select name="edit_status" id="edit_status" required>
      <option value="Pending">Pending</option>
      <option value="Approved">Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
    <button type="submit" name="update_item" class="modal-btn">Update</button>
    <button type="button" class="modal-btn" onclick="document.getElementById('editModal').style.display='none'">Cancel</button>
  </div>
</form>

<script>
  function editItem(item) {
    document.getElementById('edit_id').value = item.id;
    document.getElementById('edit_pname').value = item.pname;
    document.getElementById('edit_description').value = item.description;
    document.getElementById('edit_category').value = item.category;
    document.getElementById('edit_price').value = item.price;
    document.getElementById('edit_donarmail').value = item.donarmail;
    document.getElementById('edit_status').value = item.status;
    document.getElementById('editModal').style.display = 'block';
  }
</script>

</body>
</html>
