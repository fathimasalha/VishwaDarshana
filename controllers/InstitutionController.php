<?php
require_once 'models/Database.php';

class InstitutionController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function centralSchool() {
        $pageTitle = "Central School - Vishwadarshana";
        $institution = "central-school";
        
        include 'views/layout/header.php';
        include 'views/institutions/central-school.php';
        include 'views/layout/footer.php';
    }
    
    public function puCollege() {
        $pageTitle = "PU College - Vishwadarshana";
        $institution = "pu-college";
        
        include 'views/layout/header.php';
        include 'views/institutions/pu-college.php';
        include 'views/layout/footer.php';
    }
    
    public function bedCollege() {
        $pageTitle = "B.Ed College - Vishwadarshana";
        $institution = "bed-college";
        
        include 'views/layout/header.php';
        include 'views/institutions/bed-college.php';
        include 'views/layout/footer.php';
    }
    
    public function bcaCollege() {
        $pageTitle = "BCA College - Vishwadarshana";
        $institution = "bca-college";
        
        include 'views/layout/header.php';
        include 'views/institutions/bca-college.php';
        include 'views/layout/footer.php';
    }
    
    public function nursingCollege() {
        $pageTitle = "Nursing College - Vishwadarshana";
        $institution = "nursing-college";
        
        include 'views/layout/header.php';
        include 'views/institutions/nursing-college.php';
        include 'views/layout/footer.php';
    }
    
    public function mediaSchool() {
        $pageTitle = "School of Media - Vishwadarshana";
        $institution = "media-school";
        
        include 'views/layout/header.php';
        include 'views/institutions/media-school.php';
        include 'views/layout/footer.php';
    }
}
?>