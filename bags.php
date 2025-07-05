<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Categories</title>
    <!-- style css -->
    <link rel="stylesheet" href="css/all categories.css">
    <!-- Remix icon cdn -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />  
</head>

<body>

<!-- Navigation Bar -->
<nav id="navbar">
    <div class="logo">
       <a href="#">Donate<span>Happiness</span></a>
    </div>
    <i class="ri-menu-fill" id="toggle"></i>
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contactus.php">Contact Us</a></li>
    </ul>
</nav>

<!-- Gallery Section -->
<div class="gallery">

<?php
// Database connection
$servername = "localhost";
$username = "root"; // change if needed
$password = ""; // change if needed
$database = "donation";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only Bags category items
$sql = "SELECT id, pname, description, category, image, price FROM items WHERE category='Bag'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="content">';
        echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['pname']) . '">';
        echo '<h2>' . htmlspecialchars($row['pname']) . '</h2>';
        if (!empty($row['description'])) {
            echo '<h5>' . htmlspecialchars($row['description']) . '</h5>';
        }
        echo '<h6>Rs. ' . htmlspecialchars($row['price']) . '</h6>';
        echo '<ul>
                <li><i class="ri-star-fill checked"></i></li>
                <li><i class="ri-star-fill checked"></i></li>
                <li><i class="ri-star-fill checked"></i></li>
                <li><i class="ri-star-fill"></i></li>
              </ul>';
        echo '<button class="buy-1"><a href="ordernow.php?id=' . urlencode($row['id']) . '">Order now</a></button>';
        echo '</div>';
    }
} else {
    echo "<h3>No Bags Found</h3>";
}

$conn->close();
?>

</div>

<!-- Toggle menu script -->
<script>
    const toggle = document.getElementById('toggle');
    const menu = document.querySelector('.menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
</script>

</body>
</html>
