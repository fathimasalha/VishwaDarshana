<?php
session_start();
require_once '../config.php';
require_once '../models/Database.php';
require_once '../models/Admission.php';
require_once '../helpers/upload.php';
require_once '../helpers/email.php';

header('Content-Type: application/json');

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Validate form data
$errors = [];

// Full name validation
if (!preg_match('/^[a-zA-Z\s]+$/', $_POST['sa_name'])) {
    $errors[] = 'Full name must contain only alphabets';
}

// Phone validation
if (!preg_match('/^[6-9]\d{9}$/', $_POST['sa_phone'])) {
    $errors[] = 'Invalid phone number';
}

// PIN code validation
if (!empty($_POST['sa_pincode']) && !preg_match('/^\d{6}$/', $_POST['sa_pincode'])) {
    $errors[] = 'PIN code must be 6 digits';
}

// Aadhar validation
$aadhar = str_replace(' ', '', $_POST['sa_aadhar_number']);
if (strlen($aadhar) !== 12) {
    $errors[] = 'Aadhar number must be 12 digits';
}

// Date validation
if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $_POST['sa_dob'])) {
    $errors[] = 'Date must be in DD-MM-YYYY format';
} else {
    // Convert DD-MM-YYYY to YYYY-MM-DD for database
    $parts = explode('-', $_POST['sa_dob']);
    $_POST['sa_dob'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
}

// Parent names validation
if (!preg_match('/^[a-zA-Z\s]+$/', $_POST['sa_mother_name'])) {
    $errors[] = 'Mother name must contain only alphabets';
}

if (!preg_match('/^[a-zA-Z\s]+$/', $_POST['sa_father_name'])) {
    $errors[] = 'Father name must contain only alphabets';
}

// If errors, return
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
    exit;
}

// Handle file upload
$uploadHelper = new UploadHelper();
$receiptPath = '';

if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === 0) {
    $uploadResult = $uploadHelper->uploadFile($_FILES['receipt'], 'receipts');
    if ($uploadResult['success']) {
        $receiptPath = $uploadResult['path'];
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload receipt: ' . $uploadResult['error']]);
        exit;
    }
}

// Process facilities JSON
$facilities = [];
if (isset($_POST['hostel'])) $facilities['hostel'] = true;
if (isset($_POST['bus'])) $facilities['bus'] = true;
if (isset($_POST['midday_meals'])) $facilities['midday_meals'] = true;
if (isset($_POST['yoga'])) $facilities['yoga'] = true;

$_POST['sa_facilities'] = json_encode($facilities);
$_POST['sa_receipt_path'] = $receiptPath;
$_POST['sa_ip_address'] = $_SERVER['REMOTE_ADDR'];
$_POST['sa_browser_info'] = $_SERVER['HTTP_USER_AGENT'];

// Generate form number
$_POST['sa_form_number'] = 'VD' . date('Y') . sprintf('%05d', rand(1, 99999));

// Save to database
$database = new Database();
$admission = new Admission($database);

$result = $admission->create($_POST);

if ($result) {
    // Send confirmation email
    $emailHelper = new EmailHelper();
    $emailHelper->sendAdmissionConfirmation($_POST['sa_email'], $_POST);
    
    echo json_encode([
        'success' => true,
        'form_number' => $_POST['sa_form_number']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit application']);
}