<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('inc/fns.php');

// $id = $_POST['checkID'];
// $job_id = list_val('jobs_applied', 'id', 'firstname');

$sql = "select * from jobseeker where id = '" . $checkID[$i] . "'";
$result_1 = mysqli_query($db, $sql);
$row_1 = mysqli_fetch_array($result_1);
// $phone = $row_1['phone'];

$checkID = $_POST['checkID'];

for ($i = 0; $i < count($checkID); $i++) {
        $query = "select * from emp_staff_details where id = '" . $checkID[$i] . "'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        $email[] = $row['email_address'];
        $mobile_number[] = $row['mobile_phone_number'];
        $firstname[] = $row['firstname'];
        $lastname[] = $row['surname'];
        $client[] = $row['EmployeeID'];
        $scores[] = get_result($row['email_address']);
        $id[] = $row['id'];
}

//implode all extracted email & phone numbers	
$emails = implode(',', $email);
$mobile_numbers = implode(',', $mobile_number);
$firstnames = implode(',', $firstname);
$lastnames = implode(',', $lastname);
$clients = implode(',', $client);
$ids = implode(',', $id);

//create a session with the emails & phone numbers
echo json_encode(array($firstnames, $lastnames, $emails, $mobile_numbers, $clients, $ids, $checkID));
// echo $emails.$mobile_numbers.$firstnames.$lastnames.$clients.$ids;