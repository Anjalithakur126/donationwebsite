<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'donation');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['Categories'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $donormail = $_POST['donormail'];  // Get the donor email
    $target = "uploads/" . basename($image);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO items (pname, description, category, image, price, donarmail) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $description, $category, $image, $price, $donormail);  // Add donormail as a parameter

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error adding product'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donateHAPPINESS</title>
    <link rel="stylesheet" href="css/donate.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h1>Add Your Product</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="Categories">Categories:</label>
            <select name="Categories" id="categories">
                <option value="Furniture">Furniture</option>
                <option value="Stationery">Stationery</option>
                <option value="Books">Books</option>
                <option value="Clothes">Clothes</option>
                <option value="Bag">Bags</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <!-- New Donor Email input -->
            <label for="donormail">Your Email (Donor):</label>
            <input type="email" id="donormail" name="donormail" required>
            <br><br>
            <button type="submit">Post Now</button>
        </form>
    </div>
</body>

</html>
