<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "games_shop";



$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}
else {
    echo "Connection successful.";
}


$sql = "SELECT product_id, product_name, product_image, price FROM products";

$result = mysqli_query($conn, $sql);

//create array of products from database 

$products = [];
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
echo json_encode($products);


$conn->close();
?>
 

<!DOCTYPE html>
<html>
    <head>
        <title>Game & Shop</title> 
    <!--basic css -->
        <style> 
            body {
                background-color: grey;
                font-family: Arial, sans-serif; 
                text-align: center; 
            }
            header {
                background-color: lightgrey;
            }

            nav {
                display: flex;
                justify-content: space-around;
                background-color: white;
            }
            .product { 
                display: inline-block; 
                background-color: white; 
                margin: 20px; 
                width: 200px;
                height: 300px;
                padding: 10px; 
                border: 1px solid #ccc; 
                vertical-align: middle;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                cursor: pointer;

            }
            .products-section {
                background-color: lightgrey; 
            }
            .product:hover {
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            }
            .product .product-details {
                width: 180px;
                height: 80px;
                background-color: lightgrey;
                display: inline-block;
            }
            .product img { 
                width: 150px; 
                height: 200px; 
                object-fit: contain;
            }
            .product h3 {
                margin: 0;
                font-size: 22px;
                line-height: 1.5;
                font-weight: bold;

            }
            .product p {
                margin: 10px;
                font-size: 16px;
            }

            footer {
                background-color: lightgrey;
                padding: 10px;
                text-align: center;
            }
            /*style for social media links*/
            a.social-media-link {
                color: black;
                text-decoration: none;
                padding: 5px;
                font-size: 20px;
            }
            a.social-media-link:hover {
                color: blue;
            }
        </style>
        <!--using font-awesome library to add buttons for the facebook and twitter social media links, this avoids the need for images for them-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    </head>
    <body>
    <header>

        <h1>Welcome to Game & Stop</h1>
        <!--basic nav-bar -->
        <nav>
            <a href="index.php">Home</a> | 
            <a href="index.php"></a> | 
            <a href="#">Contact</a> 
        </nav>
    </header>
    
        <!--section for products display-->
    <section class= "products-section">
        <h2>Featured Products</h2>
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <?php foreach ($products as $product): ?>
            <div class="product">
                <a href="product.php?id=<?= $product['product_id']; ?>" >
                <img src="display.php?id=<?= $product['product_id']; ?>">
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