<?php

// Add session start if not already there
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'vishwadarshana_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_URL', 'http://localhost/vishwadarshana');
define('APP_URL', SITE_URL . '/app');
define('SITE_NAME', 'Vishwadarshana Educational Society');
define('ADMIN_EMAIL', 'admin@vishwadarshana.edu');

// Paths
define('ROOT_PATH', __DIR__ . '/');
define('UPLOAD_PATH', ROOT_PATH . 'assets/uploads/');

// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-password');

// Session configuration
// ini_set('session.cookie_httponly', 1);
// ini_set('session.use_only_cookies', 1);
// ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS

// ini_set('session.cookie_lifetime', 86400);
// ini_set('session.gc_maxlifetime', 86400);
// ini_set('session.use_strict_mode', 1);
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
?>