<?php 

class User {
    private $id;
    private $username; 
    private $password;
    private $email;
    private $fullName;
    private $address;
    private $phoneNo;

    // Constructor
    public function __construct($id, $username, $password, $email, $fullName, $address, $phoneNo) {
        //get Id for user
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phoneNo = $phoneNo;

    }

    //log in user
    public function login() {   
        //get current session and set user variable 
        session_start();
        $_SESSION['user'] = $this;
        $_SESSION['user_id'] = $this->getId();
        echo "user set in session\n";
        return true;
    }

    //log out user
    public function logout() {
        unset($_SESSION['user']);
        return true;
    }
    public function getId() {
        return $this->id;
    }
    
    //basic getter methods
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getFullName() {
        return $this->fullName;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getPhoneNo() {
        return $this->phoneNo;
    }

    //basic setter methods
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }
    public function setAddress($address) {
        $this->address = $address;
    }
    public function setPhoneNo($phoneNo) {
        $this->phoneNo = $phoneNo;
    }

}

?>

    
