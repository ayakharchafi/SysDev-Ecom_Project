<?php
class User {
    // For demo purposes - replace with database connection
    private $validUsers = [
        'demo' => 'demo123' // password = "demo123"
    ];

    public function verifyCredentials($username, $password)
    {
        if (!isset($this->validUsers[$username])) {
            return false;
        }
        
        return password_verify($password, $this->validUsers[$username]);
    }
}