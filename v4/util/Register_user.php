<?php

include 'Connection.php'; 

include '../classes/User.php';
$conn = Connection::getConnection();


$email = $_POST['email'];
$emailSafe = mysqli_real_escape_string($conn, $email);
$userResult = mysqli_query($conn, "SELECT * FROM users WHERE email = '$emailSafe'");

// Check if result contains any row (i.e., user exists)

if (mysqli_num_rows($userResult) > 0) {
    
    echo "This Email already has a User. Please log in instead of registering.";
    
    //delay 3 seconds before redirecting to home page
    header('refresh:3; url=../home.php');
    exit();
    
} else {
    
    // If user doesn't exist, insert user into database
    $userName = $_POST['username']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullName = $_POST['fullName'];
    //reconnect address information from form submission
    $address = $_POST['address1'] . ' ' . $_POST['address2'] . ' ' . $_POST['address3'] . ' ' . $_POST['address4'] . ' ' . $_POST['address5'];
    $phoneNo = $_POST['phoneNo'];
    //prepare values for inserting into database
    //mysqli_real_escape_string is used to prevent SQL injection attacks and make sure the string is properly inserted
    
    $user = new User($conn, null, $username, $email, $password, $fullName, $address, $phoneNo);
    
    if (mysqli_query($conn, $sql)) {
        $userId = mysqli_insert_id($conn); 
        echo "User registered successfully.";
        //save user object in session
        $user->setId($userId);
        $user->login();
        //redirect to home page
        header("refresh:2; url=../home.php");

    } else {

        echo "Error: ". $sql. "<br>". mysqli_error($conn);

    }

}

?>
