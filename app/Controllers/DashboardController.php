<?php
namespace controllers;
use models\User;
use database\DatabaseConnectionManager;
require_once __DIR__.'/../Models/User.php';
require_once __DIR__.'/../Core\Database\databaseconnectionmanager.php';
class DashboardController {
    public function showDashboard()
    {
       // Start session first
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Check if user is logged in
    if (empty($_SESSION['user'])) {
        error_log("Dashboard access denied - no session");
        header('Location: /tern_app/SysDev-Ecom_Project/login');
        exit;
    }
    $admin = new User();
    $admin->readByUsername('Ian');
    $currentUser  = new User();
    $currentUser->readByUsername("{$_SESSION['user']}");
    if(isset($_POST['adminPassword'])){
    if($admin->verifyCredentials($_POST['adminPassword'])){
    if(isset($_POST['NewUsername'])){
        $createdUser = new User();
        $createdUser->setUsername($_POST['NewUsername']);
        $createdUser->setPassword(password_hash($_POST['NewPassword'], PASSWORD_BCRYPT));
        $createdUser->setUser_Email($_POST['NewEmail']);
       // if( $_POST['2FA'] == "enabled"){
                $createdUser->enableTwoFactor();
      //  }
      if($_POST['newRole'] == "External"){
        if(isset($_POST['newClient'])){
            $createdUser->setClientId($_POST['newClient']);
            $createdUser->create();
        }
    }else{
        $createdUser->create();
        echo "<script type='text/javascript'>alert('User has been Created');</script>";
        }
    }else if(isset($_POST['deleteUsername'])){
        $createdUser = new User();
      $data = $createdUser->readByUsername($_POST['deleteUsername']);
      if(isset($data['password'])){
        if(password_verify($_POST['deletePassword'],$data['password'])){
        if($data['user_email'] == $_POST['deleteEmail']){
            $createdUser->delete($data['user_id']);
            echo "<script type='text/javascript'>alert('User has been Deleted');</script>";
        }else{
            "<script type='text/javascript'>alert('Delete Attempt failed: Email was invalid');</script>";
        }
    }else{
          "<script type='text/javascript'>alert('Delete Attempt failed: Password was invalid');</script>";
    }
}
    }
        }else{
            echo "<script type='text/javascript'>alert('Admin Password is Invalid');</script>";
        }
}
    if(!null == $currentUser->getClientId()){
        require_once __DIR__ . '/../Views/main/external_main.php';
    }else{
        if($currentUser->getUserID() == "1"){
    require_once __DIR__ . '/../Views/main/main.php';
        }else{
            require_once __DIR__ . '/../Views/main/internal_main.php'; 
        }
    }   
}
}