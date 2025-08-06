<?php
require_once 'models/Database.php';
require_once 'models/User.php';
require_once 'models/Admission.php';

class AdminController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        // Redirect to login if not authenticated
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . SITE_URL . '/admin/login');
            exit;
        }
        
        // Redirect to dashboard
        header('Location: ' . SITE_URL . '/admin/dashboard');
    }
    
    public function login() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: ' . SITE_URL . '/admin/dashboard');
            exit;
        }
        
        $pageTitle = "Admin Login - Vishwadarshana";
        include 'views/admin/login.php';
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . SITE_URL . '/admin/login');
            exit;
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $userModel = new User($this->db);
        $user = $userModel->authenticate($username, $password);
        
        if ($user) {
            $_SESSION['admin_id'] = $user->u_id;
            $_SESSION['admin_name'] = $user->u_full_name;
            $_SESSION['admin_role'] = $user->u_role;
            
            header('Location: ' . SITE_URL . '/admin/dashboard');
        } else {
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: ' . SITE_URL . '/admin/login');
        }
    }
    
    public function dashboard() {
        $this->checkAuth();
        
        // Get statistics
        $admissionModel = new Admission($this->db);
        $stats = [
            'total_applications' => $admissionModel->getTotalCount(),
            'pending_applications' => $admissionModel->getPendingCount(),
            'approved_applications' => $admissionModel->getApprovedCount(),
            'recent_applications' => $admissionModel->getRecent(5)
        ];
        
        $pageTitle = "Dashboard - Admin";
        include 'views/layout/admin-layout.php';
        include 'views/admin/dashboard.php';
    }
    
    public function admissions() {
        $this->checkAuth();
        
        $admissionModel = new Admission($this->db);
        $admissions = $admissionModel->getAll();
        
        $pageTitle = "Admissions - Admin";
        include 'views/layout/admin-layout.php';
        include 'views/admin/admissions/list.php';
    }
    
    public function viewAdmission($id) {
        $this->checkAuth();
        
        $admissionModel = new Admission($this->db);
        $admission = $admissionModel->getById($id);
        
        if (!$admission) {
            header('Location: ' . SITE_URL . '/admin/admissions');
            exit;
        }
        
        $pageTitle = "View Application - Admin";
        include 'views/layout/admin-layout.php';
        include 'views/admin/admissions/view.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . SITE_URL . '/admin/login');
    }
    
    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . SITE_URL . '/admin/login');
            exit;
        }
    }
}
?>