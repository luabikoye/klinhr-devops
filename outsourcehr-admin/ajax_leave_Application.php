<?php
include('connection/connect.php');
require_once('inc/fns.php');

header('Content-Type: application/json');

$response = [
    'success' => false,
    'data' => [],
    'draw' => intval($_GET['draw'] ?? 1)
];

try {    
    $searchValue = $_GET['search']['name'] ?? '';
    $orderColumn = $_GET['order'][8]['column'] ?? 'id';
    $orderDir = $_GET['order'][8]['dir'] ?? 'desc';
    $orderBy = $columns[$orderColumn] ?? 'id';
    $client = $_GET['search']['client'] ?? '';
    $startDate = $_GET['search']['start_date'] ?? '';
    $endDate = $_GET['search']['end_date'] ?? '';
    $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
    $length = isset($_GET['length']) ? intval($_GET['length']) : 10;


    if ($_SESSION['privilege_user'] == 'administrator') {
        $where = "where leave_type != 'Leave Resumption'";
    } elseif ($_SESSION['privilege_user'] == 'ALL') {
        $where = "where leave_type != 'Leave Resumption'";
    } else {
        $where = "where access_type like '%" . search_leave_priviledge($_SESSION['privilege_user']) . "%' and leave_type != 'Leave Resumption'";
    }
    if (!empty($searchValue)) {
        $escapedSearch = mysqli_real_escape_string($db, $searchValue);
        $where .= " AND (
        names LIKE '%$escapedSearch%' 
        OR staff_id LIKE '%$escapedSearch%' 
        OR leave_type LIKE '%$escapedSearch%'
        OR status LIKE '%$escapedSearch%'
    )";
    }



    // No LIMIT — get all filtered rows
    $countQuery = "SELECT COUNT(*) as total FROM emp_leave_form $where";
    $countResult = mysqli_query($db, $countQuery);
    $totalRow = mysqli_fetch_assoc($countResult);
    $totalRecords = $totalRow['total'] ?? 0;

    $query = "SELECT * FROM emp_leave_form $where ORDER BY $orderBy $orderDir LIMIT $start, $length";
    $result = mysqli_query($db, $query);

    $response['data'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['short_date'] = short_date($row['letter_date']);
        $row['status2'] = fa_status($row['status']);
        $row['working_days'] = getWorkingDays($row['start_date'], $row['end_date']);
        $row['total_schedule'] = total_schedule($row['staff_id']);
        $row['get_names'] = get_names($row['staff_id']);
        $queryp = mysqli_query($db,"SELECT * FROM emp_leave_form WHERE staff_id='" . $row['staff_id'] . "' AND start_date like '%" . year() . "%' AND start_date > DATE('" . today() . "')");
        $rowp = mysqli_fetch_assoc($queryp);

        $row['rowp'] = $rowp ?: [];

        $response['data'][] = $row;
    }

    $response['success'] = true;
    $response['total'] = $totalRecords;
    $response['query'] = $query;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
