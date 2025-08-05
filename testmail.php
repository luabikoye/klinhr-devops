<?php
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
require_once('outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

$email = 'mayowadelu@gmail.com';
$firstname = 'Lu Abk';
$message = 'This is to cofm test';

send_email($email, $firstname, organisation(), 'Account Confirmation TLS', $message);
echo 'Everything okat';