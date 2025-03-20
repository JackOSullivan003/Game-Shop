<?php
$logins = [
    ["Username" => "enter username:", "Password" => "enter password:"]
];


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Game & Stop</title>
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
            .login { 
                display: inline-block; 
                background-color: white; 
                margin: 10px; 
                width: 600px;
                padding-left: 5px; 
                vertical-align: center;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .login-details {
                margin: 10px 10px;
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
                padding: 5px;
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
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <?php include "header.php"; ?>
    
    <section class="login">
        <h2>Sign in to Game & Stop</h2>
        <br>
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
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>

    </body>
</html>
