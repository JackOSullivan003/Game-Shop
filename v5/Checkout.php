<?php
session_start();
include 'classes/Cart.php';
include 'util/Connection.php';

$cart = new Cart();
$cartItems = $cart->getCartItems();
$totalPrice = $cart->getTotalPrice();

//create order from items in cart

?>
<!DOCTYPE html>
<html>
<?php include 'Header.php'; ?>
<body>

<h1>Checkout</h1>

<?php if (isset($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="Home.php">Return to Home</a>
<?php else: ?>

    <h2>Order Summary</h2>
    <ul>
        <?php foreach ($cartItems as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['title']); ?> x <?php echo $item['quantity']; ?>
                - $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
            </li>
        <?php endforeach; ?>
        <P>--------------------- </P>
    </ul>
    <strong>Total: $<?php echo number_format($totalPrice, 2); ?></strong>

    <form method="POST">
        <input type="submit" value="Confirm Purchase">
    </form>

    <br>
    <a href="CartPage.php">Back to Cart</a>

<?php endif; ?>

</body>
</html>