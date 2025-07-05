<?php
session_start();
include("../db_connection.php");

if (!isset($_SESSION['admin_email'])) {
  header("Location: logadmin.php");
  exit();
}

// Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $delete_id = intval($_GET['delete']);
  mysqli_query($conn, "DELETE FROM contact WHERE id = $delete_id");
  header("Location: reports.php");
  exit();
}

// Fetch contact messages
$contact_query = mysqli_query($conn, "SELECT * FROM contact ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reports</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans&family=Hanken+Grotesk&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #737a5d;
      --dark-primary-color: #ffffff;
      --secondary-color: #ccbfa3;
      --text-color: #010816;
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

    header button:hover {
      background-color: #5f654e;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    table th,
    table td {
      padding: 1rem;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    table th {
      background-color: var(--secondary-color);
      font-family: var(--accent-font);
    }

    table tr:hover {
      background-color: #f9f9f9;
      transition: var(--transition);
    }

    .actions button {
      padding: 0.4rem 0.8rem;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
      background-color: #dc3545;
      color: white;
    }

    .actions button:hover {
      background-color: #bd2130;
    }
  </style>
</head>
<body>
  <header>
    <h1>Contact Messages</h1>
    <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
  </header>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($contact_query)): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['message']) ?></td>
          <td class="actions">
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?');">
              <button>Delete</button>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
