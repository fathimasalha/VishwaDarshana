<!-- =====================================================
     HEADER VIEW FILE - Enhanced
     File: views/layout/header.php
     ===================================================== -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Vishwadarshana Educational Society'; ?></title>
    
    <!-- CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/responsive.css">
</head>
<body>
    <!-- Header -->
    <header>
        <!-- <div class="header-top">
            <div class="container">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> 97409 55236</span>
                    <span><i class="fas fa-envelope"></i> info@vishwadarshana.edu</span>
                    <span><i class="fas fa-map-marker-alt"></i> Yellapura, UK</span>
                </div>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div> -->
        
    <!-- Navigation -->
    <nav id="nav">
        <div class="nav-container">
            <!-- Logo with Home Link -->
            <a href="<?php echo SITE_URL; ?>/" class="logo-link" title="Go to Homepage">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo/vishwadarshana_logo.webp" alt="Vishwadarshana Educational Society" class="logo">
            </a>
            
            <div class="nav-menu">
                <ul class="nav-links">
                    <li><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/#about">About</a></li>
                    
                    <!-- Our Institutes Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Our Institutes</a>
                        <ul class="dropdown-menu">
                            <a href="<?php echo SITE_URL; ?>/institution/centralSchool">Central School</a>
                            <a href="<?php echo SITE_URL; ?>/institution/puCollege">PU College</a>
                            <a href="<?php echo SITE_URL; ?>/b-ed-college">B.Ed College</a>
                            <a href="<?php echo SITE_URL; ?>/bca-college">BCA College </a>
                            <a href="<?php echo SITE_URL; ?>/nursing-college">Nursing College</a>      
                            <a href="<?php echo SITE_URL; ?>/school-of-media">School of Media</a>
                        
                        </ul>
                    </li>
                    
                    <li><a href="<?php echo SITE_URL; ?>/news-events">News & Events</a></li>
                    <!-- <li><a href="#features">Features</a></li>
                    <li><a href="#testimonials">Community</a></li>
                    <li><a href="#journey">Journey</a></li>
                    <li><a href="#updates">Updates</a></li> -->
                    <li><a href="<?php echo SITE_URL; ?>/#contact">Contact</a></li>
                </ul>
                
                <button class="menu-btn" id="menuBtn" aria-label="Toggle mobile menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-menu-links">
            <li><a href="<?php echo SITE_URL; ?>/">Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>/#about">About</a></li>
            
            <!-- Mobile Dropdown for Our Institutes -->
            <li class="mobile-dropdown">
                <a href="#" class="mobile-dropdown-toggle">Our Institutes</a>
                <div class="mobile-dropdown-menu">
                    <a href="<?php echo SITE_URL; ?>/central-school">Central School</a>
                    <a href="<?php echo SITE_URL; ?>/pu-college">PU College</a>
                    <a href="<?php echo SITE_URL; ?>/b-ed-college">B.Ed College</a>
                    <a href="<?php echo SITE_URL; ?>/bca-college">BCA College </a>
                    <a href="<?php echo SITE_URL; ?>/nursing-college">Nursing College</a>      
                    <a href="<?php echo SITE_URL; ?>/school-of-media">School of Media</a>
                    
                </div>
            </li>
            
            <li><a href="<?php echo SITE_URL; ?>/news-events">News & Events</a></li>
            <li><a href="<?php echo SITE_URL; ?>/#contact">Contact</a></li>
        </ul>
    </div>
        
    </header>

    <!-- JavaScript for Header Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.getElementById('nav');
            const menuBtn = document.getElementById('menuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

            // Header scroll effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
            });

            // Mobile menu toggle
            function toggleMobileMenu() {
                menuBtn.classList.toggle('active');
                mobileMenu.classList.toggle('active');
                mobileMenuOverlay.classList.toggle('active');
                document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
            }

            // Close mobile menu
            function closeMobileMenu() {
                menuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                document.body.style.overflow = '';
                
                // Close all mobile dropdowns
                mobileDropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }

            // Event listeners
            menuBtn.addEventListener('click', toggleMobileMenu);
            mobileMenuOverlay.addEventListener('click', closeMobileMenu);

            // Mobile dropdown functionality
            mobileDropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.mobile-dropdown-toggle');
                
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                    
                    // Close other dropdowns
                    mobileDropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove('active');
                        }
                    });
                });
            });

            // Close mobile menu on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeMobileMenu();
                }
            });

            // Prevent dropdown menu from closing when clicking inside
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        const headerHeight = nav.offsetHeight;
                        const targetPosition = target.offsetTop - headerHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        closeMobileMenu();
                    }
                });
            });
        });
    </script>