<?php
session_start();
include('db_connection.php');

if (isset($_POST['update_address']) && isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $contact = $_POST['contact'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Check if address exists
    $check = $conn->prepare("SELECT email FROM billing_address WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE billing_address SET address=?, zip=?, contact=?, state=?, city=? WHERE email=?");
        $stmt->bind_param("ssssss", $address, $zip, $contact, $state, $city, $email);
    } else {
        $stmt = $conn->prepare("INSERT INTO billing_address (address, zip, contact, state, city, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $address, $zip, $contact, $state, $city, $email);
    }

    $stmt->execute();
    header("Location: userpanel.php");
}
?>
