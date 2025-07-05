<?php
session_start();
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Cart is empty!"; exit;
    // header("Location: index.php"); exit;
}



?>