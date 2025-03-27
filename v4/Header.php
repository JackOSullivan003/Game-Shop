<head>
    <title>Game & Shop</title> 
        <!--using font-awesome library for some aspects of the website-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css"href="css/header.css">


    </head>
    <body>
    <header>
        <div class="header">
            <a href="Home.php"><h1 id="title">Welcome to Game & Stop</h1></a>
            <div class="search-bar-container">
                <input type="text" class="search-bar" id="search" onkeyup="searchItems()" placeholder="Search items...">
                <i class="fa fa-search fa-1x"></i>
            </div>

        <!-- Cart -->
        <div class="icon-container">    

            <a href="CartPage.php">
                <i id="cart-icon" class="fa fa-shopping-cart"></i>
                <span id="cartCount"><?php echo isset($_SESSION['cart'])? count($_SESSION['cart']) : 0; ?></span>
            </a>
            
            <!--User--> 
            <!--if user is logged in, navigate to user-account.php, else navigate to Registration.php -->
            <a href="<?php echo isset($_SESSION['user'])? 'UserAccount.php' :'Login.php';?>">
                <i class="fa fa-user fa-lg"></i>
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
                        link.href = "#";
                        link.onclick = function() {
                            fetchGames(category.category_id);
                        };
                        gameDropdown.appendChild(link);
                    });

                    categories.Merch.forEach(category => {
                        let link = document.createElement("a");
                        link.textContent = category.category_name;
                        link.href = "#";
                        link.onclick = function() {
                            fetchMerchandise(category.category_id);
                        };
                        merchDropdown.appendChild(link);
                    });
                
                })
                .catch(error => console.error("Error fetching categories:", error));
        }
    </script>