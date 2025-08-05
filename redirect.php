<?php
ob_start();
session_start();

if ($_GET['1c30f1ae89e3ba2eb42c7d'] == '0f52ac208baa24be3b8f7') {
    header("location: login?return_page= " . $_SESSION['redirect'] . " ");
} else {
    header('location: logout');
    exit;
}
