<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "games_shop";

session_start();

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}
else {
    echo "Connection successful.";
}

$productRequest = "SELECT p.product_id, p.product_name, p.price, i.image_url FROM Products p LEFT JOIN Images i ON p.product_id = i.product_id";


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

// Check if random products are already stored in the session
if (!isset($_SESSION['random_products'])) {
    shuffle($products); // Shuffle the array
    $_SESSION['random_products'] = array_slice($products, 0, 4); // Store 4 random products
}

$randomProducts = $_SESSION['random_products'];

$conn->close();
?>
 
<!DOCTYPE html>
<html>
    <!--include header.php file-->
<?php include'Header.php';?>

    <section class="ad-container">
        <div class="slider">
            <?php foreach ($ads as $ad): ?>
                <img src="<?= $ad['image_url']; ?>" class='ad' alt="Advertisement">
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
        <?php foreach ($randomProducts as $product): ?>
            <div class="product">
                <a href="product.php?id=<?= $product['product_id']; ?>" >
                <img src="<?= $product['image_url']; ?>">
                <div class="product-details">
                    <h3><?= $product['product_name']; ?></h3>
                    <p>Price: <?= $product['price']; ?></p>
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
    </footer>


    </body>
</html>