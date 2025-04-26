<footer>
    <link rel="stylesheet" type="text/css"href="css/footer.css">

        <p>&copy; 2025 Game & Stop</p>
        <!--add social media links-->
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
        <a href="<?php echo isset($_SESSION['user'])? 'UserAccount.php' :'Login.php';?>"><i class="fa fa-user fa-2xl"></i></a>
</footer>