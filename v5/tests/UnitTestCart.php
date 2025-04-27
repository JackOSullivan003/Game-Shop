<?php
require_once "../classes/Cart.php";
require_once "../classes/User.php";
include "../util/Connection.php";

function assertEquals($expected, $actual, $message) {
    if ($expected === $actual) {
        echo nl2br("[PASS] $message\n");
    } else {
        echo nl2br("[FAIL] $message - Expected: '$expected', Got: '$actual'\n");
    }
}

$cart = new Cart();

$cart->clearCart();

// Test Add Item to Cart
$productRequest = "SELECT p.product_id, p.product_name, p.price, i.image_id FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id";
$statement = $connection->prepare($productRequest);
if($statement->execute()){
    $products = $statement->fetchAll();
}
else {
    echo "error getting products: " + $statement->errorInfo();
}

$cart->addProduct($products[0]);
$cart->addProduct($products[1]);
$items = $cart->getCartItems();

assertEquals(2, count($items), "Test Add Item to Cart");

// Test Update Item Quantity
$cart->addProduct($products[0]);
$items = $cart->getCartItems();
assertEquals(2, $items[1]['quantity'], "Test Update Item Quantity");

// Test Remove Item from Cart
$cart->removeProduct($products[0]['product_id']);
$items = $cart->getCartItems();

assertEquals(1, count($items), "Test Remove Item From Cart");

// Test Add Same Item Increments Quantity
$cart->addProduct($products[2], 1);
$cart->addProduct($products[2], 2);
$items = $cart->getCartItems();

assertEquals(3, $items[3]['quantity'], "Test Add Same Item Increments Quantity");

// test clear cart 
$cart->clearCart(); 
$items = $cart->getCartItems();

assertEquals(0, count($items), "Test Clear Cart");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cart Unit Test</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="Cart Test Results" />
</head>
<body>
  <a href="home.php">Home</a>
</body>
</html>
