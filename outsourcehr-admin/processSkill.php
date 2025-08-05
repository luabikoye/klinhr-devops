<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

if ($_POST['id']) {
    $id = $_POST['id'];
} else {
    $id = date('U');
}

$name = mysqli_real_escape_string($db, $_POST['name']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$level = $_POST['level'];
$course = $_POST['course'];


$course = array_filter($course, function ($value) {
    return $value !== '';
});

$course = implode(',', $course);

$level = array_filter($level, function ($value2) {
    return $value2 !== '';
});

$level = implode(',', $level);


if ($_POST['id']) {

    mysqli_query($db, "delete from course where refID = '$id'");

    mysqli_query($db, "INSERT INTO course set refID = '$id', skill = '$name', course = '$course', level = '$level'");
    mysqli_query($db, "update skill set name = '$name', description = '$description' where refID = '$id'");
    $d = base64_encode($id);
    header('Location: add-skill?success=1&d=' . $d);
    exit;
} else {

    mysqli_query($db, "INSERT INTO course set refID = '$id', skill = '$name', course = '$course', level = '$level'");
    mysqli_query($db, "insert into skill set refID = '$id', name = '$name', description = '$description'");

    header('Location: add-skill?success=2');
    exit;
}
