<!-- =====================================================
     ADMIN LAYOUT
     File: views/layout/admin-layout.php
     ===================================================== -->
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo-white.png" alt="Logo">
                <h3>Admin Panel</h3>
            </div>
            
            <nav class="sidebar-menu">
                <div class="menu-item">
                    <a href="<?php echo SITE_URL; ?>/admin/dashboard" class="menu-link <?php echo ($controller == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="<?php echo SITE_URL; ?>/admin/admissions" class="menu-link <?php echo ($controller == 'admissions') ? 'active' : ''; ?>">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Admissions</span>
                        <?php if (isset($stats['pending_applications']) && $stats['pending_applications'] > 0): ?>
                        <span class="menu-badge"><?php echo $stats['pending_applications']; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <div class="menu-item has-submenu">
                    <a href="#" class="menu-link">
                        <i class="fas fa-newspaper"></i>
                        <span>News & Events</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="submenu">
                        <a href="<?php echo SITE_URL; ?>/admin/news" class="menu-link">All News</a>
                        <a href="<?php echo SITE_URL; ?>/admin/news/add" class="menu-link">Add New</a>
                    </div>
                </div>
                
                <div class="menu-item has-submenu">
                    <a href="#" class="menu-link">
                        <i class="fas fa-images"></i>
                        <span>Gallery</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="submenu">
                        <a href="<?php echo SITE_URL; ?>/admin/gallery" class="menu-link">All Images</a>
                        <a href="<?php echo SITE_URL; ?>/admin/gallery/upload" class="menu-link">Upload</a>
                    </div>
                </div>
                
                <div class="menu-item">
                    <a href="<?php echo SITE_URL; ?>/admin/contacts" class="menu-link">
                        <i class="fas fa-envelope"></i>
                        <span>Contact Messages</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="<?php echo SITE_URL; ?>/admin/users" class="menu-link">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="<?php echo SITE_URL; ?>/admin/settings" class="menu-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <div class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <form class="search-form">
                        <input type="text" placeholder="Search...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="header-right">
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    
                    <div class="user-dropdown">
                        <div class="user-avatar">
                            <?php echo substr($_SESSION['admin_name'], 0, 1); ?>
                        </div>
                        <span><?php echo $_SESSION['admin_name']; ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    
                    <a href="<?php echo SITE_URL; ?>/admin/logout" class="btn btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- Content -->
            <div class="admin-content">