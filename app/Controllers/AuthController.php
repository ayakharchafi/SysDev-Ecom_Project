<?php
namespace controllers;
use models\User;

class AuthController {
    public function showLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($this->isLoggedIn()) {
            header('Location: /tern_app/SysDev-Ecom_Project/dashboard');
            exit;
        }

        $rememberedUsername = $_COOKIE['rememberedUser'] ?? '';
        require_once __DIR__ . '/../Views/authentication/login.php';
    }

    public function processLogin() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['user_name'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']);

            // Debug: Check received credentials
            error_log("Login attempt: $username / $password");

            $user = new User();
            $user->readByUsername($username);

            if ($user->verifyCredentials($password)) {
                $_SESSION['pending_user_id'] = $user->getUserId();
                $_SESSION['pending_username'] = $username;
                $_SESSION['remember_me'] = $rememberMe;

                if($user->getEnabled2FA()) {
                    $code = $user->generateTwoFactorCode();
                    $user->sendTwoFactorEmail($code);

                    $_SESSION['awaiting_2fa'] = true;
                    header('Location:/tern_app/SysDev-Ecom_Project/verify-2fa');
                    exit;
                } else {
                    $this->completeLogin($user->getUserId(), $username, $rememberMe); 
                }
            } else {
                $_SESSION['error'] = "Invalid credentials";
                error_log("Login FAILED: $username");
                header('Location: /tern_app/SysDev-Ecom_Project/login');
                exit;
            }
        }

        header('Location: /tern_app/SysDev-Ecom_Project/login');
        exit;
    }

    public function showVerify2FA() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['awaiting_2fa']) || !isset($_SESSION['pending_user_id'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }

        require_once __DIR__ . '/../Views/authentication/verify_2fa.php';
    }

    public function processVerify2FA() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['awaiting_2fa']) || !isset($_SESSION['pending_user_id'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $userId = $_SESSION['pending_user_id'];

            $user = new User();
            $user->setUSerId($userId);
            $user->readOne();

            if ($user->verifyTwoFactorCode($code)) {
                $user->clearTwoFactorCode();
                $this->completeLogin($userId, $_SESSION['pending_username'], $_SESSION['remember_me'] ?? false);
            } else {
                $_SESSION['error'] = "Invalid verification code";
                header('Location: /tern_app/SysDev-Ecom_Project/verify-2fa');
                exit;
            }
        }

        header('Location: /tern_app/SysDev-Ecom_Project/login');
        exit;
    }

    private function completeLogin($userID, $username, $rememberMe) {
        $_SESSION['user_id'] = $userID;
        $_SESSION['user'] = $username;

        unset($_SESSION['pending_user_id']);
        unset($_SESSION['pending_username']);
        unset($_SESSION['awaiting_2fa']);
        unset($_SESSION['remember_me']);

        error_log("Login SUCCESS: $username");

        if ($rememberMe) {
            setcookie('rememberedUser', $username, time() + (30 * 24 * 60 * 60), '/tern_app/SysDev-Ecom_Project/');
        }

        header('Location: /tern_app/SysDev-Ecom_Project/dashboard');
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
        header('Location: /tern_app/SysDev-Ecom_Project/login');
        exit;
    }

    private function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    public function showTwoFactorSettings() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this-isLoggedIn()) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }

        $user = new User();
        $user->readByUsername($_SESSION['user']);
        $twoFactorEnabled = $user->getEnabled2FA();

        require_once __DIR__ . '/../Views/authentication/two_factor_settings.php';
    }

    public function processTwoFactorSettings() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!$this->isLoggedIn()) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->readByUsername($_SESSION['user']);
            
            if (isset($_POST['enable_2FA'])) {
                $user->enableTwoFactor();
                // echo "Two-factor authentication has been enabled.";
            } elseif (isset($_POST['disable_2fa'])) {
                $user->disableTwoFactor();
                //echo "Two-factor authentication has been disabled.";
            }
        }
        
        header('Location: /tern_app/SysDev-Ecom_Project/two-factor-settings');
        exit;
    }
}