<?php
require_once 'models/Database.php';
require_once 'models/News.php';
require_once 'models/Gallery.php';

class HomeController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        // Get latest news
        $newsModel = new News($this->db);
        $latestNews = $newsModel->getLatest(3);
        
        // Get gallery items
        $galleryModel = new Gallery($this->db);
        $galleryItems = $galleryModel->getFeatured(6);
        
        // Load view
        $pageTitle = "Home - Vishwadarshana Educational Society";
        include 'views/layout/header.php';
        include 'views/home/index.php';
        include 'views/layout/footer.php';
    }
}
?>