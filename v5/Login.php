<!DOCTYPE html> 
<html>

    <head>
        <title>User Registration</title>
        <style>
            body {
                font-family: Arial, sans-serif;

            }

            h2 {
                text-align: center;
            }

            form {
                margin: 0 auto;
                width: 300px;
                padding: 20px;
                background-color: #f2f2f2;
            }
            input[type="text"], input[type="email"], input[type="password"], input[type="email"], input[type="fullName"], input[type="tel"] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }

            #address {
                margin: 8px 0 4px 0;
            }

            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
            }

        </style>
    </head>

    <?php include 'Header.php'; ?>
    <body>

        <!--User Login -->
        <h2>User Login</h2>
        <form action="util/login_user.php" method="post">
            <label for="Email">Email:</label><br>
            <input type="text" id="email" name="email" placeholder="User@gmail.com" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>

        <h2>User Registration</h2>

        <form action="util/register_user.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" placeholder="User_123" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="User@gmail.com" required><br>
            <label for="fullName">Full Name:</label><br>
            <input type="text" id="fullName" name="fullName" placeholder="John Smith" required><br>
            <label for="address">Address:</label><br> <!--split address into parts -->
            <input type="text" id="address" name="address1" placeholder="123 main street" required><br>
            <input type="text" id="address" name="address2" placeholder="merrygo north" required><br>
            <input type="text" id="address" name="address3" placeholder="castletown" required><br>
            <input type="text" id="address" name="address4" placeholder="Co.dublin" required><br>
            <input type="text" id="address" name="address5" placeholder="1A2B3C4" required><br>
            <label for="phoneNo">Phone Number:</label><br>
            <input type="tel" id="phoneNo" name="phoneNo" placeholder= "1234567890" required><br>
            <input type="submit" value="Register">
        </form>

        <?php include 'Footer.php';?>
    </body>
</html>