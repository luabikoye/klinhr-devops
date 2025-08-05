<?php
ob_start();

include('connection/connect.php');
require_once('inc/fns.php');
ob_start();
session_start();

$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);

$user_fullname = get_admin_name($username);

// $date = date('Y-m-d g:i:s A'); 

// if(isset($_POST['btn_login']))
// {


if ($username == '') {
    $error = "Username is required";
    include('index2.php');
    exit;
}

if ($password == '') {
    $error = "Password is required";
    include('index2.php');
    exit;
}

$select = "select * from login where username = '$username'";
$result = mysqli_query($db, $select);


$row = mysqli_fetch_array($result);
$pass = $row['password'];


if (password_verify($password, $pass)) {

    $_SESSION['Klin_admin_user'] = $username;
    $_SESSION['Klin_admin_email'] = $username;
    $_SESSION['account_token'] = $row['account_token'];

    $_SESSION['privilege'] = $row['privilege'];
    $_SESSION['client_code'] = $row['client_code'];

    if ($row['username'] == 'aledoy') {
        $_SESSION['privilege_user'] = 'administrator';
    } else {
        $_SESSION['privilege_user'] = ($row['client']);
    }

    activity_log($_SESSION['Klin_admin_email'], 'Signed into backend');
    // echo "test"; exit;
    header("Location: dashboard");
    exit;
}


// $query = "select * from login where username = '$username' && password = '$password'";
// $result = mysqli_query($db, $query);
// $num_rows = mysqli_num_rows($result);
// $row = mysqli_fetch_array($result);



// if($num_rows > 0)
// { 
//     $_SESSION['Klin_admin_user'] = $username;
//     $_SESSION['Klin_admin_email'] = $username;

//     $_SESSION['privilege'] = $row['privilege'];
//     $_SESSION['client_code'] = $row['client_code'];

// 	if($row['username'] == 'aledoy')
// 	{
// 		$_SESSION['privilege_user'] = 'administrator';
// 	}
//     else
//     {                    
//         $_SESSION['privilege_user'] = ($row['client']);            
//     }

//     activity_log($_SESSION['Klin_admin_email'], 'Signed into backend');
//         // echo "test"; exit;
//     header("Location: dashboard");
//     exit;
// }
else {

    $error = 'Incorrect Username or password';


    include('index.php');
    exit;
}
