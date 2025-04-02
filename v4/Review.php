<?php
$reviewRequest = "SELECT r.user_id, r.rating, r.comment, r.created_at, u.username FROM Reviews r LEFT JOIN Users u ON r.user_id = u.user_id WHERE product_id = '$id'";

$reviewResult = mysqli_query($conn, $reviewRequest);

//get reviews from database

$reviews = [];
if (mysqli_num_rows($reviewResult) > 0) {
    while($row = mysqli_fetch_assoc($reviewResult)) {
        //format Date 
        $row['created_at'] = date("d-m-Y", strtotime($row['created_at']));
        $reviews[] = $row;
    }
}


?>

<!DOCTYPE html>
<html>
    <script> 
        function selectRating(rating) {
            document.getElementByClassName('stars').
        }
    </script>
    <link rel="stylesheet" href="css/Review.css" type="text/css">
    <body>

    <!-- Reviews Section -->
    <section class="review-section">
        <h3>Game Reviews</h3>
        <div class="reviews-container">
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                <p><strong>User: </strong><?= $review['username'];?><br>
                <strong>Review Date: </strong><?= $review['created_at'];?><br>
                <!-- Star Rating Display -->
                <?php for ($i = 1; $i <= 5; $i++):?>
                    <span class="fa fa-star <?= $i <= $review['rating'] ? 'checked' : '';?>"></span>
                <?php endfor;?>
                <p><?= $review['comment'];?></p>
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
                 
            </div>
            <!-- Hidden input to store the selected rating -->
            <input type="hidden" name="rating" id="rating" value="0">

            <input type="submit" name="review" value="Submit Review">
        </form>
    </section>
    </body>
</html>
