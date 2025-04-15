<?php
class User {
    // Plain text credentials
    private $validUsers = [
        'demo' => 'demo123' // username => password
    ];

    public function verifyCredentials($username, $password)
    {
        return isset($this->validUsers[$username]) && 
               $this->validUsers[$username] === $password;
    }
}

?>