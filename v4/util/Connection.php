<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Connection {
    
    private static $servername = "localhost";
    private static $username = "shop";
    private static $password = "shop";
    private static $dbname = "games_shop";

    static $conn = null; 
    public static function getConnection() {
        //create a connection only if one doesnt already exist
        try{
            //use sqli to make a connection 
            self::$conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
            //save in session variable 
            $_SESSION['conn'] = self::$conn; // save connection in session

        }
        catch(mysqli_sql_exception $e){
            echo "Connection failed: ". $e->getMessage();
        }
        return self::$conn; //return the connection object for further use in other classes or functions.
    }


    public static function closeConnection(){
        //close the connection
        //if a connection exists, close it
        if(isset(self::$conn)){
            self::$conn->close();
        }
        //unset the session variable to free up memory
        unset($_SESSION['conn']); // unset the connection in session variable 
    
        echo "Connection closed";
    
        //return true to confirm the connection has been closed
        return true;
    }
}

?>