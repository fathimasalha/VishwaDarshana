<!-- =====================================================
     EMAIL HELPER
     File: helpers/email.php
     ===================================================== -->
     <?php
function sendEmail($to, $subject, $message, $from = null) {
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // From header
    if ($from) {
        $headers .= "From: " . $from . "\r\n";
    } else {
        $headers .= "From: " . ADMIN_EMAIL . "\r\n";
    }
    
    // Reply-To header
    $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
    
    // Email template
    $template = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0A2845; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f4f4f4; }
            .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Vishwadarshana Educational Society</h1>
            </div>
            <div class="content">
                ' . $message . '
            </div>
            <div class="footer">
                <p>This is an automated email. Please do not reply directly to this email.</p>
                <p>&copy; 2024 Vishwadarshana Educational Society. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    // Send email
    return mail($to, $subject, $template, $headers);
}

// Send SMS function (placeholder - integrate with SMS gateway)
function sendSMS($phone, $message) {
    // Integrate with SMS gateway like Twilio, TextLocal, etc.
    // This is a placeholder function
    
    // Example for TextLocal
    /*
    $apiKey = 'YOUR_API_KEY';
    $sender = 'VISHWA';
    
    $data = array(
        'apikey' => $apiKey,
        'numbers' => '91' . $phone,
        'sender' => $sender,
        'message' => $message
    );
    
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
    */
    
    return true; // Placeholder return
}
?>
