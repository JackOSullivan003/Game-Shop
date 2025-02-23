<?php
$reviews = [
    ["username" => "PlayerOne", "review" => "Amazing game! The graphics are top-notch and the storyline is captivating."],
    ["username" => "GamerX", "review" => "A bit repetitive, but still enjoyable. Worth the playthrough."],
    ["username" => "EpicGamer", "review" => "Not my favorite game, but has a great multiplayer mode."],
];

$logins = [
    ["Username" => "enter username:", "Password" => "enter password:"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'])) {
    $newReview = $_POST['review_text'];
    $username = "Guest";
    $reviews[] = ["username" => $username, "review" => $newReview];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Game & Stop - Reviews</title>
        <style>
            body {
                background-color: #f2f2f2;
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
                padding: 10px;
            }

            .review-section {
                display: inline-block;
                background-color: white;
                width: 600px;
                padding: 15px;
                margin: 20px 0;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .review-section h3 {
                margin: 0;
                font-size: 24px;
                font-weight: bold;
            }

            .reviews-container {
                margin-top: 20px;
                text-align: left;
            }

            .review {
                margin-bottom: 15px;
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
            }

            footer {
                background-color: lightgrey;
                padding: 10px;
                text-align: center;
            }

            a.social-media-link {
                color: black;
                text-decoration: none;
                padding: 2px;
                font-size: 20px;
            }

            a.social-media-link:hover {
                color: blue;
            }

            .review-form textarea {
                width: 100%;
                height: 100px;
                padding: 10px;
                margin-top: 10px;
                font-size: 16px;
            }

            .review-form input[type="submit"] {
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
            }

            .review-form input[type="submit"]:hover {
                background-color: #45a049;
            }

        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <h1>Welcome to Game & Stop</h1>
            <nav>
                <a href="index.php">Home</a> | 
                <a href="#">Contact</a> |
                <a href="reviews.php">Reviews</a>
            </nav>
        </header>

        <section class="review-section">
            <h3>Game Reviews</h3>
            <div class="reviews-container">
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <p><strong><?= $review['username']; ?>:</strong> <?= $review['review']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="review-section">
            <h3>Submit Your Review</h3>
            <form action="reviews.php" method="post" class="review-form">
                <textarea name="review_text" required placeholder="Write your review here..."></textarea><br><br>
                <input type="submit" name="review" value="Submit Review">
            </form>
        </section>

        <footer>
            <p>&copy; 2025 Game & Stop</p>
            <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
            <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
        </footer>
    </body>
</html>
