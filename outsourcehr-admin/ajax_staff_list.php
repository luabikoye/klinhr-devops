<?php
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

header('Content-Type: application/json');

$response = [
    'success' => false,
    'data' => [],
    'draw' => intval($_GET['draw'] ?? 1)
];

try {
    // Column ordering map
    $columns = [
        0 => 'id',
        1 => 'staff_id',
        2 => 'firstname',
        3 => 'surname',
        4 => 'email_address',
        5 => 'position_code',
        6 => 'company_code',
        7 => 'mobile_phone_number'
    ];

    // Incoming values    
    $client = $_GET['search']['client'] ?? '';    
    $role = $_GET['search']['role'] ?? '';
    $orderColumn = $_GET['order'][0]['column'] ?? 0;
    $orderDir = $_GET['order'][0]['dir'] ?? 'desc';
    $orderBy = $columns[$orderColumn] ?? 'id';

    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
    $length = isset($_GET['length']) ? intval($_GET['length']) : 10;

    // Default WHERE
    $where = "where EmployeeID != ''";

    // Filter check
    $filters = array_filter($_GET['search'] ?? [], fn($val) => $val !== '');

    // If no filters and is Admin/Super Admin
    if (empty($filters) && ($_SESSION['privilege'] == 'Admin' || $_SESSION['privilege'] == 'Super Admin')) {
        $where = "WHERE EmployeeID != '' and staff = 'yes'";
    }

    // Global search
    if (!empty($searchValue)) {
        $escapedSearch = mysqli_real_escape_string($db, $searchValue);
        $where .= " AND (position_code LIKE '%$escapedSearch%' OR company_code LIKE '%$escapedSearch%' OR
    )";
    }

    if (!empty($client)) {
        $clientEscaped = mysqli_real_escape_string($db, $client);
        $where .= " AND company_code = '$clientEscaped'";
    }

    if (!empty($role)) {
        $roleEscaped = mysqli_real_escape_string($db, $role);
        $where .= " AND position_code = '$roleEscaped'";
    }


    // Count total rows
    $countQuery = "SELECT COUNT(*) as total FROM emp_staff_details $where";
    $countResult = mysqli_query($db, $countQuery);
    $totalRow = mysqli_fetch_assoc($countResult);
    $totalRecords = $totalRow['total'] ?? 0;

    // Paginated data query
    $query = "SELECT * FROM emp_staff_details $where ORDER BY $orderBy $orderDir LIMIT $start, $length";
    $result = mysqli_query($db, $query);

    // Prepare data
    $response['data'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['client_name'] = get_val('clients', 'client_code', $row['company_code'], 'client_name');
        $response['data'][] = $row;
    }

    $response['success'] = true;
    $response['total'] = $totalRecords;
    $response['query'] = $query; // For debugging
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
