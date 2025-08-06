<!-- =====================================================
     ADMISSIONS LIST VIEW
     File: views/admin/admissions/list.php
     ===================================================== -->
     <div class="page-header">
    <h1 class="page-title">Admission Applications</h1>
    <div class="page-actions">
        <button onclick="exportData('excel')" class="btn btn-secondary">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
        <button onclick="exportData('pdf')" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </div>
</div>

<!-- Filters -->
<div class="admin-card mb-20">
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="form-row">
                <div class="form-group">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <select name="course" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        <option value="Science">Science</option>
                        <option value="Commerce">Commerce</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <input type="date" name="from_date" placeholder="From Date">
                </div>
                
                <div class="form-group">
                    <input type="date" name="to_date" placeholder="To Date">
                </div>
                
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Applications Table -->
<div class="admin-card">
    <div class="card-body">
        <table class="data-table" data-sortable>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th data-sortable>Form No.</th>
                    <th data-sortable>Name</th>
                    <th data-sortable>Phone</th>
                    <th data-sortable>Course</th>
                    <th data-sortable>Date</th>
                    <th data-sortable>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admissions as $admission): ?>
                <tr>
                    <td><input type="checkbox" class="item-checkbox" value="<?php echo $admission->sa_id; ?>"></td>
                    <td><?php echo $admission->sa_form_number; ?></td>
                    <td><?php echo $admission->sa_name; ?></td>
                    <td><?php echo $admission->sa_phone; ?></td>
                    <td>
                        <span class="badge badge-primary"><?php echo $admission->sa_course; ?></span>
                        <br>
                        <small><?php echo $admission->sa_subject_combination; ?></small>
                    </td>
                    <td><?php echo formatDate($admission->sa_created_at); ?></td>
                    <td>
                        <select class="status-update" data-id="<?php echo $admission->sa_id; ?>" data-original="<?php echo $admission->sa_status; ?>">
                            <option value="pending" <?php echo ($admission->sa_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="verified" <?php echo ($admission->sa_status == 'verified') ? 'selected' : ''; ?>>Verified</option>
                            <option value="approved" <?php echo ($admission->sa_status == 'approved') ? 'selected' : ''; ?>>Approved</option>
                            <option value="rejected" <?php echo ($admission->sa_status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="<?php echo SITE_URL; ?>/admin/viewAdmission/<?php echo $admission->sa_id; ?>" class="btn btn-sm btn-primary" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="sendNotification(<?php echo $admission->sa_id; ?>)" class="btn btn-sm btn-secondary" title="Send Email">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <button onclick="deleteAdmission(<?php echo $admission->sa_id; ?>)" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Bulk Actions -->
        <div class="bulk-actions mt-20">
            <select id="bulkAction">
                <option value="">Bulk Actions</option>
                <option value="approve">Approve Selected</option>
                <option value="reject">Reject Selected</option>
                <option value="delete">Delete Selected</option>
            </select>
            <button id="bulkActionBtn" class="btn btn-primary">Apply</button>
        </div>
    </div>
</div>