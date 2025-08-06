<!-- =====================================================
     VIEW ADMISSION DETAILS
     File: views/admin/admissions/view.php
     ===================================================== -->
     <div class="page-header">
    <h1 class="page-title">Application Details</h1>
    <div class="page-actions">
        <button onclick="printContent('applicationDetails')" class="btn btn-secondary">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="<?php echo SITE_URL; ?>/admin/admissions" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div id="applicationDetails">
    <!-- Application Status Card -->
    <div class="admin-card mb-20">
        <div class="card-body">
            <div class="application-status">
                <div class="status-item">
                    <strong>Form Number:</strong> <?php echo $admission->sa_form_number; ?>
                </div>
                <div class="status-item">
                    <strong>Status:</strong> <?php echo getStatusBadge($admission->sa_status); ?>
                </div>
                <div class="status-item">
                    <strong>Applied On:</strong> <?php echo formatDateTime($admission->sa_created_at); ?>
                </div>
                <div class="status-item">
                    <strong>Last Updated:</strong> <?php echo formatDateTime($admission->sa_updated_at); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Personal Information -->
    <div class="admin-card mb-20">
        <div class="card-header">
            <h3>Personal Information</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <label>Full Name:</label>
                    <p><?php echo $admission->sa_name; ?></p>
                </div>
                <div class="info-item">
                    <label>Date of Birth:</label>
                    <p><?php echo formatDate($admission->sa_dob); ?></p>
                </div>
                <div class="info-item">
                    <label>Phone:</label>
                    <p><?php echo $admission->sa_phone; ?></p>
                </div>
                <div class="info-item">
                    <label>Email:</label>
                    <p><?php echo $admission->sa_email ?: 'Not provided'; ?></p>
                </div>
                <div class="info-item">
                    <label>Aadhar Number:</label>
                    <p><?php echo $admission->sa_aadhar_number; ?></p>
                </div>
                <div class="info-item">
                    <label>Category:</label>
                    <p><?php echo $admission->sa_category; ?></p>
                </div>
                <div class="info-item">
                    <label>Address:</label>
                    <p><?php echo $admission->sa_address; ?>, <?php echo $admission->sa_city; ?>, <?php echo $admission->sa_state; ?> - <?php echo $admission->sa_pincode; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Parents Information -->
    <div class="admin-card mb-20">
        <div class="card-header">
            <h3>Parents/Guardian Information</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <label>Father's Name:</label>
                    <p><?php echo $admission->sa_father_name; ?></p>
                </div>
                <div class="info-item">
                    <label>Mother's Name:</label>
                    <p><?php echo $admission->sa_mother_name; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Information -->
    <div class="admin-card mb-20">
        <div class="card-header">
            <h3>Course Information</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <label>Course:</label>
                    <p><span class="badge badge-primary"><?php echo $admission->sa_course; ?></span></p>
                </div>
                <div class="info-item">
                    <label>Subject Combination:</label>
                    <p><?php echo $admission->sa_subject_combination; ?></p>
                </div>
                <div class="info-item">
                    <label>First Language:</label>
                    <p><?php echo $admission->sa_first_language; ?></p>
                </div>
                <div class="info-item">
                    <label>Second Language:</label>
                    <p><?php echo $admission->sa_second_language; ?></p>
                </div>
                <div class="info-item">
                    <label>10th Marks:</label>
                    <p><?php echo $admission->sa_marks_obtained ?: 'Not provided'; ?> (<?php echo $admission->sa_percentage ?: 'N/A'; ?>%)</p>
                </div>
                <div class="info-item">
                    <label>Facilities Required:</label>
                    <p>
                        <?php 
                        if ($admission->sa_facilities) {
                            $facilities = json_decode($admission->sa_facilities, true);
                            echo implode(', ', $facilities);
                        } else {
                            echo 'None';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment Information -->
    <div class="admin-card mb-20">
        <div class="card-header">
            <h3>Payment Information</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <label>Payment Mobile:</label>
                    <p><?php echo $admission->sa_payment_mobile; ?></p>
                </div>
                <div class="info-item">
                    <label>Transaction Number:</label>
                    <p><?php echo $admission->sa_transaction_number; ?></p>
                </div>
                <div class="info-item">
                    <label>Receipt:</label>
                    <p>
                        <a href="<?php echo SITE_URL; ?>/assets/uploads/<?php echo $admission->sa_receipt_path; ?>" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> View Receipt
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Admin Actions -->
    <div class="admin-card">
        <div class="card-header">
            <h3>Admin Actions</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo SITE_URL; ?>/admin/updateAdmission">
                <input type="hidden" name="id" value="<?php echo $admission->sa_id; ?>">
                
                <div class="form-group">
                    <label>Update Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" <?php echo ($admission->sa_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="verified" <?php echo ($admission->sa_status == 'verified') ? 'selected' : ''; ?>>Verified</option>
                        <option value="approved" <?php echo ($admission->sa_status == 'approved') ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo ($admission->sa_status == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea name="remarks" rows="4" class="form-control"><?php echo $admission->sa_remarks; ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                    <button type="button" onclick="sendNotification(<?php echo $admission->sa_id; ?>)" class="btn btn-secondary">
                        <i class="fas fa-envelope"></i> Send Email Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Closing admin-content div -->
            </div>
        </div>
    </div>
    
    <!-- Modal for notifications -->
    <div class="modal" id="notificationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Send Notification</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="notificationForm">
                    <input type="hidden" name="admission_id" id="notification_admission_id">
                    
                    <div class="form-group">
                        <label>Notification Type</label>
                        <select name="type" class="form-control">
                            <option value="status">Status Update</option>
                            <option value="reminder">Reminder</option>
                            <option value="custom">Custom Message</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Message (Optional)</label>
                        <textarea name="message" rows="4" class="form-control" placeholder="Leave empty to use default template"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
    <script>
        // Send notification function
        function sendNotification(admissionId) {
            document.getElementById('notification_admission_id').value = admissionId;
            document.getElementById('notificationModal').classList.add('active');
        }
        
        // Delete admission function
        function deleteAdmission(id) {
            if (confirm('Are you sure you want to delete this application?')) {
                fetch(`${SITE_URL}/ajax/delete-admission.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAdminMessage('success', 'Application deleted successfully');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAdminMessage('error', data.message || 'Failed to delete');
                    }
                });
            }
        }
    </script>
</body>
</html>