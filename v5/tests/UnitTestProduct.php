<?php
require_once "../classes/Product.php"; // Make sure path to Product class is correct

// Function to check test results
function assertEquals($expected, $actual, $message) {
    if ($expected === $actual) {
        echo nl2br("[PASS] $message\n");
    } else {
        echo nl2br("[FAIL] $message - Expected: '$expected', Got: '$actual'\n");
    }
}

// Create a new Product and test getters and setters
$product = new Product(1, "Test Product", "This is a test product.", "Test Genre", "new", 19.99, "test_image.jpg");

// Test getting ID
assertEquals(1, $product->getId(), "Test getting product ID");

// Test setting ID
$product->setId(2);
assertEquals(2, $product->getId(), "Test setting product ID");

// Test getting Title
assertEquals("Test Product", $product->getTitle(), "Test getting product title");

// Test setting Title
$product->setTitle("New Product Title");
assertEquals("New Product Title", $product->getTitle(), "Test setting product title");

// Test getting Description
assertEquals("This is a test product.", $product->getDescription(), "Test getting product description");

// Test setting Description
$product->setDescription("Updated product description.");
assertEquals("Updated product description.", $product->getDescription(), "Test setting product description");

// Test getting Price
assertEquals(19.99, $product->getPrice(), "Test getting product price");

// Test setting Price
$product->setPrice(29.99);
assertEquals(29.99, $product->getPrice(), "Test setting product price");

// Test setting invalid price (negative)
$priceTest = $product->setPrice(-5); // Should throw exception or handle error
if($priceTest){
    echo "[FAIL] Test failed: Negative price\n";
}
else {
    echo "[PASS] Test passed: Negative price correctly handled";
}

// Test getting Image
assertEquals("test_image.jpg", $product->getImage(), "Test getting product image");

// Test setting Image
$product->setImage("new_image.jpg");
assertEquals("new_image.jpg", $product->getImage(), "Test setting product image");


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product Unit Test</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="Unit Test for Product Class" />
</head>
<body>

<a href=".">Back</a>

</body>
</html>