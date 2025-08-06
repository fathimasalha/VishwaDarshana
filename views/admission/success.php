<!-- =====================================================
     SUCCESS PAGE VIEW
     File: views/admission/success.php
     ===================================================== -->
     <div class="vd-form-page">
    <div class="vd-form-container">
        <div class="vd-form-container text-center">
            <div class="vd-form-success-icon">
                <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
            </div>
            
            <h1>Application Submitted Successfully!</h1>
            
            <div class="vd-form-success-message">
                <p>Dear <strong><?php echo $admission->sa_name; ?></strong>,</p>
                <p>Your admission application has been received successfully.</p>
                
                <div class="vd-form-number-box" style="background: #f0f0f0; padding: 20px; border-radius: 10px; margin: 30px 0;">
                    <h3>Your Form Number</h3>
                    <h2 style="color: var(--primary); font-size: 36px;"><?php echo $admission->sa_form_number; ?></h2>
                </div>
                
                <p>Please save this form number for future reference.</p>
                <p>We will contact you on <strong><?php echo $admission->sa_phone; ?></strong> regarding the admission process.</p>
            </div>
            
            <div class="vd-form-action-buttons" style="margin-top: 40px;">
                <button onclick="window.print()" class="vd-form-btn vd-form-btn-secondary">
                    <i class="fas fa-print"></i> Print Application
                </button>
                <a href="<?php echo SITE_URL; ?>" class="vd-form-btn vd-form-btn-primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</div>