<?php class User {
    public $username; 
    public $password;
    public $email;
    public $fullName;
    public $address;
    public $phoneNo; 
    public $isAdmin;

    // Constructor
    public function __construct($username, $password, $email, $fullName, $address, $phoneNo, $isAdmin) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phoneNo = $phoneNo;
        $this->isAdmin = $isAdmin;
    }
}