<?php
require_once "../classes/Cart.php";
require_once "../classes/User.php";
include "../util/Connection.php";

$conn = Connection::getConnection();

function assertEquals($expected, $actual, $message) {
    if ($expected === $actual) {
        echo nl2br("[PASS] $message\n");
    } else {
        echo nl2br("[FAIL] $message - Expected: '$expected', Got: '$actual'\n");
    }
}

session_start();
$user = new User();
$_SESSION['user'] = $user;

$cart = new Cart();

// Test Add Item to Cart
$productRequest = "SELECT p.product_id, p.product_name, p.price, i.image_id 
                   FROM Products p 
                   LEFT JOIN Images i ON p.product_id = i.product_id";
$productResult = mysqli_query($conn, $productRequest);

$products = [];
if (mysqli_num_rows($productResult) > 0) {
    while($row = mysqli_fetch_assoc($productResult)) {
        $products[] = $row;
    }
}

$cart->addItem($products[0]['product_id'], $products[0]['product_name'], "new", $products[0]['price'], 1);
$cart->addItem($products[1]['product_id'], $products[1]['product_name'], "used", $products[1]['price'], 1);
$items = $cart->getItems();

assertEquals(2, count($items), "Test Add Item to Cart");
assertEquals("new", $items[$products[0]['product_id']]['type'], "Test Add New Item Type");
assertEquals("used", $items[$products[1]['product_id']]['type'], "Test Add Used Item Type");

// Test Update Item Quantity
$cart->addItem(1, "Dayz", "new", 80.00, 1);
$cart->updateItem(1, 5);
$items = $cart->getItems();

assertEquals(5, $items[1]['quantity'], "Test Update Item Quantity");

// Test Remove Item from Cart
$cart->addItem(1, "Dayz", "new", 80.00, 1);
$cart->removeItem(1);
$items = $cart->getItems();

assertEquals(0, count($items), "Test Remove Item From Cart");

// Test Add Same Item Increments Quantity
$cart->addItem(3, "Gaming Mouse", "used", 30.00, 1);
$cart->addItem(3, "Gaming Mouse", "used", 30.00, 2);
$items = $cart->getItems();

assertEquals(3, $items[3]['quantity'], "Test Add Same Item Increments Quantity");

$conn->close();
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
