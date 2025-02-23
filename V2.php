<?php
$products = [
    ["name" => "Dayz", "price" => "$40.00", "image" => "temp/dayz.jpg"],
    ["name" => "Balder's Gate 3", "price" => "$80.00", "image" => "temp/balders_gate_3.jpg"],
    ["name" => "Gaming Mouse", "price" => "$30.00", "image" => "temp/mouse.jpg"],
    ["name" => "Gaming Keyboard", "price" => "$75.00", "image" => "temp/keyboard.jpg"]
];

$ads = [
    ["image" => "temp/adBackground.png"]
];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Game & Shop</title> 
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

            .ad img { 
                width: 150px; 
                height: 20px; 
                object-fit: cover;
            }
            .product { 
                display: inline-block; 
                background-color: white; 
                margin: 20px; 
                width: 200px;
                height: 300px;
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

            footer {
                background-color: lightgrey;
                padding: 10px;
                text-align: center;
            }
            a.social-media-link {
                color: black;
                text-decoration: none;
                padding: 5px;
                font-size: 20px;
            }
            a.social-media-link:hover {
                color: blue;
            }

            .slider-container {
                position: relative;
                max-width: 100%;
                margin: auto;
                overflow: hidden;
                height: 300px;
            }

            .slider {
                display: flex;
                transition: transform 0.5s ease;
            }

            .slide {
                width: 100%;
                height: 100%;
                background-color: lightgrey; 
                display: block;
                transition: opacity 1s ease-in-out;
            }

            .slider-container button {
                position: absolute;
                top: 50%;
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                border: none;
                padding: 15px;
                cursor: pointer;
                font-size: 18px;
                border-radius: 50%;
                transform: translateY(-50%);
            }

            .slider-container button:hover {
                background-color: rgba(0, 0, 0, 0.7);
            }

            .prev {
                left: 10px;
            }

            .next {
                right: 10px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Welcome to Game & Stop</h1>
            <nav>
                <a href="index.php">Home</a> | 
                <a href="#">Contact</a>
            </nav>
        </header>

        <section class="slider-container">
            <div class="slider">
            <img src="temp/ad1.png" class="slide">
            <img src="temp/ad2.png" class="slide">
            <img src="temp/ad3.png" class="slide">
            <img src="temp/ad4.png" class="slide">
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </section>

        <section class="ad">
            <br>
            <div class="ad">
                <?php foreach ($ads as $ad): ?>
                    <div class="ad">
                        <img src="<?= $ad['image']; ?>" alt="Advertisement">
                    </div>
                <?php endforeach; ?>
            </div>
        </section> 

        <section class="products-section">
            <h2>Featured Products</h2>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                    <div class="product-details">
                        <h3><?= $product['name']; ?></h3>
                        <p>Price: <?= $product['price']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <footer>
            <p>&copy; 2025 Game & Stop</p>
            <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
            <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
        </footer>

        <script>
            let slideIndex = 0;

            function showSlide(index) {
                const slides = document.querySelectorAll(".slide");
                if (index >= slides.length) {
                    slideIndex = 0;
                } else if (index < 0) {
                    slideIndex = slides.length - 1;
                }
                
                slides.forEach((slide) => {
                    slide.style.opacity = 0;
                });

                slides[slideIndex].style.opacity = 1;
            }

            function moveSlide(step) {
                slideIndex += step;
                showSlide(slideIndex);
            }

            showSlide(slideIndex);

            setInterval(() => {
                moveSlide(1);
            }, 5000);
        </script>

    </body>
</html>
