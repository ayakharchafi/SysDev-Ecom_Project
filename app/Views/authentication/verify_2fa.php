<!DOCTYPE html>
<html>
<head>
    <title>Two-Factor Authentication</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Two-Factor Authentication</div>
                    <div class="card-body">
                        <p>A verification code has been sent to your email address. Please enter it below to complete login.</p>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="/tern_app/SysDev-Ecom_Project/process-verify-2fa">
                            <div class="form-group">
                                <label for="code">Verification Code:</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>