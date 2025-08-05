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
    $refID = $_POST['id'];
} else {
    $refID = date('U');
}
$name = mysqli_real_escape_string($db, $_POST['name']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$description = mysqli_real_escape_string($db, $_POST['description']);

$question  = mysqli_real_escape_string($db, $_POST['question']);
$optionA = mysqli_real_escape_string($db, $_POST['optionA']);
$optionB = mysqli_real_escape_string($db, $_POST['optionB']);
$answer = mysqli_real_escape_string($db, $_POST['answer']);

$question2  = mysqli_real_escape_string($db, $_POST['question2']);
$optionA2 = mysqli_real_escape_string($db, $_POST['optionA2']);
$optionB2 = mysqli_real_escape_string($db, $_POST['optionB2']);
$answer2 = mysqli_real_escape_string($db, $_POST['answer2']);

$question3  = mysqli_real_escape_string($db, $_POST['question3']);
$optionA3 = mysqli_real_escape_string($db, $_POST['optionA3']);
$optionB3 = mysqli_real_escape_string($db, $_POST['optionB3']);
$answer3 = mysqli_real_escape_string($db, $_POST['answer3']);

$question4  = mysqli_real_escape_string($db, $_POST['question4']);
$optionA4 = mysqli_real_escape_string($db, $_POST['optionA4']);
$optionB4 = mysqli_real_escape_string($db, $_POST['optionB4']);
$answer4 = mysqli_real_escape_string($db, $_POST['answer4']);

if ($question4) {
    $question = $question . ', ' . $question2 . ', ' . $question3 . ', ' . $question4;
    $optionA = $optionA . ', ' . $optionA2 . ', ' . $optionA3 . ', ' . $optionA4;
    $optionB = $optionB . ', ' . $optionB2 . ', ' . $optionB3 . ', ' . $optionB4;
    $answer = $answer . ', ' . $answer2 . ', ' . $answer3 . ', ' . $answer4;
}
if ($question3 && !$question4) {
    $question = $question . ', ' . $question2 . ', ' . $question3;
    $optionA = $optionA . ', ' . $optionA2 . ', ' . $optionA3;
    $optionB = $optionB . ', ' . $optionB2 . ', ' . $optionB3;
    $answer = $answer . ', ' . $answer2 . ', ' . $answer3;
}

if ($question2 && !$question3 && $question4) {
    $question = $question . ', ' . $question2;
    $optionA = $optionA . ', ' . $optionA2;
    $optionB = $optionB . ', ' . $optionB2;
    $answer = $answer . ', ' . $answer2;
}

$qaNum = count(explode(',', $question));


if ($_POST['id']) {
    mysqli_query($db, "delete from qa where refID = '$refID'");
    mysqli_query($db, "INSERT INTO qa set refID = '$refID', qaNum = '$qaNum', question = '$question', optionA = '$optionA', optionB = '$optionB', answer = '$answer'");

    mysqli_query($db, "update questionnaire set question = '$name', type = '$type', description = '$description' where refID = '$refID'");

    header('Location: questionnaire?success=1&id=' . $refID);
    exit;
} else {

    mysqli_query($db, "INSERT INTO qa set refID = '$refID', qaNum = '$qaNum', question = '$question', optionA = '$optionA', optionB = '$optionB', answer = '$answer'");

    mysqli_query($db, "insert into questionnaire set refID = '$refID', question= '$name', type = '$type', description = '$description', date = '$refID'");

    header('Location: questionaire?success=2');
    exit;
}
