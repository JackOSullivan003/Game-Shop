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

            #chatbot-container {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 300px;
                height: 400px;
                background-color: white;
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
            }

            .chatbox {
                display: flex;
                flex-direction: column;
                padding: 10px;
                height: 100%;
            }

            .chat-log {
                flex-grow: 1;
                overflow-y: auto;
                margin-bottom: 10px;
            }

            #user-input {
                width: 100%;
                padding: 10px;
                font-size: 14px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            button {
                padding: 10px 15px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #45a049;
            }

            .user-message {
                background-color: #e0e0e0;
                padding: 8px;
                margin: 5px 0;
                border-radius: 5px;
                text-align: left;
            }

            .bot-message {
                background-color: #4CAF50;
                color: white;
                padding: 8px;
                margin: 5px 0;
                border-radius: 5px;
                text-align: left;
            }
        </style>
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

        <div id="chatbot-container">
            <div id="chatbox" class="chatbox">
                <div id="chat-log" class="chat-log"></div>
                <textarea id="user-input" placeholder="Ask me anything..." rows="3"></textarea><br>
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>

        <footer>
            <p>&copy; 2025 Game & Stop</p>
            <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
            <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
        </footer>

        
    </body>
</html>
