<?php
include 'Connection.php';



//get conn from Connection.php as a variable 
$conn = Connection::getConnection();

// Get product ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$productRequest = "SELECT product_id, product_name, description, price FROM Products WHERE product_id = $id";

$productResult = mysqli_query($conn, $productRequest);

//create array of products from database 

$products = [];
if (mysqli_num_rows($productResult) > 0) {
    while($row = mysqli_fetch_assoc($productResult)) {
        $products[] = $row;
    }
}

// Check if product exists
if ($id != 0) {
    //find product with matching id
    $product = array_filter($products, function($product) use ($id) {
        return $product['product_id'] == $id;
    });
    $product = reset($product); // Get the first (and only) product from the filtered array

} else {
    $product = null;
}

?>

<!DOCTYPE html>
<html>
    <?php include 'Header.php'; ?>
    <link rel="stylesheet" href="css/product.css" type="text/css">
        <!--section for products display-->
    <section class= "products-section">
       
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <div class= "product">
        <?php if ($product): ?>
            <img src="display_image.php?image_id=<?= $product['product_id']; ?>">
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p>Price: $<?php echo $product['price']; ?></p>
            <div class="product-details">
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            </div>
            <button class="buy-button">Buy Now</button>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
        </div>
    </section>

    <!--use review.php as template-->
    <?php include'Review.php';?>

    <footer>
        <p>&copy; 2025 Game & Stop</p>
        <!--add social media links-->
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>
    </footer>


    </body>
</html>