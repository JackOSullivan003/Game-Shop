<?php
// Define sample login variables, this is a list of variable names and values for each product 
$logins = [
    ["Username" => "enter username:", "Password" => "enter password:"]
];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Game & Stop</title> 
    <!--basic css -->
        <style> 
            body {
                background-color: grey;
                font-family: Arial, sans-serif; 
                text-align: left; 
            }
            header {
                background-color: lightgrey;
            }

            nav {
                display: flex;
                justify-content: space-around;
                background-color: white;
            }
            .login { 
                display: inline-block; 
                background-color: white; 
                margin: 10px; 
                width: 400px;
                padding: 10px; 
                 
                vertical-align: left;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .login-details {
                margin: 10px 0;
            }

            .product h3 {
                margin: 0;
                font-size: 22px;
                
                font-weight: bold;
            }

            .login h2 {
                margin: 10px;
                font-size: 22px;
                
                font-weight: bold;
                text-align: center;
            }

            footer {
                background-color: lightgrey;
                padding: 10px;
                text-align: center;
            }

            /*style for social media links*/
            a.social-media-link {
                color: black;
                text-decoration: none;
                padding: 2px;
                font-size: 20px;
            }

            a.social-media-link:hover {
                color: blue;
            }
        </style>
        <!--using font-awesome library to add buttons for the facebook and twitter social media links, this avoids the need for images for them-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <header>

        <h1>Welcome to Game & Stop</h1>
        <!--basic nav-bar -->
        <nav>
            <a href="index.php">Home</a> | 
            <a href="#">Contact</a>
        </nav>
    </header>
    
    <!--section for login display-->
    <section class="login">
        <h2>Welcome</h2>
        <h2>Sign in to Game & Stop</h2>
        <br>
        <!-- Displaying login form using PHP -->
        <?php foreach ($logins as $login): ?>
            <div class="login">
             <form action="#" method="post">
             <div class="login-details">
             <label for="username"><?= $login['Username']; ?></label><br>
             <input type="text" name="username" id="username" required><br><br>
                        
             <label for="password"><?= $login['Password']; ?></label><br>
             <input type="password" name="password" id="password" required><br><br>
                        
             <input type="submit" name="login" value="Login">
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </section>

    <footer>
        <p>&copy; 2025 Game & Stop</p>
        <!--add social media links-->
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>

    </body>
</html>
