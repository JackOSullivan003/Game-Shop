<?php
session_start();
include 'Cart.php';

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
    //different way to do AJAX request since Productpage method wasnt working for some reason
    var request = new XMLHttpRequest();
    request.open('GET', 'CartPage.php?action=remove&id=' + productId, true);
    request.send();
    window.location.reload();  // refresh the page to show the updated cart after removing an item
  }
</script>
<?php include 'Header.php'; ?>
<body>

<h1>Cart</h1>
<ul>
  <?php 
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
        <a href="#" onclick="removeFromCart(<?php echo $item['id'];?>)">Remove</a>
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