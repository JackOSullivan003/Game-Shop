<?php
// Define sample product variables, this is a list of variable names and values for each product 
$products = [
    ["id" => 1, "name" => "Dayz", "price" => "$40.00", "image" => "temp/dayz.jpg", "description" => "DayZ is a hardcore survival game set in a post-apocalyptic world where players must endure threats from infected and hostile survivors. It features two main terrains: Chernarus, a 230 km map inspired by a post-soviet state with hand-crafted environments based on real locations, and Livonia, a dense 163 km landscape that challenges players with new, harsher survival conditions. In both maps, players must rely on their survival instincts, scavenging, and crafting skills to stay alive in an unforgiving world filled with danger at every turn, testing how long they can last in this hostile environment."],
    ["id" => 2, "name" => "Balder's Gate 3", "price" => "$80.00", "image" => "temp/balders_gate_3.jpg", "description" => "Balder's Gate 3 is a D&D video game set in a fantasy world where players control a group of unique characters in search of a cure for a parasite."],
    ["id" => 3, "name" => "Gaming Mouse", "price" => "$30.00", "image" => "temp/mouse.jpg", "description" => ""],
    ["id" => 4, "name" => "Gaming Keyboard", "price" => "$75.00", "image" => "temp/keyboard.jpg", "description" => ""]
];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "games_shop";


// Get product ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Check if product exists
if ($id != 0) {
    //find product with matching id
    $product = array_filter($products, function($product) use ($id) {
        return $product['id'] == $id;
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
            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p>Price: $<?php echo $product['price']; ?></p>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
        </div>
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