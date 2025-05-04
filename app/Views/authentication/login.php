<?php
  require __DIR__ . '/../../../locale.php';
  // echo $_SESSION['lang'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/globals.css" />
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="login-page">
      
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
          <?= $_SESSION['error'] ?>
          <?php unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <!-- Add form tag here (wrapper for entire content) -->
      <form method="POST" action="/tern_app/SysDev-Ecom_Project/login" class="login-form">
        <div class="div">
          <!-- Left Blue Section (unchanged) -->
          <div class="overlap-group">
            <img class="img" src="/tern_app/SysDev-Ecom_Project/public/img/tern_logo.png" alt="Tern Logo" />
          </div>

          <!-- Right Login Form (add name attributes) -->
          <div class="create-an-account">
            <div class="logo"></div>
            <div class="content">
              <div class="frame">
                <div class="text-wrapper"><?= _('Welcome to Login!')?></div>
              </div>

              <div class="frame-2">
                <div class="text-field">
                  <input 
                    class="label" 
                    id="user_name" 
                    name="user_name" 
                    placeholder="<?= _('Username') ?>" 
                    type="text"
                    value="<?= htmlspecialchars($rememberedUsername ?? '') ?>"
                  >
                </div>
                
                <div class="text-field">
                  <input 
                    class="label" 
                    id="password" 
                    name="password" 
                    placeholder="<?= _('Password') ?>"
                    type="password"
                  >
                  <div class="password-hide-see" id="togglePassword">
                    <img class="icon" src="/tern_app/SysDev-Ecom_Project/public/img/closed_eye.svg" alt="Eye Icon" />
                    <div class="text-wrapper-2">Show</div>
                  </div>
                </div>
              </div>

              <div class="button-wrapper">
                <!-- Change button type to submit -->
                <button type="submit" class="button" id="loginButton">
                  <div class="frame-4">
                    <div class="sign-up">Sign In</div>
                  </div>
                </button>
              </div>

              <div class="remember-me">
                <!-- Add name attribute to checkbox -->
                <input type="checkbox" id="rememberMe" name="remember_me" class="remember-checkbox">
                <label for="rememberMe" class="custom-checkbox">
                  <span class="checkmark">✓</span>
                  <span class="text-wrapper-3"><?= _('Remember me') ?></span>
                </label>
                <a href="#" class="text-wrapper-4" id="forgotPassword"><?= _('Forgot password') ?></a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <script src="/tern_app/SysDev-Ecom_Project/public/js/login.js"></script>
  </body>
</html>