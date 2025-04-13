<?php
function requireLogin() {
    session_start();
    if (empty($_SESSION['user'])) {
        header('Location: /tern_application/login');
        exit;
    }
}

function requireLogout() {
    session_start();
    if (!empty($_SESSION['user'])) {
        header('Location: /tern_application/dashboard');
        exit;
    }
}