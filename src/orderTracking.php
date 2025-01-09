<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Order Tracking</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/orderTracking.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div id="searchbar">
            <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
            <input type="text" placeholder="search">
        </div>

        <div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="mens.php">Men's</a></li>
                    <li><a href="womens.php">Women's</a></li>
                </ul>
            </nav>
        </div>

        <div>
            <ul id="iconbar">
                <li><a href="profile.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="orderTracking.php"><i class="fa-solid fa-box"></i></a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </header>

    <div id="wrapper">
        <h2><i class="fa-solid fa-box"></i>  ORDER TRACKING</h2>

        <form method="POST" action="orderTracking.php" id="orderForm">
            <div class="tabs">
                <button id="all-btn" type="submit" name="orderStatus" value="all">ALL</button>
                <button type="submit" name="orderStatus" value="paid">PAID</button>
                <button type="submit" name="orderStatus" value="shipped">SHIPPED</button>
                <button type="submit" name="orderStatus" value="delivery">OUT FOR DELIVERY</button>
                <button id="received-btn" type="submit" name="orderStatus" value="received">RECEIVED</button>
            </div>
        </form>

        <div class="orders">
            <?php
                include './utils/loginStatus.php';
                include './utils/errorLogger.php';

                $logger = new ErrorLogger();

                // Connect to the database
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                if ($db->connect_errno) {
                    $logger->logError(''. $db->connect_error);
                    echo "Error loading contents. Please try again later.";
                }

                // Get customerId from session
                $customerId = $_SESSION['customerId'];
                $orderStatus;
                $query;

                // Check if the request method is POST
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get the orderStatus from POST data
                    $orderStatus = $_POST['orderStatus'];
                } else {
                    $orderStatus = 'all';
                }

                // Prepare the query based on the order status
                if ($orderStatus === 'all') {
                    $query = "SELECT * FROM orders WHERE customerId = ?";
                } else {
                    $query = "SELECT * FROM orders WHERE customerId = ? AND orderStatus = ?";
                }

                // Prepare and bind the statement
                $stmt = $db->prepare($query);
                if ($orderStatus === 'all') {
                    $stmt->bind_param("s", $customerId); // Bind customerId only
                } else {
                    $stmt->bind_param("ss", $customerId, $orderStatus); // Bind both customerId and orderStatus
                }

                // Execute the query
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if there are results and display them
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<pre>";
                        print_r($row); // Display each order's data
                        echo "</pre>";

                        $quantity = $row['quantity'];
                        $price = $row['price'] ?? 0; // Use price from the row if available
                        $subtotal = $quantity * $price;

                        echo '<div class="orderItem">';
                        echo '<img src="' . htmlspecialchars($row['productImage']) . '" alt="Product Image" class="order-image">';
                        
                        echo '<div class="orderDetails">';
                        echo '<div class="orderInfo">';
                        echo '<h3>' . htmlspecialchars($row['productName']) . '</h3>';
                        echo '<p>' . htmlspecialchars($row['descrip']) . '</p>';
                        echo '<p>Quantity: ' . htmlspecialchars($quantity) . '</p>';
                        echo '</div>';
                        echo '<div class="orderPrice">$' . number_format($subtotal, 2) . '</div>';
                        echo '</div>'; // Close order-details
                        
                        echo '<hr class="order-divider">';
                        
                        echo '<div class="orderStatus">';
                        echo '<p>Status: ' . htmlspecialchars($row['orderStatus']) . '</p>';
                        echo '</div>';
                        
                        echo '</div>'; // Close order-item
                    }
                } else {
                    echo "No orders found for the selected status.";
                }

                // Close the statement and the database connection
                $stmt->close();
                $db->close();
            ?>
        </div>
    </div>

    <footer>
        <div class="socialMedia">
            <div class="icon facebook">
            <div class="tooltip">Facebook</div>
                <span><i><i class="fa-brands fa-facebook"></i></i></span>
            </div>
            <div class="icon X">
            <div class="tooltip">X</div>
                <span><i><i class="fa-brands fa-twitter"></i></i></span>
            </div>
            <div class="icon instagram">
            <div class="tooltip">Instagram</div>
                <span><i><i class="fa-brands fa-instagram"></i></i></span>
            </div>
            <div class="icon youtube">
            <div class="tooltip">Youtube</div>
                <span><i><i class="fa-brands fa-youtube"></i></i></span>
            </div>
        </div>
        
        <div>
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>

    </footer>

<script src="../static/js/cart.js"></script>
</body>
</html>