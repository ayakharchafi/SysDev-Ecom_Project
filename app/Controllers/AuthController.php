<?php
class AuthController {
    public function showLogin()
    {
        session_start();
        if ($this->isLoggedIn()) {
            header('Location: /tern_application/dashboard');
            exit;
        }

        $rememberedUsername = $_COOKIE['rememberedUser'] ?? '';
        require_once __DIR__ . '/../Views/auth/login.html';
    }

    public function processLogin()
    {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']);

            if ($this->validateCredentials($username, $password)) {
                $_SESSION['user'] = $username;

                if ($rememberMe) {
                    setcookie(
                        'rememberedUser', 
                        $username, 
                        time() + (30 * 24 * 60 * 60), 
                        '/tern_application/'
                    );
                }

                header('Location: /tern_application/dashboard');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                // Redirect back to login page with error message
                header('Location: /tern_application/login');
                exit;
            }
        }

        header('Location: /tern_application/login');
        exit;
    }

    public function logout()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session variables
        $_SESSION = array();

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();

        // Clear remember me cookie
        setcookie('rememberedUser', '', time() - 3600, '/tern_application/');

        // Redirect to login
        header('Location: /tern_application/login');
        exit;
    }

    private function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    private function validateCredentials($username, $password)
    {
        // This is a placeholder for actual validation logic
        // In a real application, you would check against a database or other data source
        $validUsers = ['user1' => 'user1'];
        // Replace with real validation logic
        return isset($validUsers[$username]) && $validUsers[$username] === $password;
    }
}