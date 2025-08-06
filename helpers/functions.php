<?php
// Common helper functions

function redirect($url) {
    header("Location: " . SITE_URL . "/" . $url);
    exit;
}

function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function formatDate($date) {
    return date('d-m-Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('d-m-Y h:i A', strtotime($datetime));
}

function getStatusBadge($status) {
    $badges = [
        'pending' => '<span class="badge badge-warning">Pending</span>',
        'verified' => '<span class="badge badge-info">Verified</span>',
        'approved' => '<span class="badge badge-success">Approved</span>',
        'rejected' => '<span class="badge badge-danger">Rejected</span>'
    ];
    
    return $badges[$status] ?? '<span class="badge badge-secondary">Unknown</span>';
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
?>