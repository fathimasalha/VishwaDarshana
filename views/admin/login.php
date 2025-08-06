<!-- =====================================================
     ADMIN LOGIN VIEW
     File: views/admin/login.php
     ===================================================== -->
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="Logo">
                <h2>Admin Login</h2>
            </div>
            
            <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
            
            <form class="login-form" method="POST" action="<?php echo SITE_URL; ?>/admin/authenticate">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>
</body>
</html>