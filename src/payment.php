<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

include("./utils/loginStatus.php");

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'myStyleLoft');

if ($db->connect_errno) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}

// Fetch user ID
$customerId = $_SESSION['customerId'];
$orderStatus = "Paid";

$query = $db->prepare('INSERT INTO orders (total, orderStatus) VALUE (?, ?)');
$query->bind_param('ss', $_POST['totalPrice'], $orderStatus);
$query->execute();
$orderId = $db->insert_id;
echo $orderId;

$stmt = $db->prepare('INSERT INTO orderedItems (productSize, quantity, subTotal, orderId, productId) VALUE (?, ?, ?, ?, ?)');

$productNames = $_POST['productName'];
$quantities = $_POST['quantity'];
$sizes = $_POST['size'];
$subtotals = $_POST['subtotals'];
$productIds = $_POST['productIds'];


for ($i = 0; $i < sizeof($productIds); $i++) {
    $stmt->bind_param('sssii', $sizes[$i], $quantities[$i], $subtotals[$i], $orderId, $productIds[$i]);
    if ($stmt->execute()) {
        header('Location: orderTracking.php');
    } else {
        // echo "Error loading.";
        echo $stmt->error;
    }
}

$query->close();
$db->close();