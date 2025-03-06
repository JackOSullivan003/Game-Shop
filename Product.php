<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "games_shop";



$conn = mysqli_connect($servername, $username, $password, $dbname);

// Get product ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$productRequest = "SELECT p.product_id, p.product_name, p.description, p.price, i.image_url FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id WHERE p.product_id = $id";

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
    <head>
        <title>Game & Shop</title> 
        <!--using font-awesome library to add buttons for the facebook and twitter social media links, this avoids the need for images for them-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
    <header>

        <h1>Welcome to Game & Stop</h1>
        <!--basic nav-bar -->
        <nav>
            <a href="index.php">Home</a> | 
            <a href="#">Contact</a>
        </nav>
    </header>
    
        <!--section for products display-->
    <section class= "products-section">
       
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <div class= "product">
        <?php if ($product): ?>
            <img src="<?= $product['image_url']; ?>" alt="<?= $product['product_name']; ?>">
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p>Price: $<?php echo $product['price']; ?></p>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
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