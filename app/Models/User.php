<?php
namespace models;

require __DIR__.'/../../vendor/autoload.php'; 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();


use database\DatabaseConnectionManager;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class User {
    private $user_id;
    private $user_email;
    private $user_name;
    private $password;
    private $status;
    // for 2FA
    private int $enabled2FA = 0;
    private $secret;
    private $expiresAt;
    private $client_id;
    private $dbConnection;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }    
    
    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($id) {
        $this->client_id = $id;
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

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public function getUser_Email() {
        return $this->user_email;
    }

    public function setUser_Email($email) {
        $this->user_email = $email;
    }

    public function getEnabled2FA() {
        return $this->enabled2FA;
    }

    public function setEnabled2FA($enabled) {
        $this->enabled2FA = $enabled;
    }

    public function getSecret() {
        return $this->secret;
    }

    public function setSecret($secret) {
        $this->secret = $secret;
    }

    public function getExpiresAt() {
        return $this->expiresAt;
    }

    public function setExpiresAt($expiresAt) {
        $this->expiresAt = $expiresAt;
    }

    public function __construct() {
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    /**
     * * * * Read a user by ID from the database
     * * @return array The user record if found, null otherwise
     */
    public function readOne() {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }
    public function readUserID() {
        $query = "SELECT user_id FROM users WHERE user_name = :user_name";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
     * * * Read a user by username from the database
     * @param string $username The username to search for
     * * @return array The user record if found, null otherwise
     */
    public function readByUsername($username) {
        $query = " SELECT users.`user_id` as user_id, `user_email`, `user_name`, `password`, external_users.client_id as client_id, enabled2FA, secret, expiresAt, status  FROM `users`
         left JOIN external_users ON users.user_id = external_users.user_id 
         left JOIN internal_users ON users.user_id = internal_users.user_id WHERE user_name = :username";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            $this->user_name = $user['user_name'];
            $this->password = $user['password'];
            $this->user_id = $user['user_id'];
            $this->client_id = $user['client_id'];
            $this->user_email = $user['user_email'];
            $this->status = $user['status'];
          $this->enabled2FA = $user['enabled2FA'];
            $this->secret = $user['secret'];
            $this->expiresAt = $user['expiresAt'];
        }
    
        return $user;
    }

    public function readClientName() {
        $query = " SELECT  external_users.client_id as client_id FROM `users`
         left JOIN external_users ON users.user_id = external_users.user_id WHERE client_id = :client_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    



    
        return  $user['client_id'];
    }

    /*
     * * * Read all users from the database
     * * @return array An array of user records
     */
    public function read() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /*
    * * * Create a new user in the database
    * * @return bool True if the user was created successfully, false otherwise
    */
    public function create() {
        if (empty($this->user_name)&&empty($this->$user_email) && empty($this->password)) {
            return false;
        }
if(isset($this->client_id)){
    $query = "INSERT INTO users (user_name, user_email, password) VALUES (:user_name, :user_email, :password);
              INSERT INTO `external_users` (`user_id`, `client_id`) VALUES (LAST_INSERT_ID(), :client_id);";
    $stmt = $this->dbConnection->prepare($query);

    $stmt->bindParam(':user_name', $this->user_name);
    $stmt->bindParam(':user_email', $this->user_email);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(':client_id', $this->client_id);


}else{
        $query = "INSERT INTO users (user_name, user_email, password) VALUES (:user_name, :user_email, :password)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':user_email', $this->user_email);
        $stmt->bindParam(':password', $this->password);
}
        return $stmt->execute();
    }


    public function delete($id) {

if(isset($id)){
    $query = "DELETE FROM `users` WHERE user_id = :user_id;";
    $stmt = $this->dbConnection->prepare($query);

    $stmt->bindParam(':user_id',$id);



}
        return $stmt->execute();
    }

    /**
     * * * Verify the user's credentials
     * * @param string $password The password entered by the user
     * * @return bool True if the credentials are valid, false otherwise
     */
    public function verifyCredentials($password) {
        $isVerified = password_verify(trim($password), $this->password); // Store the result once
    
        if ($isVerified) {
            // $_SESSION['user_id'] = $this->user_id; // Use $this->user_id properly
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
            $html .= "<td>{$user["user_email"]}</td>";
            $html .= "<td>{$user["status"]}</td>";
            $html .= "   <td>";
            $html .= "   <button class= 'action-btn'><i class= 'fa-solid fa-edit'></i></button>";
            $html .= "    <button class= 'action-btn'><i class= 'fa-solid fa-trash'></i></button>";
            $html .= "  </td>";
            $html .= "</tr>";
            
        }
    
        echo $html;
    }

    /**
     * * Generate a 2FA code and store it in the database
     * * @return string The generated 2FA code (6 digits)
     */
    public function generateTwoFactorCode() {
        $code = random_int(100000, 999999);
        
        $hashedCode = password_hash($code, PASSWORD_DEFAULT);
        
        // Expiration time 10 minutes from now
        $expires_at = date('Y-m-d H:i:s', time() + 600);
        
        $query = "UPDATE users SET secret = :secret, expiresAt = :expires WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':secret', $hashedCode);
        $stmt->bindParam(':expires', $expires_at);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        
        $this->secret = $hashedCode;
        error_log("2FA code generated: $hashedCode");
        $this->expiresAt = $expires_at;
        
        return $code;
    }

    /**
     * * Verify the 2FA code entered by the user
     * Ensures that the code is valid and not expired
     * @param string $code The code entered by the user
     * @return bool True if the code is valid, false otherwise
     */
    public function verifyTwoFactorCode($code) {
        $now = new \DateTime();
        $expires_at = new \DateTime($this->expiresAt);
        
        if ($now > $expires_at) {
            error_log("2FA code has expired.");
            return false;
        }
        if (!password_verify($code, $this->secret)) {
            error_log("Code verification failed. $this->secret");
            return false;
        }
        return password_verify($code, $this->secret);
    }

    /**
     * * Clear the 2FA code from the database
     * * (after user has successfully logged in)
     */
    public function clearTwoFactorCode() {
        $query = "UPDATE users SET secret = NULL, expiresAt = NULL WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        
        $this->secret = null;
        $this->expiresAt = null;
    }

    /**
     * * Enable 2FA for the user
     * * @return bool True if the operation was successful
     */
    public function enableTwoFactor() {
        $query = "UPDATE users SET enabled2FA = 1 WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $result = $stmt->execute();
        
        if ($result) {
            $this->enabled2FA = 1;
        }
        
        return $result;
    }

    /**
     * * Disable 2FA for the user
     * * @return bool True if the operation was successful
     */
    public function disableTwoFactor() {
        $query = "UPDATE users SET enabled2FA = 0 WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $result = $stmt->execute();
        
        if ($result) {
            $this->enabled2FA = 0;
        }
        
        return $result;
    }

    /**
     * * Send the 2FA code to the user's email
     * * @param string $code The 2FA code to send
     * * @return bool True if the email was sent successfully
     */
    public function sendTwoFactorEmail($code) {
        if (empty($this->user_email)) {
            return false;
        }
        
        $subject = "Tern App Authentication Code";
        $message = "Your verification code is: $code\n\n";
        $message .= "This code will expire in 10 minutes.\n\n";
        $message .= "If you did not request this code, please ignore this email.";
        //$headers = "From: melanie.l.swain@gmail.com";
        
        return $this->sendMail($this->user_email, $subject, $message);
    }

    public function sendMail($to, $subject, $message) {
        // Use PHPMailer to send the email
        $mail = new PHPMailer(true); // Enable exceptions for error handling
        
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'melanie.l.swain@gmail.com';
            $mail->Password = 'cbnv ejaa izek rzvu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('melanie.l.swain@gmail.com', 'Tern App');
            $mail->addAddress($to, 'Tern App User');
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            echo "Email sent successfully!";
            return true;
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
            return false;
        }
    }

}

?>