<?php 
include 'Connection.php';
include '../classes/User.php';

$conn = Connection::getConnection(); 

//check if user exists using form submission info 

$userName = $_POST['username'];

$sql = "SELECT * FROM users WHERE username = '$userName'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){ //if user exists, check password
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password_hash'];
    $password = $_POST['password'];
    if(password_verify($password, $hashedPassword)){
        //create user object and log them in
        $user = new User($conn, $row['username'], $row['password_hash'], $row['email'], $row['full_name'], $row['address'], $row['phone_number']);
        
        $user->login();
        //echo session user info and redirect to home page after 3 seconds
        header("refresh:3; url=../home.php");
        echo "Logged in successfully. welcome " . $_SESSION['user']->getUsername(). "! redirectiong to home page...";
    }
    else {
        echo "Invalid username or password";
    }
} 
else {
    echo "Invalid username or password";
}

?>