<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,  // If your site uses HTTPS
    'httponly' => true  // Set httponly flag
]);

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');


$clients = $_POST['clients'];
$location = $_POST['location'];
$id_format = $_POST['id_format'];

$query = "select * from emp_staff_details where company_code = '" . $clients . "' and staff_id != '' order by staff_serial_no desc";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
$last_staff_id = $row['staff_id'];

echo staff_id($last_staff_id, $location);
