<!-- =====================================================
     CONTACT CONTROLLER
     File: controllers/ContactController.php
     ===================================================== -->
     <?php
require_once 'models/Database.php';
require_once 'models/Contact.php';
require_once 'helpers/email.php';

class ContactController {
    private $db;
    private $contactModel;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->contactModel = new Contact($this->db);
    }
    
    public function index() {
        $pageTitle = "Contact Us - Vishwadarshana";
        
        include 'views/layout/header.php';
        include 'views/contact/index.php';
        include 'views/layout/footer.php';
    }
    
    public function submit() {
        if (!isPost()) {
            redirect('contact');
        }
        
        // Validate form
        $errors = [];
        $required = ['name', 'email', 'phone', 'message'];
        
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = ucfirst($field) . ' is required';
            }
        }
        
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        }
        
        if (!empty($errors)) {
            $_SESSION['contact_errors'] = $errors;
            $_SESSION['contact_data'] = $_POST;
            redirect('contact');
        }
        
        // Save to database
        $_POST['source'] = 'contact-page';
        
        if ($this->contactModel->create($_POST)) {
            // Send email notification to admin
            $adminMessage = "
                <h3>New Contact Form Submission</h3>
                <p><strong>Name:</strong> {$_POST['name']}</p>
                <p><strong>Email:</strong> {$_POST['email']}</p>
                <p><strong>Phone:</strong> {$_POST['phone']}</p>
                <p><strong>Subject:</strong> {$_POST['subject']}</p>
                <p><strong>Message:</strong><br>{$_POST['message']}</p>
            ";
            
            sendEmail(ADMIN_EMAIL, 'New Contact Form Submission', $adminMessage);
            
            // Send auto-response to user
            $userMessage = "
                <h3>Thank you for contacting us!</h3>
                <p>Dear {$_POST['name']},</p>
                <p>We have received your message and will get back to you soon.</p>
                <p>Best Regards,<br>Vishwadarshana Educational Society</p>
            ";
            
            sendEmail($_POST['email'], 'Thank you for contacting Vishwadarshana', $userMessage);
            
            $_SESSION['contact_success'] = 'Your message has been sent successfully!';
        } else {
            $_SESSION['contact_errors'] = ['Failed to send message. Please try again.'];
        }
        
        redirect('contact');
    }
}
?>