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
    $cat = $_GET['cat'] ?? 'client';
    $single = $_GET['single'];    
    $columns = ['id', 'EmployeeID', 'firstname', 'surname', 'email_address', 'company_code', 'date_moved', 'mobile_phone_number', 'effective_date', 'location_code', 'salary'];
    $all = 'id,candidate_id,staff_id,firstname,surname,email_address,EmployeeID,mobile_phone_number,company_code,position_code,location_code,effective_date,salary';
    $orderColumn = $_GET['order'][0]['column'] ?? 'id';
    $orderDir = $_GET['order'][0]['dir'] ?? 'desc';
    $orderBy = $columns[$orderColumn] ?? 'id';

    if ($_SESSION['account_token']) {        
        if ($cat) {                
            $where = "WHERE completed = '$cat' and account_token ='" . $_SESSION['account_token'] . "'";
        }else{
            $where = "WHERE id = '$single' and account_token ='".$_SESSION['account_token']."'";
        }
        $query = "SELECT *
        FROM emp_staff_details
        WHERE completed = '$cat' and account_token ='" . $_SESSION['account_token'] . "'
        ORDER BY $orderBy $orderDir
        LIMIT 0, 500 ";
    }else{
        if ($cat) {
            $where = "WHERE completed = '$cat'";
        } else {
            $where = "WHERE id = '$single'";
        }
        $query = "SELECT *
        FROM emp_staff_details
        WHERE completed = '$cat'
        ORDER BY $orderBy $orderDir
        LIMIT 0, 500 ";
    }
  

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['status'] = VerificationStatus($row['candidate_id']);
        $response['data'][] = $row;
    }

    $response['success'] = true;
    $response['query'] = $query;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
