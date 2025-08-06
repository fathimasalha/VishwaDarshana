<?php
class UploadHelper {
    private $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    private $maxSize = 5 * 1024 * 1024; // 5MB
    
    public function uploadFile($file, $folder) {
        // Check for errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload failed'];
        }
        
        // Check file size
        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'File too large (max 5MB)'];
        }
        
        // Check file type
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedTypes)) {
            return ['success' => false, 'error' => 'Invalid file type'];
        }
        
        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $ext;
        $uploadPath = 'assets/uploads/' . $folder . '/' . $filename;
        
        // Create directory if not exists
        $dir = dirname($uploadPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        // Move file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'path' => $uploadPath];
        }
        
        return ['success' => false, 'error' => 'Failed to move file'];
    }
}