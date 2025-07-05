<?php
session_start();
include("../db_connection.php");

if (!isset($_SESSION['admin_email'])) {
    header("Location: logadmin.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = ($_GET['action'] === 'approve') ? 'Approved' : 'Rejected';
    mysqli_query($conn, "UPDATE items SET status = '$status' WHERE id = $id");
    header("Location: manage.php");
    exit();
}

if (isset($_POST['update_item'])) {
    $id = intval($_POST['edit_id']);
    $pname = $_POST['edit_pname'];
    $category = $_POST['edit_category'];
    $donarmail = $_POST['edit_donarmail'];
    $status = $_POST['edit_status'];

    mysqli_query($conn, "UPDATE items SET pname='$pname', category='$category', donarmail='$donarmail', status='$status' WHERE id=$id");
    header("Location: manage.php");
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

    header h1 {
      font-family: var(--accent-font);
      color: var(--primary-color);
    }
    header button {
      padding: 0.6rem 1.2rem;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: var(--transition);
    }


    .donation-table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .donation-table th, .donation-table td {
      padding: 1rem;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    .donation-table th {
      background-color: var(--secondary-color);
      font-family: var(--accent-font);
    }

    .donation-table tr:hover {
      background-color: #f7f7f7;
      transition: var(--transition);
    }

    .actions button {
      padding: 0.4rem 0.8rem;
      margin-right: 0.5rem;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .approve { background-color: #4caf50; color: white; }
    .reject { background-color: #e53935; color: white; }
    .edit   { background-color: #0277bd; color: white; }

    /* Modal styles */
    #editModal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      padding: 20px 30px;
    }

    #editModal h3 {
      margin-bottom: 15px;
      color: var(--primary-color);
      font-family: var(--accent-font);
    }

    #editModal label {
      display: block;
      margin-bottom: 10px;
    }

    #editModal input, #editModal select {
      width: 100%;
      padding: 8px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    #editModal button {
      margin-top: 15px;
      margin-right: 10px;
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      cursor: pointer;
    }

    #editModal .update-btn { background-color: #4caf50; color: white; }
    #editModal .cancel-btn { background-color: #e53935; color: white; }
  </style>
</head>
<body>
  <header>
    <h1>Manage Donations</h1>
    <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
  </header>

  <table class="donation-table">
    <thead>
      <tr>
        <th>Item</th>
        <th>Category</th>
        <th>Donor</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['pname']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
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
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Edit Modal -->
  <form method="POST">
    <div id="editModal">
      <h3>Edit Donation Item</h3>
      <input type="hidden" name="edit_id" id="edit_id">
      <label>Item Name:
        <input type="text" name="edit_pname" id="edit_pname" required>
      </label>
      <label>Category:
        <input type="text" name="edit_category" id="edit_category" required>
      </label>
      <label>Donor Email:
        <input type="email" name="edit_donarmail" id="edit_donarmail" required>
      </label>
      <label>Status:
        <select name="edit_status" id="edit_status" required>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
        </select>
      </label>
      <button type="submit" name="update_item" class="update-btn">Update</button>
      <button type="button" class="cancel-btn" onclick="document.getElementById('editModal').style.display='none'">Cancel</button>
    </div>
  </form>

  <script>
    function editItem(item) {
      document.getElementById('edit_id').value = item.id;
      document.getElementById('edit_pname').value = item.pname;
      document.getElementById('edit_category').value = item.category;
      document.getElementById('edit_donarmail').value = item.donarmail;
      document.getElementById('edit_status').value = item.status;
      document.getElementById('editModal').style.display = 'block';
    }
  </script>
</body>
</html>
