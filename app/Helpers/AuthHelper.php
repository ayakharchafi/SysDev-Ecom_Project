<?php
function requireLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['user'])) {
        header('Location: /tern_app/SysDev-Ecom_Project/login');
        exit;
    }
}