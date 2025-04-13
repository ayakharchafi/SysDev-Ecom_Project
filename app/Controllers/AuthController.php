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
            }
        }

        header('Location: /tern_application/login');
        exit;
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        
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
        
        setcookie('rememberedUser', '', time() - 3600, '/tern_application/');
        session_destroy();
        
        header('Location: /tern_application/login');
        exit;
    }

    private function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    private function validateCredentials($username, $password)
    {
        // Replace with real validation logic
        return !empty($username) && !empty($password);
    }
}