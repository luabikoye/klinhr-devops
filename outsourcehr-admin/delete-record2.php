<?php
header('Content-Type: application/json');

// Configure session security
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,  // If your site uses HTTPS
    'httponly' => true  // Set httponly flag
]);

session_start();

// Check if user is logged in
if (!isset($_SESSION['Klin_admin_user'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized: Please login first',
        'login_required' => true
    ]);
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

// Get and sanitize input parameters
$id = filter_var($_GET['id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
$tab = filter_var($_GET['tab'] ?? null, FILTER_SANITIZE_STRING);
$permit = isset($_GET['permit']) ? base64_decode($_GET['permit']) : null;
$return = filter_var($_GET['return'] ?? null, FILTER_SANITIZE_URL);

// Validate required parameters
if (!$id || !$tab) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

// Check permissions
if (privilege() == 'Super Admin' || privilege() == 'Admin' || $permit == 'can delete') {
    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM $tab WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . mysqli_error($db)
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Log the activity
        activity_log($_SESSION['klin_admin_email'], "deleted a record in the $tab table");

        echo json_encode([
            'success' => true,
            'message' => 'Record deleted successfully',
            'redirect' => $return  // Let client-side handle the redirect
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Delete failed: ' . mysqli_error($db)
        ]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'You do not have the right privilege to delete this item',
        'privilege_required' => true
    ]);
}
