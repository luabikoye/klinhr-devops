<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');


$cat_name = mysqli_real_escape_string($db, $_POST['cat_name']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';

$select = "select * from assessment_category where category_name = '$cat_name' and $account_token";
$select_result = mysqli_query($db, $select);
$num  = mysqli_num_rows($select_result);

if ($num == 0) {

    $query = "insert into assessment_category set category_name = '$cat_name' , $account_token";
    $result = mysqli_query($db, $query);

    if ($result) {
        activity_log($_SESSION['Klin_admin_user'], "Added a new category : ($cat_name)");

        $success = "Assessment successfully added";
        include('assessment-category.php');
        exit;
    } else {
        $error = "Assessment not added, try again";
        include('assessment-category.php');
        exit;
    }
} else {
    $error = 'Assessment type already created.';
    include('assessment-category.php');
    exit;
}
