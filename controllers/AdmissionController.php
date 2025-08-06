<?php
require_once 'models/Database.php';
require_once 'models/Admission.php';
require_once 'helpers/upload.php';
require_once 'helpers/email.php';

class AdmissionController {
    private $db;
    private $admissionModel;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->admissionModel = new Admission($this->db);
    }
    
    public function index() {
        $pageTitle = "Admission Form - Vishwadarshana";
        
        include 'views/layout/header.php';
        include 'views/admission/form.php';
        include 'views/layout/footer.php';
    }

    public function form() {
        // Generate CSRF token
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        require 'views/admission/form.php';
    }
    
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . SITE_URL . '/admission');
            exit;
        }
        
        // Validate form data
        $errors = $this->validateForm($_POST);
        
        // Handle file upload
        if (empty($errors) && isset($_FILES['receipt'])) {
            $uploadResult = uploadFile($_FILES['receipt'], 'receipts');
            if (!$uploadResult['success']) {
                $errors[] = $uploadResult['error'];
            } else {
                $_POST['receipt_path'] = $uploadResult['path'];
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . SITE_URL . '/admission');
            exit;
        }
        
        // Save to database
        $formNumber = $this->admissionModel->create($_POST);
        
        if ($formNumber) {
            // Send confirmation email
            $this->sendConfirmationEmail($_POST['email'], $formNumber, $_POST['name']);
            
            // Redirect to success page
            header('Location: ' . SITE_URL . '/admission/success/' . $formNumber);
        } else {
            $_SESSION['errors'] = ['Failed to submit application. Please try again.'];
            header('Location: ' . SITE_URL . '/admission');
        }
    }
    
    public function success() {
        $formNumber = $_GET['form'] ?? '';
        
        if (empty($formNumber)) {
            header('Location: index.php?controller=admission&action=form');
            exit;
        }
        
        $admission = $this->admissionModel->getByFormNumber($formNumber);
        
        if (!$admission) {
            header('Location: index.php?controller=admission&action=form');
            exit;
        }
        
        require 'views/admission/success.php';
    }
    
    private function validateForm($data) {
        $errors = [];
        
        // Required fields
        $required = ['name', 'phone', 'dob', 'aadhar_number', 'category', 'mother_name', 
                    'father_name', 'course', 'subject_combination', 'first_language', 
                    'second_language', 'payment_mobile', 'transaction_number'];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }
        
        // Validate phone
        if (!empty($data['phone']) && !preg_match('/^[0-9]{10}$/', $data['phone'])) {
            $errors[] = 'Invalid phone number';
        }
        
        // Validate Aadhar
        if (!empty($data['aadhar_number']) && !preg_match('/^[0-9]{12}$/', str_replace(' ', '', $data['aadhar_number']))) {
            $errors[] = 'Invalid Aadhar number';
        }
        
        return $errors;
    }
    
    private function sendConfirmationEmail($email, $formNumber, $name) {
        $subject = "Application Received - Vishwadarshana";
        $message = "
        <h2>Application Received Successfully</h2>
        <p>Dear $name,</p>
        <p>Your application has been received successfully.</p>
        <p><strong>Form Number:</strong> $formNumber</p>
        <p>Please save this form number for future reference.</p>
        <p>We will contact you soon regarding the admission process.</p>
        <br>
        <p>Best Regards,<br>Vishwadarshana Educational Society</p>
        ";
        
        sendEmail($email, $subject, $message);
    }
}
?>