<?php
namespace models;
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use database\DatabaseConnectionManager;

class User {
    private $user_id;
    private $user_email;
    private $user_name;
    private $password;
    private $name;
    private $phone;
    private $status;
    private $created;
    private $updated;
    private $enabled2FA;

    private $dbConnection;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }    

    public function getUsername() {
        return $this->user_name;
    }

    public function setUsername($username) {
        $this->user_name = $username;
    }    

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public function getUser_Email() {
        return $this->user_email;
    }

    public function setUser_Email($status) {
        $this->status = $user_email;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    public function __construct() {
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function readOne() {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function readByUsername($username) {
        $query = "SELECT * FROM users WHERE user_name = :username";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            $this->user_name = $user['user_name'];
            $this->password = $user['password'];
            $this->user_id = $user['user_id'];
            $this->name = $user['name'];
            $this->phone = $user['phone'];
            $this->status = $user['status'];
            $this->created = $user['created'];
            $this->updated = $user['updated'];
            $this->enabled2FA = $user['enabled2fa'];
        }
    
        return $user;
    }

    public function read() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create() {
        if (empty($this->user_name) && empty($this->password)) {
            return false;
        }

        $query = "INSERT INTO users (user_name, password) VALUES (:user_name, :password)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }

    private $validUsers = [
        'demo' => 'demo123' // username => password
    ];

    public function verifyCredentials($password) {
        $isVerified = password_verify(trim($password), $this->password); // Store the result once
    
        if ($isVerified) {
            $_SESSION['user_id'] = $this->user_id; // Use $this->user_id properly
            return true;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            return false;
        }
    }

    public function displayRecords($data){
        $html = "";
        foreach ($data as $user) {
            $html .= "<tr>";
            $html .= "<td>{$user["user_id"]}</td>";
            $html .= "<td>{$user["name"]}</td>";
            $html .= "<td>{$user["user_email"]}</td>";
            $html .= "<td>{$user["phone"]}</td>";
            $html .= "<td>{$user["status"]}</td>";
            $html .= "<td>{$user["created"]}</td>";
            $html .= "<td>{$user["updated"]}</td>";
            $html .= "   <td>";
            $html .= "   <button class= 'action-btn'><i class= 'fa-solid fa-edit'></i></button>";
            $html .= "    <button class= 'action-btn'><i class= 'fa-solid fa-trash'></i></button>";
            $html .= "  </td>";
            $html .= "</tr>";
            
        }
    
        echo $html;
    }

    
    function storeTwoFactorCode($code) {
        $hashedCode = password_hash($code, PASSWORD_DEFAULT);

        $query = "UPDATE users SET secret = :code WHERE id = :user_id";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':code', $code);
        
        return $stmt->execute();
    }
    
    function sendTwoFactorEmail($code) {
        $subject = "Your Authentication Code";
        $message = "Your verification code is: $code\n\n";
        $headers = "From: melanie.l.swain@gmail.com";
        
        mail($email, $subject, $message, $headers);
    }
}

?>