<!-- Views/authentication/two_factor_settings.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Two-Factor Authentication Settings</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Two-Factor Authentication Settings</div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <p>Two-factor authentication adds an extra layer of security to your account by requiring a verification code sent to your email in addition to your password.</p>
                        
                        <?php if ($twoFactorEnabled): ?>
                            <p>Two-factor authentication is currently <strong>enabled</strong>.</p>
                            <form method="post" action="/tern_app/SysDev-Ecom_Project/process-two-factor-settings">
                                <button type="submit" name="disable_2fa" class="btn btn-danger">Disable Two-Factor Authentication</button>
                            </form>
                        <?php else: ?>
                            <p>Two-factor authentication is currently <strong>disabled</strong>.</p>
                            <form method="post" action="/tern_app/SysDev-Ecom_Project/process-two-factor-settings">
                                <button type="submit" name="enable_2fa" class="btn btn-success">Enable Two-Factor Authentication</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>