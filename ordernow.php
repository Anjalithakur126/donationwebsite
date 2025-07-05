<?php
session_start();
ob_start(); // Prevents any accidental output issues

include("db_connection.php"); // Connects to MySQL

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];

// Check if item ID is provided
if (!isset($_GET['id'])) {
    echo "No item selected!";
    exit();
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM items WHERE id = $id");
$item = mysqli_fetch_assoc($query);

if (!$item) {
    echo "Item not found!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['quantity'], $_POST['price'])) {
        echo "Missing data!";
        exit();
    }

    $quantity = intval($_POST['quantity']);
    $price = intval($_POST['price']);
    $delivery_charge = 100;
    $total_price = ($price * $quantity) + $delivery_charge;

    $item = [
      'item_id'     => $item['id'],
      'item_name'   => $item['pname'],
      'category'    => $item['category'],
      'description' => $item['description'],
      'image'       => $item['image'],
      'email'       => $email,
      'quantity'    => $quantity,
      'price'       => $price,
      'total_price' => $total_price,
      'product_id'  => $item['id'] // for clarity
  ];
  
  // Initialize cart if it doesn't exist
  if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
  }
  
  // Push new item to cart
  $_SESSION['cart'][] = $item;

    echo "<script> window.location.href = 'Billing.php'; </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Now - donateHAPPINESS</title>
  <link rel="stylesheet" href="css/ordernow.css"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<div class="main-container">
  <h2>Order Now</h2>
  <p class="subtext">Everything is free! You only pay a small delivery charge.</p>

  <div class="row">
    <div class="col-25">
      <div class="container">
        <h4>Cart <span class="price"><i class="ri-shopping-cart-line"></i> <b>1</b></span></h4>
        <p><strong><?php echo htmlspecialchars($item['pname']); ?></strong></p>
        <p><?php echo htmlspecialchars($item['description']); ?></p>
        <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" width="100" height="100" />
        <p>Price: Rs.<span id="price"><?php echo $item['price']; ?></span></p>
        <p>Delivery Charges: Rs.<span id="delivery">100</span></p>
        <hr>
        <p>Total Price: Rs.<span id="total_price"><?php echo $item['price'] + 100; ?></span></p>
      </div>
    </div>

    <div class="col-75">
      <div class="container">
        <form method="post">
          <input type="hidden" name="price" id="hidden_price" value="<?php echo $item['price']; ?>">
          <input type="hidden" name="quantity" id="final_quantity" value="1">

          <label for="quantity">Select Quantity:</label>
          <select id="quantity" name="quantity_select">
            <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
          </select>

          <br><br>
          <label>
            <input type="checkbox" name="terms" required />
            I agree to the terms and conditions
          </label>

          <button type="submit" class="btn">Proceed</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const price = parseInt(document.getElementById("price").innerText);
  const delivery = parseInt(document.getElementById("delivery").innerText);
  const quantitySelector = document.getElementById("quantity");
  const totalPriceSpan = document.getElementById("total_price");
  const finalQuantity = document.getElementById("final_quantity");

  function updateTotal() {
    const qty = parseInt(quantitySelector.value);
    const total = (price * qty) + delivery;
    totalPriceSpan.innerText = total;
    finalQuantity.value = qty;
  }

  quantitySelector.addEventListener("change", updateTotal);
  window.onload = updateTotal;
</script>
</body>
</html>
