<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Assessment');
$id = $_POST['id'];
$cat_name = mysqli_real_escape_string($db, $_POST['cat_name']);
$old_cat_name = mysqli_real_escape_string($db, $_POST['old_cat_name']);

$query = "update assessment_category set category_name = '$cat_name' where id = '$id'";
$result = mysqli_query($db, $query);

if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Edited category: ($cat_name)");

    //update category name in all the questions in the system
    $query2 = "update questions set category = '$cat_name' where category = '$old_cat_name'";
    $result2 = mysqli_query($db, $query2);


    $success1 = "Category successfully edited";
    include('assessment-category.php');
    exit;
} else {
    $error1 = "Category not edited, try again";
    include('assessment-category.php');
    exit;
}
