<?php
session_start();
include 'classes/Cart.php';

//handle removeFromCart response 

if (isset($_GET['action'])) {
  $action = $_GET['action'];

  if ($action =='remove') {
    $productId = $_GET['id'];
    $cart = new Cart();
    $cart->removeProduct($productId);
  }
}
?>
<!DOCTYPE html>
<html>
<script>     
  function removeFromCart(productId) {
    window.location.href = window.location.pathname + "?action=remove&id=" + productId;

  }
</script>
<?php include 'Header.php'; ?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/cartpage.css" type="text/css">
<body>
  <div class='cart'>
  <h1>Cart</h1>
  <?php 
  $cart = new Cart();
  $cartItems = $cart->getCartItems();

  if (empty($cartItems)) {
    echo "<p>Cart is empty.</p>";
  } else {
    //calculate total price of cart

    foreach ($cartItems as $item) {?>
        <a href="ProductPage.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a> x <?php echo $item['quantity'];?> - $<?php echo $item['price'] * $item['quantity'];?>
        <a href="#" onclick="removeFromCart(<?= $item['id'] ?>)">Remove</a>
    <?php }?>
    <P>--------------------- </P>
    Total: $<?php echo $cart->getTotalPrice();?> <br><br>
    <a href="checkout.php">Proceed To Checkout</a><br><br>
  <?php }?>

  <!-- home buttom -->
   <a href="Home.php">Home</a>
  </div>
</body>
<?php include 'Footer.php'; ?>
</html>