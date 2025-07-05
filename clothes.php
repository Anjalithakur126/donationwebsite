<?php
// database connection
$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch clothes category
$sql = "SELECT id, pname, description, category, image, price FROM items WHERE category='Clothes'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothes Category</title>
    <link rel="stylesheet" href="css/all categories.css">
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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <div class="content">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
        <h2><?php echo htmlspecialchars($row['pname']); ?></h2>
        <h5><?php echo htmlspecialchars($row['description']); ?></h5>
        <h6>Rs. <?php echo htmlspecialchars($row['price']); ?></h6>
        <ul>
            <li><i class="ri-star-fill checked"></i></li>
            <li><i class="ri-star-fill checked"></i></li>
            <li><i class="ri-star-fill checked"></i></li>
            <li><i class="ri-star-fill"></i></li>
        </ul>
        <button class="buy-1">
            <a href="ordernow.php?id=<?php echo urlencode($row['id']); ?>">Order Now</a>
        </button>
    </div>
<?php
    }
} else {
    echo "<h3>No Clothes Found</h3>";
}
$conn->close();
?>

</div>

<!-- Toggle Menu Script -->
<script>
    const toggle = document.getElementById('toggle');
    const menu = document.querySelector('.menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
</script>

</body>
</html>
