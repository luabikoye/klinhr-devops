<?php
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

header('Content-Type: application/json');

$response = [
    'success' => false,
    'data' => [],
    'total' => 0,
    'draw' => $_GET['draw'] ?? 1
];

try {
    // Get and sanitize parameters    
    $search = isset($_GET['search']) ? base64_decode($_GET['search']) : '';
    $start = intval($_GET['start'] ?? 0);
    $length = intval($_GET['length'] ?? 10);

    // Base query with JOIN
    $baseQuery = " firstname, lastname, email, id, phone, status FROM jobseeker_signup";


    // WHERE conditions
    $where = [];
    $params = [];
    $types = '';


    // Search condition
    if ($search) {
        $searchTerm = "%$search%";
        $where[] = "(firstname LIKE ? OR lastname LIKE ?)";
        array_push($params, $searchTerm, $searchTerm);
        $types .= 'ss';
    }


    // Build WHERE clause
    $conditions = [];
    if ($_SESSION['account_token']) {
        $conditions[] = 'account_token = ?';
        $params[] = $_SESSION['account_token'];
        $types .= 's';
    }
    $conditions = array_merge($conditions, $where);

    $whereClause = '';
    if ($conditions) {
        $whereClause = 'WHERE ' . implode(' AND ', $conditions);
    }
    $filteredQuery = "SELECT COUNT(*) as filtered FROM jobseeker_signup $whereClause";
    $filteredStmt = mysqli_prepare($db, $filteredQuery);
    if ($params && $types) {
        mysqli_stmt_bind_param($filteredStmt, $types, ...$params);
    }
    mysqli_stmt_execute($filteredStmt);
    $filteredResult = mysqli_stmt_get_result($filteredStmt);
    $row = mysqli_fetch_assoc($filteredResult);
    $response['filtered'] = $row['filtered'] ?? 0;


    // Get total count
    $countParams = $params;
    $countTypes = $types;

    $countQuery = "SELECT COUNT(*) as total FROM jobseeker_signup $whereClause";
    $stmt = mysqli_prepare($db, $countQuery);

    if (!empty($countParams)) {
        mysqli_stmt_bind_param($stmt, $countTypes, ...$countParams);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $response['total'] = $row['total'];



    // // // Main data query with pagination
    $limit = ($length == -1) ? '' : "LIMIT ?, ?";
    $orderBy = "ORDER BY id DESC";
    $dataQuery = "SELECT $baseQuery $whereClause $orderBy $limit";

    $dataStmt = mysqli_prepare($db, $dataQuery);

    // Bind parameters for LIMIT if needed
    if ($limit) {
        array_push($params, $start, $length);
        $types .= 'ii';
    }

    if ($params) {
        mysqli_stmt_bind_param($dataStmt, $types, ...$params);
    }

    mysqli_stmt_execute($dataStmt);
    $dataResult = mysqli_stmt_get_result($dataStmt);

    while ($row = mysqli_fetch_assoc($dataResult)) {        
        $response['data'][] = $row;
    }

    $response['success'] = true;
    $response['dataQuery'] = $whereClause;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
