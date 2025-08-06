

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Admission Form - Vishwadarshana Educational Society</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admission-form.css">
    <!-- <link rel="stylesheet" href="assets/css/footer.css"> -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <div class="vd-form-admission-header">
        <h1>Student Admission Form</h1>
        <p>Academic Year 2024-25</p>
    </div>

    <!-- Form Container -->
    <div class="vd-form-container">
        <!-- Progress Bar -->
        <div class="vd-form-progress">
            <div class="vd-form-progress-step active" data-step="1">
                1
                <span>Personal</span>
            </div>
            <div class="vd-form-progress-step" data-step="2">
                2
                <span>Course</span>
            </div>
            <div class="vd-form-progress-step" data-step="3">
                3
                <span>Academic</span>
            </div>
            <div class="vd-form-progress-step" data-step="4">
                4
                <span>Payment</span>
            </div>
            <div class="vd-form-progress-step" data-step="5">
                5
                <span>Review</span>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Form -->
        <form id="admissionForm" method="POST" action="ajax/submit-admission.php" enctype="multipart/form-data">
            
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <!-- Section 1: Personal Information -->
            <div class="vd-form-section active" data-section="1">
                <h2 class="vd-form-section-title">Personal Information</h2>
            
                <div class="vd-form-row">
                    <div class="vd-form-group full-width">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="sa_name" id="sa_name" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-group">
                    <label>Address <span class="required">*</span></label>
                    <textarea name="sa_address" id="sa_address" rows="3" required></textarea>
                    <span class="vd-form-error-message"></span>
                </div>
                
                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>City</label>
                        <input type="text" name="sa_city" id="sa_city">
                    </div>
                    <div class="vd-form-group">
                        <label>State</label>
                        <input type="text" name="sa_state" id="sa_state" value="Karnataka">
                    </div>
                </div>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>PIN Code</label>
                        <input type="text" name="sa_pincode" id="sa_pincode" maxlength="6">
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Phone Number <span class="required">*</span></label>
                        <input type="tel" name="sa_phone" id="sa_phone" maxlength="10" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Date of Birth <span class="required">*</span></label>
                        <input type="text" name="sa_dob" id="sa_dob" placeholder="DD-MM-YYYY" maxlength="10" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Aadhar Number <span class="required">*</span></label>
                        <input type="text" name="sa_aadhar_number" id="sa_aadhar_number" maxlength="14" placeholder="XXXX XXXX XXXX" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Category <span class="required">*</span></label>
                        <select name="sa_category" id="sa_category" required>
                            <option value="">Select Category</option>
                            <option value="General">General</option>
                            <option value="OBC">OBC</option>
                            <option value="SC">SC</option>
                            <option value="ST">ST</option>
                        </select>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <h3 style="margin: 2rem 0 1rem; color: var(--primary);">Parents/Guardian Information</h3>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Mother's Name <span class="required">*</span></label>
                        <input type="text" name="sa_mother_name" id="sa_mother_name" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Father's Name <span class="required">*</span></label>
                        <input type="text" name="sa_father_name" id="sa_father_name" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-actions">
                    <button type="button" class="vd-form-btn vd-form-btn-secondary" disabled>
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="vd-form-btn vd-form-btn-primary" onclick="nextSection()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

             <!-- Section 2: Course Selection -->
             <div class="vd-form-section" data-section="2">
                <h2 class="vd-form-section-title">Course Selection</h2>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Course Applying For <span class="required">*</span></label>
                        <select name="sa_course" id="sa_course" required onchange="updateSubjectCombinations()">
                            <option value="">Select Course</option>
                            <option value="Science">Science</option>
                            <option value="Commerce">Commerce</option>
                        </select>
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Subject Combination <span class="required">*</span></label>
                        <select name="sa_subject_combination" id="sa_subject_combination" required disabled>
                            <option value="">First select course</option>
                        </select>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>First Language <span class="required">*</span></label>
                        <select name="sa_first_language" id="sa_first_language" required>
                            <option value="">Select Language</option>
                            <option value="English">English</option>
                            <option value="Kannada">Kannada</option>
                        </select>
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Second Language <span class="required">*</span></label>
                        <select name="sa_second_language" id="sa_second_language" required>
                            <option value="">Select Language</option>
                            <option value="Kannada">Kannada</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Sanskrit">Sanskrit</option>
                        </select>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-actions">
                    <button type="button" class="vd-form-btn vd-form-btn-secondary" onclick="previousSection()">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="vd-form-btn vd-form-btn-primary" onclick="nextSection()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Section 3: Academic Details & Facilities -->
            <div class="vd-form-section" data-section="3">
                <h2 class="vd-form-section-title">Academic Details & Additional Facilities</h2>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Marks in 9th/10th Exam</label>
                        <input type="number" name="sa_marks_obtained" id="sa_marks_obtained" min="0" max="999">
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Percentage (%)</label>
                        <input type="number" name="sa_percentage" id="sa_percentage" min="0" max="100" step="0.01">
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <h3 style="margin: 2rem 0 1rem; color: var(--primary);">Additional Facilities</h3>
                
                <div class="vd-form-checkbox-group">
                    <div class="vd-form-checkbox-item">
                        <input type="checkbox" name="hostel" id="hostel" value="1">
                        <label for="hostel" style="margin-bottom: 0;">Hostel</label>
                    </div>
                    <div class="vd-form-checkbox-item">
                        <input type="checkbox" name="bus" id="bus" value="1">
                        <label for="bus" style="margin-bottom: 0;">Bus</label>
                    </div>
                    <div class="vd-form-checkbox-item">
                        <input type="checkbox" name="midday_meals" id="midday_meals" value="1">
                        <label for="midday_meals" style="margin-bottom: 0;">Midday Meals</label>
                    </div>
                    <div class="vd-form-checkbox-item">
                        <input type="checkbox" name="yoga" id="yoga" value="1">
                        <label for="yoga" style="margin-bottom: 0;">Yoga</label>
                    </div>
                </div>

                <div class="vd-form-group" style="margin-top: 1.5rem;">
                    <label>Other Activities (Specify)</label>
                    <input type="text" name="sa_other_activities" id="sa_other_activities" placeholder="Enter other activities if any">
                </div>

                <div class="vd-form-actions">
                    <button type="button" class="vd-form-btn vd-form-btn-secondary" onclick="previousSection()">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="vd-form-btn vd-form-btn-primary" onclick="nextSection()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Section 4: Payment Information -->
            <div class="vd-form-section" data-section="4">
                <h2 class="vd-form-section-title">Payment Information</h2>

                <div class="vd-form-alert vd-form-alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Payment Instructions:</strong><br>
                    Please pay the admission fee of ₹500 through any UPI app or bank transfer to the following account:<br>
                    <strong>Account Name:</strong> Vishwadarshana Educational Society<br>
                    <strong>Account Number:</strong> 1234567890<br>
                    <strong>IFSC Code:</strong> SBIN0001234<br>
                    <strong>UPI ID:</strong> vishwadarshana@sbi
                </div>

                <div class="vd-form-row">
                    <div class="vd-form-group">
                        <label>Registered Mobile Number <span class="required">*</span></label>
                        <input type="tel" name="sa_payment_mobile" id="sa_payment_mobile" maxlength="10" pattern="[6-9][0-9]{9}" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                    <div class="vd-form-group">
                        <label>Transaction/UTR Number <span class="required">*</span></label>
                        <input type="text" name="sa_transaction_number" id="sa_transaction_number" required>
                        <span class="vd-form-error-message"></span>
                    </div>
                </div>

                <div class="vd-form-group">
                    <label>Upload Transaction Receipt <span class="required">*</span></label>
                    <div class="vd-form-file-upload">
                        <input type="file" name="receipt" id="receipt" accept=".pdf,.jpg,.jpeg,.png" required>
                        <label for="receipt" class="vd-form-file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i><br>
                            Click to upload receipt<br>
                            <small>PDF, JPG, PNG (Max 5MB)</small>
                        </label>
                    </div>
                    <span class="vd-form-error-message"></span>
                </div>

                <div class="vd-form-group" style="margin-top: 2rem;">
                    <div class="vd-form-checkbox-item" style="border: 2px solid var(--accent);">
                        <input type="checkbox" name="terms_accepted" id="terms_accepted" required>
                        <label for="terms_accepted" style="margin-bottom: 0;">
                            I accept the <a href="#" target="_blank">Terms & Conditions</a> and declare that all information provided is true and correct. <span class="required">*</span>
                        </label>
                    </div>
                    <span class="vd-form-error-message"></span>
                </div>

                <div class="vd-form-actions">
                    <button type="button" class="vd-form-btn vd-form-btn-secondary" onclick="previousSection()">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="vd-form-btn vd-form-btn-primary" onclick="nextSection()">
                        Review <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Section 5: Review & Submit -->
            <div class="vd-form-section" data-section="5">
                <h2 class="vd-form-section-title">Review Your Application</h2>

                <div class="vd-form-alert vd-form-alert-info">
                    <i class="fas fa-check-circle"></i> Please review all information carefully before submitting.
                </div>

                <div id="reviewContent">
                    <!-- Review content will be populated by JavaScript -->
                </div>

                <div class="vd-form-actions">
                    <button type="button" class="vd-form-btn vd-form-btn-secondary" onclick="previousSection()">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="submit" class="vd-form-btn vd-form-btn-success" id="submitBtn">
                        <i class="fas fa-paper-plane"></i> Submit Application
                    </button>
                </div>

                <div class="vd-form-spinner" id="loadingSpinner"></div>
            </div>


        </form>
    </div>

    <script src="assets/js/admission-form-validation.js"></script>
</body>
</html>

