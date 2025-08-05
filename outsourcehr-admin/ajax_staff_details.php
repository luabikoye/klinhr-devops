<?php
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

// Only process if this is an AJAX request
if (isset($_GET['length'])) { // Using length as AJAX indicator
    header('Content-Type: application/json');

    try {
        // Get and sanitize parameters
        $cat = isset($_GET['cat']) ? $db->real_escape_string(base64_decode($_GET['cat'])) : '';
        $backlog = isset($_GET['backlog']) ? $db->real_escape_string(base64_decode($_GET['backlog'])) : '';
        $search = isset($_GET['search']) ? $db->real_escape_string($_GET['search']) : '';
        $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
        $length = isset($_GET['length']) ? (int)$_GET['length'] : 10;

        // Build WHERE conditions
        $where = [];
        $conditions = [];
        if ($_SESSION['account_token']) {
            $conditions[] = "account_token = '".$_SESSION['account_token']."'";           
        }
        if ($cat && !$backlog) {
            $where[] = "completed = '$cat'";
        } elseif ($backlog) {
            $where[] = "backlog = 'yes' AND completed = 'Y'";
        }

        if ($search) {
            $where[] = "(firstname LIKE '%$search%' OR surname LIKE '%$search%' OR email_address LIKE '%$search%' OR id LIKE '%$search%')";
        }

        // Build WHERE clause
       
        $conditions = array_merge($conditions, $where);

        $whereClause = '';
        if ($conditions) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }

        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM emp_staff_details $whereClause";
        $countResult = $db->query($countQuery);
        $totalRows = $countResult->fetch_assoc()['total'];

        // // Get paginated data
        $dataQuery = "SELECT * FROM emp_staff_details $whereClause ORDER BY id DESC LIMIT $start, $length";
        $result = $db->query($dataQuery);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $data,
            'total' => $totalRows,
            'query' => $dataQuery,
            'current_page' => floor($start / $length) + 1
        ]);
        exit();
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
        exit();
    }
}
