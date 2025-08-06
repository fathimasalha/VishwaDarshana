<!-- =====================================================
     ADMIN DASHBOARD VIEW
     File: views/admin/dashboard.php
     ===================================================== -->
     <h1 class="page-title">Dashboard</h1>

<!-- Statistics Cards -->
<div class="dashboard-cards">
    <div class="dashboard-card">
        <div class="card-icon bg-primary">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="card-content">
            <h3><?php echo $stats['total_applications']; ?></h3>
            <p>Total Applications</p>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon bg-warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3><?php echo $stats['pending_applications']; ?></h3>
            <p>Pending Review</p>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon bg-success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3><?php echo $stats['approved_applications']; ?></h3>
            <p>Approved</p>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon bg-danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="card-content">
            <h3>12</h3>
            <p>Rejected</p>
        </div>
    </div>
</div>

<!-- Recent Applications -->
<div class="admin-card">
    <div class="card-header">
        <h3>Recent Applications</h3>
        <a href="<?php echo SITE_URL; ?>/admin/admissions" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Form No.</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['recent_applications'] as $app): ?>
                <tr>
                    <td><?php echo $app->sa_form_number; ?></td>
                    <td><?php echo $app->sa_name; ?></td>
                    <td><?php echo $app->sa_course; ?></td>
                    <td><?php echo formatDate($app->sa_created_at); ?></td>
                    <td><?php echo getStatusBadge($app->sa_status); ?></td>
                    <td>
                        <a href="<?php echo SITE_URL; ?>/admin/viewAdmission/<?php echo $app->sa_id; ?>" class="btn btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>