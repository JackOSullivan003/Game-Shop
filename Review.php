<!DOCTYPE html>

<?php
$reviews = [
    ["username" => "PlayerOne", "review" => "Amazing game! The graphics are top-notch and the storyline is captivating.", "rating" => 5],
    ["username" => "GamerX", "review" => "A bit repetitive, but still enjoyable. Worth the playthrough.", "rating" => 3],
    ["username" => "EpicGamer", "review" => "Not my favorite game, but has a great multiplayer mode.", "rating" => 4],
];
?>
<html>
    <link rel="stylesheet" href="css/Review.css" type="text/css">
    <body>

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
