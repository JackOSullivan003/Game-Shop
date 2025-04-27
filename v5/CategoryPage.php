<?php
require_once 'classes/User.php'; // Load the User class
include 'util/Connection.php';

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

if (isset($_GET['category_id'])) {
    $productRequest = "
        SELECT 
        p.product_id, 
        p.product_name, 
        p.price, 
        p.conditions, 
        i.image_id,
        c.category_id,
        c.category_name
        FROM Products p
        LEFT JOIN Images i ON p.product_id = i.product_id
        INNER JOIN Categories c ON p.category_id = c.category_id
        WHERE p.category_id = :category_id";
    
    $statement = $connection->prepare($productRequest);
    $statement->execute([':category_id' => (int)$_GET['category_id']]); // cast to int to prevent abuse
    
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include'Header.php';?>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<?php if (count($products) > 0): ?>
    <h1>Category: <?= htmlspecialchars($products[0]['category_name']); ?></h1>
    <?php foreach ($products as $product): ?>
        <div class="product">
            <a href="ProductPage.php?id=<?= htmlspecialchars($product['product_id']); ?>">
                <img src="util/display_image.php?image_id=<?= htmlspecialchars($product['image_id']); ?>" alt="Product Image">
                <div class="product-details">
                    <h3 class="product-title">
                        <?= htmlspecialchars($product['product_name']); ?>
                        <?php if ($product['conditions'] === 'used'): ?>
                            - USED
                        <?php endif; ?>
                    </h3>
                    <p class="product-price">Price: <?= htmlspecialchars($product['price']); ?></p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>This category is empty.</p>
<?php endif; ?>
</body>
<?php include'Footer.php';?>
</html>