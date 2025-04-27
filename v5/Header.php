<head>
    <title>Game & Shop</title> 
        <!--using font-awesome library for some aspects of the website-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css"href="css/header.css">
</head>
<body>


    <header>
    <div class="header">
        <div clas="title-box">
            <a href="Home.php"><h1 id="title">Game & Stop</h1></a>
        </div>
        <div class="header-icons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="Create_Listing.php" class="upload-btn">
                    <i class="fa fa-plus"></i>
                </a>
            <?php endif; ?>
            <div class="cart-container">
                <a href="CartPage.php">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                    <span id="cartCount">
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>
                </a>
            </div>
            <a href="<?php echo isset($_SESSION['user']) ? 'UserAccount.php' : 'Login.php'; ?>">
                <i class="fa fa-user fa-2x"></i>
            </a>
        </div>

    </div>
        <!--basic nav-bar -->
        <nav>
            <div class="dropdown">
                <button>Games</button>
                <div class="dropdown-content" id="gameCategories">
                    <h3>Categories</h3>
                    <!-- Categories will be loaded here -->
                </div>
            </div>
            <div class="dropdown">
                <button>Merch</button>
                <div class="dropdown-content" id="merchCategories">
                    <h3>Merch</h3>
                    <!-- Merchandise items will be loaded here -->
                </div>
            </div>


        </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCategories();
    });

    function fetchCategories() {
        fetch("util/fetch_categories.php")
            .then(response => response.json())
            .then(categories => {
                let gameDropdown = document.getElementById("gameCategories");
                let merchDropdown = document.getElementById("merchCategories");

                categories.Games.forEach(category => {
                    let link = document.createElement("a");
                    link.textContent = category.category_name;
                    link.href = "CategoryPage.php?category_id=" + category.category_id; // link to page with products from that category
                    link.onclick = function() {
                        fetchGames(category.category_id);
                    };
                    gameDropdown.appendChild(link);
                });

                categories.Merch.forEach(category => {
                    let link = document.createElement("a");
                    link.textContent = category.category_name;
                    link.href = "CategoryPage.php?category_id=" + category.category_id; //link to merch of different category
                    link.onclick = function() {
                        fetchMerchandise(category.category_id);
                    };
                    merchDropdown.appendChild(link);
                });
                
            })
            .catch(error => console.error("Error fetching categories:", error));
    }
</script>