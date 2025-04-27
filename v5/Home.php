<?php
require_once 'classes/User.php'; // Load the User class
include 'util/Connection.php';

//if user is logged in, set the user in session
session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    //echo user name 
    echo '<p>Hello, '. $user->getUsername(). '</p>';
    
}
else {
    //if user is not logged in, set the user to null
    $user = null;
    echo '<p>Hello, Guest!</p>';
}

$productRequest = "SELECT p.product_id, p.product_name, p.price, p.conditions, i.image_id FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id";

$statement = $connection->prepare($productRequest);
if($statement->execute()){
    $productResult = $statement->fetchAll();
}
else {
    echo "error getting products: " + $statement->errorInfo();
}
$adsRequest = "SELECT * FROM Images WHERE product_id is null";
$statement = $connection->prepare($adsRequest);
$statement->execute();
$adsResult = $statement->fetchAll();


echo json_encode($adsResult);
?>
 
 <!DOCTYPE html>
 <html>
     <?php include'Header.php';?>
     <link rel="stylesheet" href="css/style.css" type="text/css">
     <link rel="stylesheet" href="css/Home.css" type="text/css">
    <section class="ad-container">
        <div class="slider">
            <?php foreach ($adsResult as $ad): ?>
                <img src="util/display_image.php?image_id=<?=$ad['image_id'] ?>" class='ad' alt="Advertisement">
                <?php endforeach; ?>
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
            <script src="js/adBanner.js"></script>
    </section>
        
        <!--section for products display-->
    <section class= "products-section">
        <h2>Products</h2>
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <?php foreach ($productResult as $product): ?>
            <div class="product">
                <a href="ProductPage.php?id=<?= $product['product_id']; ?>" >
                <img src="util/display_image.php?image_id=<?= $product['image_id']; ?>">
                <div class="product-details">
                    <h3 class ="product-title"><?= $product['product_name']; if($product['conditions'] === 'used'): echo " - USED"; endif;?></h3>
                    <p class="product-price">Price: <?= $product['price']; ?></p>
                </div>
                </a>
            </div>
        <?php endforeach; ?>
    </section>

    <?php include'Footer.php';?>
</html>