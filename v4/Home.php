<?php
require_once 'classes/User.php'; // Load the User class


include 'util/Connection.php';
//get conn from Connection.php as a variable 
$conn = Connection::getConnection();

//if user is logged in, set the user in session
session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    //echo user name 
    echo '<p>Hello, '. $user->getUsername(). '</p>';
    
}
else {
    $user = null;
    echo '<p>Hello, Guest!</p>';
}
//if user is not logged in, set the user to null

$productRequest = "SELECT p.product_id, p.product_name, p.price, i.image_id FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id";


$productResult = mysqli_query($conn, $productRequest);

//create array of products from database 
$products = [];
if (mysqli_num_rows($productResult) > 0) {
    while($row = mysqli_fetch_assoc($productResult)) {
        $products[] = $row;
    }
}

// $testQuery = "SELECT * FROM Images";
// $testResult = mysqli_query($conn, $testQuery);
// echo "<p>Total rows in Images: " . mysqli_num_rows($testResult) . "</p>";


$adsRequest = "SELECT * FROM Images WHERE product_id = ''";

$adsResult = mysqli_query($conn, $adsRequest);

if (!$adsResult) {
    die("<p>Query failed: " . mysqli_error($conn) . "</p>");
} else {
    echo "<p>Query succeeded</p>";
}

$debugQuery = "SELECT image_id, product_id, LENGTH(product_id) AS len, ISNULL(product_id) AS is_null FROM Images";
$debugResult = mysqli_query($conn, $debugQuery);
while ($row = mysqli_fetch_assoc($debugResult)) {
    echo "<pre>" . print_r($row, true) . "</pre>";
}

$ads = [];
if (mysqli_num_rows($adsResult) > 0) {
    while ($row = mysqli_fetch_assoc($adsResult)) {
        $ads[] = $row;
    }
} else {
    echo "ad array is empty";
}

echo json_encode($ads);

//close connection
$conn->close();

?>
 
 <!DOCTYPE html>
 <html>
     <?php include'Header.php';?>
     <link rel="stylesheet" href="css/Home.css" type="text/css">
    <section class="ad-container">
        <script src="js/adBanner.js"></script>
        <div class="slider">
            <?php foreach ($ads as $ad): ?>
                <img src="util/display_image.php?image_id=<?=$ad['image_id'] ?>" class='ad' alt="Advertisement">
                <?php endforeach; ?>
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </section>
        
        <!--section for products display-->
    <section class= "products-section">
        <h2>Featured Products</h2>
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <?php foreach ($products as $product): ?>
            <div class="product">
                <a href="ProductPage.php?id=<?= $product['product_id']; ?>" >
                <img src="util/display_image.php?image_id=<?= $product['image_id']; ?>">
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