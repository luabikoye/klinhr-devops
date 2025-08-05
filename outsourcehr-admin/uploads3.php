<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Replace with your AWS credentials and region
$credentials = [
    'version' => 'latest',
    'region'  => 'us-west-2',
    'credentials' => [
        'key'    => 'AKIAWMMZBL2XTD5SS7UO',
        'secret' => 'rO+YHBnjlK8m1ekK5Ts2cLU40mkZXcFE6Y2oT9E4',
    ]
];

// Replace with your S3 bucket name
// $bucketName = 'outsourcehr';

// Replace with the desired S3 key (path) for the file
// $s3Folder = 'uploads/';

// Replace with the path to your local file
// $localFilePath = 'jobseeker/images/jobs/';


try {
    // Create an S3 client
    $s3Client = new S3Client($credentials);

    // TO MOVE A FILE IN A FOLDER
    // Upload the file to S3
    // $result = $s3Client->putObject([
    //     'Bucket' => $bucketName,
    //     'Key'    => $s3Folder,
    //     'SourceFile' => $localFilePath,
    // ]);
    // TO MOVE A FILE IN A FOLDER


    // TO UPLOAD A FILE
    if (isset($_FILES['file'])) {
        // Upload the file directly to S3
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key'    => 'uploads/' . $fileName,
            'Body'   => fopen($uploadedFile, 'rb'),
        ]);
        // TO UPLOAD A FILE

        echo "File uploaded successfully to Amazon S3. Object URL: {$result['ObjectURL']}";
    } else {
        echo "Error: File upload failed.";
    }

    // echo "File uploaded successfully to Amazon S3. Object URL: {$result['ObjectURL']}";
} catch (AwsException $e) {
    echo "Error: " . $e->getMessage();
}




// // TO MOVE ALL FILES IN A FOLDER
// try {
//     // Create an S3 client
//     $s3Client = new S3Client($credentials);

//     // Get all files and subdirectories inside the local folder
//     $files = new RecursiveIteratorIterator(
//         new RecursiveDirectoryIterator($localFilePath),
//         RecursiveIteratorIterator::SELF_FIRST
//     );

//     foreach ($files as $file) {
//         if (!$file->isDir()) {
//             // Calculate the relative path to the file
//             $relativePath = substr($file->getPathname(), strlen($localFilePath));

//             // Normalize the path separator to forward slash '/'
//             $relativePath = str_replace('\\', '/', $relativePath);

//             // Upload the file to S3
//             $result = $s3Client->putObject([
//                 'Bucket' => $bucketName,
//                 'Key'    => $s3Folder . $relativePath,
//                 'SourceFile' => $file->getPathname(),
//             ]);

//             echo "Uploaded: {$file->getPathname()} to Amazon S3. Object URL: {$result['ObjectURL']}\n";
//         }
//     }

//     echo "Folder upload completed successfully!";
// } catch (AwsException $e) {
//     echo "Error: " . $e->getMessage();
// }
// TO MOVE ALL FILES IN A FOLDER
