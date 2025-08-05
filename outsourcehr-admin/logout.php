<?php

ob_start();
session_start();

//  session_unset($_SESSION['Klin_admin_user']);
session_destroy();

if ($_GET['access'] == 'denied') {
   header('location: index?access=denied');
   exit;
} else {

   header("Location: index");
   exit;
}
