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
    if(isset($_POST['adminPassword'])){
    if($admin->verifyCredentials($_POST['adminPassword'])){
        $createdUser = new User();
        $createdUser->setUsername($_POST['NewUsername']);
        $createdUser->setPassword(password_hash($_POST['NewPassword'], PASSWORD_BCRYPT));
        $createdUser->setUser_Email($_POST['NewEmail']);
        $createdUser->create();
        echo "<script type='text/javascript'>alert('User Has been Created');</script>";
        }else{
            echo "<script type='text/javascript'>alert('Admin Password is Invalid');</script>";
        }
    }

    require_once __DIR__ . '/../Views/main/main.php';
    }
}