<?php
class User {
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function findByUsername($username)
    {
        // This is a placeholder - in a real app you would:
        // 1. Query the database
        // 2. Return user data or false
        return [
            'username' => 'demo',
            'password_hash' => password_hash('demo123', PASSWORD_DEFAULT)
        ];
    }

    public function verifyCredentials($username, $password)
    {
        $user = $this->findByUsername($username);
        if (!$user) return false;

        return password_verify($password, $user['password_hash']);
    }
}