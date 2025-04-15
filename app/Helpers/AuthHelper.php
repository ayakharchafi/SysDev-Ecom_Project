<?php
function requireLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['user'])) {
        header('Location: /tern_application/login');
        exit;
    }
}