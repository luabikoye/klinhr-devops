<script></script>
<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$email = mysqli_real_escape_string($db, $_POST['email']);

// $date = date('Y-m-d g:i:s A'); 


$query = "select * from login where username = '$email'";
$result = mysqli_query($db, $query);
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($num_rows > 0) {

    $newpass = rand(0000, 9999);
    $newpass1 = password_hash(rand(0000, 9999), PASSWORD_BCRYPT);

    $u_query = "update login set password = '$newpass1' where username = '$email'";
    mysqli_query($db, $u_query);

    $msg = 'Your new password is: <b>' . $newpass . '</b>';

    send_email($email, 'Admin', organisation(), 'Password Reset', $msg);


    $success = 'New password has been set to your email';
    include('authentication-reset-password.php');
    exit;
} else {

    $error = 'There is no account with this email address. Contact Admin for help';


    include('authentication-reset-password.php');
    exit;
}

?>