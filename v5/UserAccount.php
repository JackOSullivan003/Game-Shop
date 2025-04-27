<?php 
require_once 'classes/user.php';
session_start(); 

$user = $_SESSION['user'];

//display information about the user

$username =  "Name: " . $user->getUsername() . "<br>";
$email =  "Email: " . $user->getEmail() . "<br>";
$name = "Full Name: " . $user->getFullName() . "<br>";
$address = "address: " . $user->getAddress() . "<br>";
$phoneno =  "Phone: " . $user->getPhoneNo() . "<br>";

// Check if the logout action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  session_start();
  $cart = $_SESSION['cart'] ?? []; // Save cart before destroying session
  session_destroy();
  session_start();
  $_SESSION['cart'] = $cart; // Restore cart after logout
  header("Location: home.php");
  exit();
}
?>

<script>
function logoutUser() {
    fetch("?action=logout")
        .then(response => window.location.href = "Home.php"); // Redirect after logout
}
</script>

<!DOCTYPE html>
<html lang="en">
<?php include'Header.php';?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<body>
  <h1>User Account Details</h1>
<div style = "background-color: #f2f2f2">
  <!--basic user management, update username, logout option -->
  <?php
    echo $username;
    echo $email;
    echo $name ;
    echo $address;
    echo $phoneno;
  ?>
<a href="">Update User</a>

<!--logout user through php logout() and load back to home.php-->
<a href="#" onclick="logoutUser()">Logout</a>

<a href="Home.php">Home</a>

</div>
</body>

<?php include'Footer.php';?>
</html>
