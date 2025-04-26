<?php 
include 'Connection.php';
include '../classes/User.php';
include 'common.php';

//check if user exists using form submission info 

$emailSafe = escape($_POST['email']);

$sql = "SELECT * FROM users WHERE email = :Email";

$statement = $connection->prepare($sql);
$statement-> bindParam(':Email', $emailSafe);
$statement->execute();
$result = $statement->fetch();

$isLoggingIn = false;

if($result > 0){ //if user exists, check password
    $hashedPassword = $result['password_hash'];
    $password = $_POST['password'];
    if(password_verify($password, $hashedPassword)){
        //create user object and log them in
        $isLoggingIn = true;
        $user = new User($result['user_id'], $result['username'], $result['password_hash'], $result['email'], $result['full_name'], $result['address'], $result['phone_number']);
        $user->login();
        //echo session user info and redirect to home page after 3 seconds
        header("refresh:3; url=../home.php");
        echo "Logged in successfully. welcome " . $_SESSION['user']->getUsername(). "! redirecting to home page...";
    }
    else {
        echo "Invalid Email or password";
    }
} 
else {
    echo "Invalid Email or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Logging in</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
</head>
<body>
<?php if(!$isLoggingIn): ?>
  <a href="../Login.php">Back</a>
<?php endif; ?>
</body>
</html>