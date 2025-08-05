<?php
include('connection/connect.php');
require_once('inc/fns.php');
$pay_token = $_GET['token'];
$search = $_GET['search'] ?? '';
$limit = (int)($_GET['limit'] ?? 10);
$page = (int)($_GET['page'] ?? 1);
$offset = ($page - 1) * $limit;

// Base Query
$where = "WHERE pay_token = '$pay_token'";
if (!empty($search)) {
    $search = mysqli_real_escape_string($db, $search);
    $where .= " AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%' OR position LIKE '%$search%')";
}

$totalQuery = "SELECT COUNT(*) as total FROM employees $where";
$totalRes = mysqli_query($db, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalRes);
$total = $totalRow['total'];

// Data Query
$dataQuery = "SELECT * FROM employees $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$dataRes = mysqli_query($db, $dataQuery);
$employees = [];
while ($row = mysqli_fetch_assoc($dataRes)) {
    $row['salary'] = number_format($row['salary'], 2);
    $row['paye'] = number_format($row['paye'], 2);
    $row['pension'] = number_format($row['pension'], 2);
    $email = $row['email'];

    $allowsQuery = mysqli_query($db, query: "SELECT * FROM payroll WHERE pay_token = '$pay_token' AND email = '$email'");
    $allows = mysqli_fetch_assoc($allowsQuery);

    $row['allowance'] = $allows ?: [];
    
    $employees[] = $row;
}

// JSON Response
echo json_encode([
    'data' => $employees,
    'total' => $total,
    'query' => $dataQuery,
    'page' => $page,
    'limit' => $limit,
]);
