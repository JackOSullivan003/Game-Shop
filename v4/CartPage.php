<?php
include 'Cart.php';

if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $productId = $_GET['id'];
    $cart = new Cart();
    $cart->removeProduct($productId);
    header('Location: cartpage.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cart</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
</head>
<body>
<!--basic cart functionality (display products in cart)-->

<!--display cart items-->
<h1>Cart</h1>
<ul>
  <?php session_start();
  $cart = new Cart();
  $cartItems = $cart->getCartItems();

  if (empty($cartItems)) {
    echo "<p>Cart is empty.</p>";
  } else {
    //calculate total price of cart

    foreach ($cartItems as $item) {?>
      <li>
        <a href="ProductPage.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a>
        x <?php echo $item['quantity'];?>
        - $<?php echo $item['price'] * $item['quantity'];?>
        <a href="cartpage.php?action=remove&id=<?php echo $item['id'];?>">Remove</a>
      </li>
    <?php }?>
    <li>Total: $<?php echo $cart->getTotalPrice();?></li>
    <li><a href="checkout.php">Checkout</a></li>
  <?php }?>

  <!-- home buttom -->
   <a href="Home.php">Home</a>
</ul>
</body>
</html>