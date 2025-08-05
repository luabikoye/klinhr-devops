<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('include/fns.php');

$id = $_POST['id'];

$query = "select * from emp_staff_details where id = '$id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
$email = $row['email_address'];
$mobile_number = $row['mobile_phone_number'];
$firstname = $row['firstname'];
$lastname = $row['surname'];
// $client = $row['EmployeeID'];
$id = $row['id'];
$position = $row['position_code'];
$scores = get_result($row['email_address']);
$staff_id = ($row['staff_id']);

$client_name = decode_client_name($row['company_code']);
$client = $row['company_code'];

$name = $firstname . ' ' . $lastname;

//create a session with the emails & phone numbers
echo json_encode(array($name, $email, $mobile_number, $client_name, $id, $score, $position, $client, $staff_id));
