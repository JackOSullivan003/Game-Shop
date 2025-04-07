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
    
    <link rel="stylesheet" href="css/Review.css" type="text/css">
    <script>
        const isLoggedIn = <?php echo (isset($_SESSION['user']) && $_SESSION['user'] != null) ? 'true' : 'false'; ?>;
    </script>
    <script src="js/Review.js"></script>
    <body>

    <!-- Reviews Section -->
    <section class="review-section">
        <h3>Game Reviews</h3>
        <div class="reviews-container">
            <?php 
            if (empty($reviews)) {
                echo "<p>No one has reviewed this item yet.</p>";
              }
            else{
            foreach ($reviews as $review): ?>
                <div class="review">
                <p><strong>User: </strong><?= $review['username'];?><br>
                <strong>Review Date: </strong><?= $review['created_at'];?><br>
                <!-- Star Rating Display -->
                <?php for ($i = 1; $i <= 5; $i++):?>
                    <span class="fa fa-star <?= $i <= $review['rating'] ? 'checked' : '';?>"></span>
                <?php endfor;?>
                <p><?= $review['comment'];?></p>
                </div>
            <?php endforeach; 
            }?>
        </div>
    </section>

    <!-- Submit Review Section -->
    <section class="review-section">
        <h3>Submit Your Review</h3>
        <!-- Star Rating Input -->
        <div class="rating">
            <!-- Stars to click for rating -->
             <span class="fa fa-star star" onclick="selectRating(1)"></span>
            <span class="fa fa-star star" onclick="selectRating(2)"></span>
            <span class="fa fa-star star" onclick="selectRating(3)"></span>
            <span class="fa fa-star star" onclick="selectRating(4)"></span>
            <span class="fa fa-star star" onclick="selectRating(5)"></span>
             
        </div>

        <form action="reviews.php?id=<?= $id; ?>" method="post" class="review-form">
            <input type="hidden" name="rating" id="rating" value="0">
            <textarea name="review-text" required id="review-text" placeholder="Write your review here..."></textarea><br>
            <input type="submit" name="review" value="Submit Review">
        </form>
    </section>
    </body>
</html>
