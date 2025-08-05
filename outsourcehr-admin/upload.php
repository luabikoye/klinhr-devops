<?php
include('inc/fn.php');

// Check if file was uploaded without errors
if (!isset($_FILES['try']) || $_FILES['try']['error'] !== UPLOAD_ERR_OK) {
    die("Error: No file uploaded or upload error occurred");
}

$file = $_FILES['try'];

// Validate file
if ($file['size'] > 5000000) { // 5MB limit
    die("Error: File is too large");
}

$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
if (!in_array($file['type'], $allowedTypes)) {
    die("Error: Invalid file type");
}

// Prepare upload
$path = time() . '_' . basename($file['name']); // More secure filename
$file_name = strtolower($path);
$file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

// Upload to S3
$bucketName = 'klinhr-demo';
$s3Folder = "testing/";
$s3Upload = s3Upload($bucketName, $file_name, $file['tmp_name'], $s3Folder);

if ($s3Upload !== 'error') {
    echo 'File uploaded successfully! URL: ' . $s3Upload;
} else {
    echo "Error uploading file";
}
