<?php
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

header('Content-Type: application/json');

$response = [
    'success' => false,
    'data' => [],
    'total' => 0,
    'filtered' => 0,
    'draw' => $_GET['draw'] ?? 1
];

try {
    // Get and sanitize parameters
    $cat = mysqli_real_escape_string($db, $_GET['cat'] ?? '');
    $search = isset($_GET['search']) ? base64_decode($_GET['search']) : '';
    $filters = $_GET['filters'] ?? [];
    $start = intval($_GET['start'] ?? 0);
    $length = intval($_GET['length'] ?? 10);

    // Base query with JOIN
    $baseQuery = "FROM jobs_applied";

    // WHERE conditions
    $where = [];
    $params = [];
    $types = '';

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
    
    // Status condition
    if ($cat) {
        $where[] = "status = ?";
        $params[] = $cat;
        $types .= 's';
    }

    // Search condition
    if ($search) {
        $searchTerm = "%$search%";
        $where[] = "(firstname LIKE ? OR lastname LIKE ? OR middlename LIKE ? OR job_title LIKE ? OR client_name LIKE ? OR qualification LIKE ?)";
        array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $types .= 'ssssss';
    }

    // Filter conditions
    $filterFields = [        
        'job_title' => ['field' => 'job_title', 'operator' => '=', 'type' => 's'],
        'gender' => ['field' => 'gender', 'operator' => '=', 'type' => 's'],
        'qualification' => ['field' => 'qualification', 'operator' => '=', 'type' => 's'],
        'class_degree' => ['field' => 'class_degree', 'operator' => '=', 'type' => 's'],        
        'client_name' => ['field' => 'client_name', 'operator' => '=', 'type' => 's'],        
    ];

    foreach ($filterFields as $key => $config) {
        if (!empty($filters[$key])) {
            $where[] = "{$config['field']} {$config['operator']} ?";
            $params[] = $filters[$key];
            $types .= $config['type'];
        }
    }

   

    
    // Get total count
    $totalWhereClause = '';
    $totalParams = [];
    $totalTypes = '';
    if ($_SESSION['account_token']) {
        $totalWhereClause = 'WHERE account_token = ?';
        $totalParams[] = $_SESSION['account_token'];
        $totalTypes .= 's';
    }
    if ($cat) {
        if ($totalWhereClause) {
            $totalWhereClause .= ' AND status = ?';
        } else {
            $totalWhereClause = 'WHERE status = ?';
        }
        $totalParams[] = $cat;
        $totalTypes .= 's';
    }
    $countQuery = "SELECT COUNT(*) as total FROM jobs_applied $totalWhereClause";
    $stmt = mysqli_prepare($db, $countQuery);
    if ($totalParams) {
        mysqli_stmt_bind_param($stmt, $totalTypes, ...$totalParams);
    }
    mysqli_stmt_execute($stmt);
    $totalResult = mysqli_stmt_get_result($stmt);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $response['total'] = $totalRow['total'] ?? 0;

    // Get filtered count
    $filteredQuery = "SELECT COUNT(*) as filtered $baseQuery $totalWhereClause";
    $filteredStmt = mysqli_prepare($db, $filteredQuery);
    if ($totalParams) {
        mysqli_stmt_bind_param($filteredStmt, $totalTypes, ...$totalParams);
    }
    mysqli_stmt_execute($filteredStmt);
    $filteredResult = mysqli_stmt_get_result($filteredStmt);
    $filteredRow = mysqli_fetch_assoc($filteredResult);
    $response['filtered'] = $filteredRow['filtered']  ?? 0;

    // Main data query with pagination
    $limit = ($length == -1) ? '' : "LIMIT ?, ?";
    $orderBy = "ORDER BY id DESC";
    $dataQuery = "SELECT * $baseQuery $totalWhereClause $orderBy $limit";

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
        $row['date'] = long_date($row['date_applied']);        
        $row['filepath'] = get_val('credentials', 'candidate_id',$row['candidate_id'],'filepath');;
        $response['data'][] = $row;
    }

    $response['success'] = true;
    $response['query'] = $params;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
