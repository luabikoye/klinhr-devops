<?php

session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');

if (!isset($_SERVER['HTTP_REFERER'])) {
    $data = array("status" => "error", "message" => "invalid request method");
}else{

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $candidate = $_SESSION['candidate_id'];
    $id = base64_decode($id);
    if (!$candidate) {
        $data = array("status" => "error", "message" => "Login to save this job");
    }else{

        $stmt = mysqli_query($db, "SELECT * FROM favourite WHERE jobs_id = '$id' AND candidate_id = '$candidate'");
        $num = mysqli_num_rows($stmt);
        if ($num == 0) {    
            $select = mysqli_query($db, "INSERT INTO favourite SET jobs_id = '$id', candidate_id = '$candidate'");
            if ($select) {
                $data = array("status" => "success", "message" => "Job added to saved jobs");
            } else {
                $data = array("status" => "success", "message" => "DB error");
            }
        }else {        
            $data = array("status" => "error", "message" => "Job Already saved");
        }
    }
} else {
    $data = array("status" => "error", "message" => "Request Page Error");
}

echo json_encode($data);
}