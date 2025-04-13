<?php
class AuthController {
    public function showLogin()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check for remembered user
        $rememberedUsername = '';
        if (isset($_COOKIE['rememberedUser'])) {
            $rememberedUsername = $_COOKIE['rememberedUser'];
        }

        // Pass data to view
        require_once __DIR__ . '/../Views/auth/login.html';
    }

    public function processLogin()
    {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']);

            // Simple validation (in real app, use Model)
            if (!empty($username) && !empty($password)) {
                $_SESSION['user'] = $username;

                // Set remember me cookie (30 days)
                if ($rememberMe) {
                    setcookie(
                        'rememberedUser', 
                        $username, 
                        time() + (30 * 24 * 60 * 60), 
                        '/tern_application/',
                        '',
                        false,
                        true // HttpOnly
                    );
                } else {
                    // Clear remember me cookie if not checked
                    setcookie('rememberedUser', '', time() - 3600, '/tern_application/');
                }

                // Redirect to dashboard
                header('Location: /tern_application/dashboard');
                exit;
            }
        }

        // If login fails, show form again
        $this->showLogin();
    }
}