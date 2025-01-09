<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Order Management</title>
<link rel="stylesheet" href="../static/css/adminPanelGeneral.css">
<link rel="stylesheet" href="../static/css/orderManagement.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
        <h2>ADMIN PANEL</h2>
    </header>


    <div id="wrapper">
        <div id="leftColumn">
            <nav>
                <ul>
                    <li><a href="productManagement.php">
                        <i class="fa-solid fa-shirt"></i>Product Management</a></li>
                    <li><a href="orderManagement.php" class="active">
                        <i class="fa-solid fa-list-check"></i> Order Management</a></li>
                    <li><a href="uploadNew.php">
                        <i class="fa-solid fa-square-plus"></i> Upload New Product</a></li>
                </ul>
            </nav>
        </div>

        <div id="rightColumn">
            <h2><i class="fa-solid fa-list-check"></i> Order Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order Date</th>
                        <th>Customer</th>
                        <th>Order ID</th>
                        <th>Item(s)</th>
                        <th>Total Price</th>
                        <th>Receiver</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php   
                // connect database
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                
                if (mysqli_connect_errno()) {
                    echo "Error: Could not connect to the database. Please try again later.";
                    exit;
                }

                // retrieve all products data from database
                $query = "SELECT
                            o.orderDate AS 'Order Date',
                            CONCAT(u.firstName, ' ', u.lastName) AS 'Customer',
                            o.orderId AS 'Order ID',
                            GROUP_CONCAT(CONCAT(p.productName, ' (Size: ', oi.productSize, +', Quantity: ', oi.quantity, ')') SEPARATOR ', ') AS 'Item(s)',
                            o.total AS 'Total Price',
                            s.receiverName AS 'Receiver',
                            s.shippingAddress AS 'Shipping Address',
                            o.orderStatus AS 'Status'
                            FROM orders o
                            JOIN users u ON o.customerId = u.customerId
                            JOIN orderedItems oi ON o.orderId = oi.orderId
                            JOIN products p ON oi.productId = p.productId
                            JOIN shipping s ON o.orderId = s.orderId
                            GROUP BY o.orderId, u.customerId, s.receiverName, s.shippingAddress
                            ORDER BY o.orderDate DESC";

                $result = $db->query($query);
            
                if ($result) {
                    while ($row = $result->fetch_assoc()) {  
                        echo "<tr>";
                        echo '<td>'. htmlspecialchars($row['Order Date']) .'</td>';
                        echo '<td>' . htmlspecialchars($row['Customer']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Order ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Item(s)']) . '</td>';
                        echo '<td>$' . number_format($row['Total Price'], 2) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Receiver']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Shipping Address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Status']) . '</td>';
                        echo '<td><select type="select" id="status" onclick="updateStatus.php">
                                    <option value="shipped">Shipped</option>
                                    <option value="outForDelivery">Out for Delivery</option>
                                    <option value="delivered">Delivered</option>
                                    </select></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found.</td></tr>";
                }
            
                $db->close();
                ?>
                
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <div>
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>
    </footer>
</body>
</html>