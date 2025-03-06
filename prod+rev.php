<?php
// Define sample product variables
$products = [
    ["id" => 1, "name" => "Dayz", "price" => "$40.00", "image" => "temp/dayz.jpg", "description" => "DayZ is a hardcore survival game set in a post-apocalyptic world..."],
    ["id" => 2, "name" => "Balder's Gate 3", "price" => "$80.00", "image" => "temp/balders_gate_3.jpg", "description" => "Balder's Gate 3 is a D&D video game..."],
    ["id" => 3, "name" => "Gaming Mouse", "price" => "$30.00", "image" => "temp/mouse.jpg", "description" => ""],
    ["id" => 4, "name" => "Gaming Keyboard", "price" => "$75.00", "image" => "temp/keyboard.jpg", "description" => ""]
];

// Get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if product exists
$product = null;
foreach ($products as $p) {
    if ($p['id'] == $id) {
        $product = $p;
        break;
    }
}

// Reviews section with ratings
$reviews = [
    ["username" => "PlayerOne", "review" => "Amazing game! The graphics are top-notch and the storyline is captivating.", "rating" => 5],
    ["username" => "GamerX", "review" => "A bit repetitive, but still enjoyable. Worth the playthrough.", "rating" => 3],
    ["username" => "EpicGamer", "review" => "Not my favorite game, but has a great multiplayer mode.", "rating" => 4],
];

// Handle new review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review_text']) && isset($_POST['rating'])) {
    $newReview = $_POST['review_text'];
    $rating = (int) $_POST['rating']; // Capture the rating
    $username = "Guest"; // Default username for now
    $reviews[] = ["username" => $username, "review" => $newReview, "rating" => $rating]; // Save rating and review
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product & Reviews</title>
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { background-color: #f2f2f2; font-family: Arial, sans-serif; text-align: center; }
        header { background-color: lightgrey; padding: 20px; }
        nav { display: flex; justify-content: space-around; background-color: white; padding: 10px; }
        .product-section, .review-section { background-color: white; width: 600px; margin: 20px auto; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        .reviews-container { margin-top: 20px; text-align: left; }
        .review { margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .review-form textarea { width: 100%; height: 100px; padding: 10px; margin-top: 10px; font-size: 16px; }
        .review-form input[type="submit"] { padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .checked { color: orange; }
        .stars { cursor: pointer; }
    </style>
    <script>
        // JavaScript function to handle star selection
        function selectRating(rating) {
            // Get all stars and reset their color
            const stars = document.querySelectorAll('.stars .fa');
            stars.forEach((star, index) => {
                star.classList.remove('checked'); // Remove checked class
                if (index < rating) { // Add checked class up to the clicked star
                    star.classList.add('checked');
                }
            });
            // Set the hidden input value to the selected rating
            document.getElementById('rating').value = rating;
        }
    </script>
</head>
<body>
    <header>
        <h1>Game & Stop</h1>
        <nav>
            <a href="index.php">Home</a> | <a href="#">Contact</a> | <a href="reviews.php">Reviews</a>
        </nav>
    </header>

    <!-- Product Details Section -->
    <section class="product-section">
        <h2>Product Details</h2>
        <?php if ($product): ?>
            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" style="width:100%; height:auto;">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p>Price: <?= $product['price']; ?></p>
            <p><?= htmlspecialchars($product['description']); ?></p>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </section>

    <!-- Reviews Section -->
    <section class="review-section">
        <h3>Game Reviews</h3>
        <div class="reviews-container">
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong><?= $review['username']; ?>:</strong> <?= $review['review']; ?></p>
                    <!-- Star Rating Display -->
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="fa fa-star <?= $i <= $review['rating'] ? 'checked' : ''; ?>"></span>
                    <?php endfor; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Submit Review Section -->
    <section class="review-section">
        <h3>Submit Your Review</h3>
        <form action="reviews.php?id=<?= $id; ?>" method="post" class="review-form">
            <textarea name="review_text" required placeholder="Write your review here..."></textarea><br>

            <!-- Star Rating Input -->
            <div class="stars">
                <!-- Stars to click for rating -->
                <span class="fa fa-star" onclick="selectRating(1)"></span>
                <span class="fa fa-star" onclick="selectRating(2)"></span>
                <span class="fa fa-star" onclick="selectRating(3)"></span>
                <span class="fa fa-star" onclick="selectRating(4)"></span>
                <span class="fa fa-star" onclick="selectRating(5)"></span>
            </div>
            <!-- Hidden input to store the selected rating -->
            <input type="hidden" name="rating" id="rating" value="0">

            <input type="submit" name="review" value="Submit Review">
        </form>
    </section>
</body>
</html>
