<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Onboarding');

if (!isset($_SESSION['ics_admin_user'])) {
    include('index.php');
    exit;
}

$state = $_POST['state'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    echo $query = "select * from local_govt where state = '$state'";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);


    echo ' <select name="local_govt_of_origin_code" id="govt" class="js-select form-select">';
    echo        '<option value="" disabled selected>Select Local Governmernt</option>';
    for ($i = 0; $i < $num; $i++) {
        $row = mysqli_fetch_array($result);
        echo '<option>' . ucwords($row['local_govt']) . '</option>';
    }
    echo '</select>';
}
