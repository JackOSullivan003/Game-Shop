<!DOCTYPE html>
<?php
include 'Connection.php';



//get conn from Connection.php as a variable 
$conn = Connection::getConnection();

session_start();

$productRequest = "SELECT p.product_id, p.product_name, p.price, i.image_id FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id";


$productResult = mysqli_query($conn, $productRequest);

//create array of products from database 

$products = [];
if (mysqli_num_rows($productResult) > 0) {
    while($row = mysqli_fetch_assoc($productResult)) {
        $products[] = $row;
    }
}

$adsRequest = "SELECT * FROM Images WHERE product_id IS NULL";

$adsResult = mysqli_query($conn, $adsRequest);
//create array of ads from database

$ads = [];
if (mysqli_num_rows($adsResult) > 0) {
    while($row = mysqli_fetch_assoc($adsResult)) {
        $ads[] = $row;
    }
}

// echo json_encode($ads);

$conn->close();
?>
 
<html>
    <?php include'Header.php';?>
    <link rel="stylesheet" href="css/Home.css" type="text/css">
    <section class="ad-container">
        <div class="slider">
            <?php foreach ($ads as $ad): ?>
                <img src="display_image.php?image_id=<?=$ad['image_id'] ?>" class='ad' alt="Advertisement">
                <?php endforeach; ?>
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </section>
        <script src="js/adBanner.js"></script>
        
        <!--section for products display-->
    <section class= "products-section">
        <h2>Featured Products</h2>
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <?php foreach ($products as $product): ?>
            <div class="product">
                <a href="product.php?id=<?= $product['product_id']; ?>" >
                <img src="display_image.php?image_id=<?= $product['image_id']; ?>">
                <div class="product-details">
                    <h3 class ="product-title"><?= $product['product_name']; ?></h3>
                    <p class="product-price">Price: <?= $product['price']; ?></p>
                </div>
                </a>
            </div>
        <?php endforeach; ?>
    </section>

    <footer>
        <p>&copy; 2025 Game & Stop</p>
        <!--add social media links-->
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>
</html>