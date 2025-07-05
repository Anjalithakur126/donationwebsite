<?php
session_start();

if (!isset($_SESSION['admin_email'])) {
    header("Location: logadmin.php");
    exit();
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
  <style>
    .hidden {
        display: none;
    }
    .card {
        padding: 20px;
        margin: 10px;
        border: 1px solid #ccc;
        text-align: center;
        background-color: #f4f4f4;
        cursor: pointer;
    }
  </style>
</head>
<body>

    <section id="manage-section" class="manage-section">
      <header>
        <h2>Admin Dashboard</h2>&nbsp;
        <a href="logout.php"><button>Logout</button></a>
      </header>
      <main>
        <div class="card"><a href="manage.php">Manage Donations</a></div>
        <div class="card"><a href="viewusers.php">View Users & donor</a></div>
        <div class="card"><a href="delivery.php">Delivery Requests</a></div>
        <div class="card"><a href="items.php">items</a></div>
        <div class="card"><a href="reports.php">Reports</a></div>
      </main>
    </section>

  <script>
    let isAdminLoggedIn = <?php echo isset($_SESSION['admin_email']) ? 'true' : 'false'; ?>;
    
    if (isAdminLoggedIn) {
        document.getElementById("manage-section").classList.remove("hidden");
    } else {
        window.location.href = "logadmin.php";
    }

  </script>

</body>
</html>
