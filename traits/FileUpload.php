<?php
declare(strict_types=1);

trait FileUpload {
    private $uploadDir = '../uploads/';
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    private $maxSize = 2 * 1024 * 1024; // 2MB

    /**
     * Upload file with validation
     */
    public function uploadFile(array $file): array 
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['error' => 'File upload error.'];
            }
            if (!in_array($file['type'], $this->allowedTypes, true)) {
                return ['error' => 'Invalid file type.'];
            }
            if ($file['size'] > $this->maxSize) {
                return ['error' => 'File is too large.'];
            }

            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($fileExtension, $allowedExtensions, true)) {
                return ['error' => 'Invalid file extension.'];
            }

            if (!is_dir($this->uploadDir)) {
                mkdir($this->uploadDir, 0777, true);
            }

            $fileName = uniqid('upload_', true) . '.' . $fileExtension;
            $filePath = $this->uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return ['success' => 'File uploaded successfully.', 'path' => $filePath];
            }

            return ['error' => 'Failed to move uploaded file.'];
        } catch (Throwable $e) {
            error_log("File Upload Error: " . $e->getMessage(), 3, '../logs/system.log');
            return ['error' => 'Something went wrong.'];
        }
    }
}
?>