<?php

function addPasswordToAccount($password, $username) { 
$message = ""; 
$validPassword = "password"; 
$validUsername = "user123"; 
$result = null;  

if ($username !== $validUsername) { 
    $message .= "The username you entered is incorrect. \n"; 
} 

 if ($password !== $validPassword) { 
   $message .= "The password you entered is incorrect.\n"; 
} 
if (!empty($message)) { 

    echo nl2br($message); 

} else { 
    try { 
        $db = new PDO("mysql:host=localhost;dbname=games_shop", "shop", "shop");
        $sql = "INSERT INTO Users (username, password_hash) VALUES (:username, :password)";
        $bind = $db->prepare($sql); 
        $bind->bindParam(':username', $username); 
        $bind->bindParam(':password', $password); 
        $bind->execute(); 

     $result = array("password" => $password, "username" => $username); 
     echo "Congrats, you're logged in";
     $db = null; 

    } catch (PDOException $e) { 
        echo "Error: " . $e->getMessage(); 
    } 
} 

return $result; 
} 
addPasswordToAccount("password", "user123");

//The end 

?>