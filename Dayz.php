<?php
// Define sample product variables, this is a list of variable names and values for each product 
$products = [
    ["name" => "Dayz", "price" => "$40.00", "image" => "temp/dayz.jpg", "description" => "DayZ is a hardcore survival game set in a post-apocalyptic world where players must endure threats from infected and hostile survivors. It features two main terrains: Chernarus, a 230 km map inspired by a post-soviet state with hand-crafted environments based on real locations, and Livonia, a dense 163 km landscape that challenges players with new, harsher survival conditions. In both maps, players must rely on their survival instincts, scavenging, and crafting skills to stay alive in an unforgiving world filled with danger at every turn, testing how long they can last in this hostile environment."]
   
];
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
                margin: 50px; 
                width: 500px;
                height: 600px;
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
            
            .product a {
                height: 10px;
                margin: 50px;
                font-size: 12px;
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
            <a href="#">Contact</a>
        </nav>
    </header>
    
        <!--section for products display-->
    <section class= "products-section">
       
        <!--displaying products stored in products variable using a PHP foreach loop-->
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                <div class="product-details">
                    <h3><?= $product['name']; ?></h3>
                    <p>Price: <?= $product['price']; ?></p>
                    <a>Description: <?= $product['description']; ?></a>
                </div>
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