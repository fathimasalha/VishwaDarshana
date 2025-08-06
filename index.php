<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
require_once 'config.php';

// Load helpers
require_once 'helpers/functions.php';

// Get the request
$request = $_GET['url'] ?? 'home';
$request = rtrim($request, '/');
$request = filter_var($request, FILTER_SANITIZE_URL);

// Parse the request
$parts = explode('/', $request);
$controller = $parts[0];
$action = $parts[1] ?? 'index';
$params = array_slice($parts, 2);

// Route to controller
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        call_user_func_array([$controllerInstance, $action], $params);
    } else {
        // 404 - Method not found
        header("HTTP/1.0 404 Not Found");
        include 'views/404.php';
    }
} else {
    // 404 - Controller not found
    header("HTTP/1.0 404 Not Found");
    include 'views/404.php';
}
?>