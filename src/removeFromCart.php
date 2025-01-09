<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    if (mysqli_connect_errno()) {
        echo "Error: Could not connect to the database. Please try again later.";
        exit;
    }

    // Remove the item from the cart
    $query = "DELETE FROM shoppingCart WHERE productId = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();

    // Redirect back to cart page
    header("Location: cart.php");
    exit();
}
?>