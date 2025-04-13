<?php
class AuthController {
    public function showLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($this->isLoggedIn()) {
            header('Location: /tern_application/dashboard');
            exit;
        }

        $rememberedUsername = $_COOKIE['rememberedUser'] ?? '';
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function processLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']);

            $user = new User(null); // Instantiate User class
            if ($user->verifyCredentials($username, $password)) {
                $_SESSION['user'] = $username;

                if ($rememberMe) {
                    setcookie(
                        'rememberedUser', 
                        $username, 
                        time() + (30 * 24 * 60 * 60), 
                        '/tern_application/'
                    );
                } else {
                    setcookie('rememberedUser', '', time() - 3600, '/tern_application/');
                }

                header('Location: /tern_application/dashboard');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                header('Location: /tern_application/login');
                exit;
            }
        }

        header('Location: /tern_application/login');
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();
        session_destroy();
        setcookie('rememberedUser', '', time() - 3600, '/tern_application/');
        header('Location: /tern_application/login');
        exit;
    }

    private function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
}