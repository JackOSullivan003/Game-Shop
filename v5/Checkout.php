<?php
include 'classes/Cart.php';
include 'classes/User.php';
include 'util/Connection.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
    $msg = "<p style='color:red;'>You must be logged in to create a listing.</p>";
    echo $msg;
    exit;
}

$cart = new Cart();
$cartItems = $cart->getCartItems();
$totalPrice = $cart->getTotalPrice();

//create order from items in cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart->getCartItems())) {
        $message = "Your cart is empty. Cannot proceed to checkout.";
    } else {
        $shippingAddress = "";
        if($_POST["useAccountAddress"]){
            $shippingAddress = $_SESSION['user']->getAddress();
        }
        else {

        }
        $connection->beginTransaction();
        try {
            $stmt = $connection->prepare("INSERT INTO Orders (user_id, info, total_amount, shipping_address) 
                                   VALUES (:user_id, :info, :total_amount, :shipping_address)");

            $orderInfo = json_encode($cartItems);

            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':info' => $orderInfo,
                ':total_amount' => $totalPrice,
                ':shipping_address' => $shippingAddress
            ]);

            foreach ($cartItems as $item) {
                $stmt = $connection->prepare("UPDATE Products 
                                       SET quantity = quantity - :quantity 
                                       WHERE product_id = :id AND quantity >= :quantity");
                $stmt->execute([
                    ':quantity' => $item['quantity'],
                    ':id' => $item['id']
                ]);
            }
            
            $connection->commit();
            $cart->clearCart(); // clear cart after placing order
            $message = "Thank you for your purchase! Your order has been placed.";

        } catch (PDOException $e) {
            $connection->rollBack();
            $message = "Checkout failed: " . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html>
<?php include 'Header.php'; ?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/checkout.css" type="text/css">

<body>

<div class = "checkout">
<h1>Checkout</h1>

<?php if (isset($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="Home.php">Return to Home</a>
<?php else: ?>

    <h2>Order Summary</h2>

            <?php foreach ($cartItems as $item): ?>
                <p><?php echo htmlspecialchars($item['title']); ?> x <?php echo $item['quantity']; ?> - $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
            <?php endforeach; ?>
        <P>--------------------- </P>
        <strong>Total: $<?php echo number_format($totalPrice, 2); ?></strong>
        
        <form method="POST">
            
            <label for="useAccountAddress">Use Account Address as Shipping Address: </label>
            <input type="checkbox" id="useAccountAddress" name="useAccountAddress" checked=true value="Use Account Address as Shipping Address" onchange="toggleShippingAddress()"><br>
            <label for="shippingAddress">Shipping Address:</label><br>
            <textarea id="shippingAddress" name="shippingAddress" rows="4" cols="50" required></textarea>
            <br><br>
            <input type="submit" value="Confirm Purchase">
        </form>
        
        <script>
            function toggleShippingAddress() {
                var checkbox = document.getElementById('useAccountAddress');
                var addressField = document.getElementById('shippingAddress');
            
                if (checkbox.checked) {
                    addressField.disabled = true;
                    addressField.required = false; // make it NOT required if using account address
                } else {
                    addressField.disabled = false;
                    addressField.required = true;  // must fill if not using account address
                }
            }
            toggleShippingAddress();
        </script>


        <br>
        <a href="CartPage.php">Back to Cart</a>
        
        <?php endif; ?>
</div>
        
</body>
<?php include 'Footer.php'; ?>
</html>