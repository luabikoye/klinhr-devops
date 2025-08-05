<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require('PHPMailer/PHPMailerAutoload.php');


$today = date('Y-m-d');

$client = $_POST['client'];
$name = mysqli_real_escape_string($db, $_POST['name']);
$name_split = explode(' ', $name);
$first = $name_split[0];
$last = $name_split[1];
$position = mysqli_real_escape_string($db, $_POST['position']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$bank = mysqli_real_escape_string($db, $_POST['bank']);
$acc_no = mysqli_real_escape_string($db, $_POST['acc_no']);
$pen_pro = mysqli_real_escape_string($db, $_POST['pen_pro']);
$pin = mysqli_real_escape_string($db, $_POST['rsa_pin']);
$staffID = $_POST['staff_id'];
$year = date('Y');
$month = date('F');
$pay_month = $month . "-" . $year;
$gross = $_POST['gross'];
$loan = $_POST['loan'];
$allowance = $_POST['allowance'];
$days_work = $_POST['days_work'];
$leaveDays = $_POST['leave'];
$from_email = 'noreply@' . host_name(); //from mail, it is mandatory with some hosts
$subject = "You can now access the staff portal";

$pin2 = substr(rand(000000000, 100000000), 0, 6);
$qsPin = mysqli_query($db, "select * from onboarding_pins where pin = '$pin2'");
$nsPin = mysqli_num_rows($qsPin);

if ($nsPin > 0) {
    for ($p = 0; $p < $nsPin; $p++) {
        $rsPin = mysqli_fetch_assoc($qsPin);
        if ($rsPin['pin'] == $pin) {
            $pin2 = substr(rand(000000000, 100000000), 0, 6);
        }
    }
}

if ($client) {
    $qs = mysqli_query($db, "select * from settings where client = '$client'");
} else {
    $qs = mysqli_query($db, "select * from settings where client is null || client = ''");
}

$ns = mysqli_num_rows($qs);
$rs = mysqli_fetch_assoc($qs);

if ($ns > 0) {

    $gross2 =  $gross / 12;

    if ($rs['basic']) {
        $basic = ($rs['basic'] / 100) * $gross;
        $basic2 = $basic / 12;
    } else {
        $basic = '0.00';
        $basic2 = '0.00';
    }

    if ($rs['housing']) {
        $housing = ($rs['housing'] / 100) * $gross;
        $housing2 = $housing / 12;
    } else {
        $housing = '0.00';
        $housing2 = '0.00';
    }

    if ($rs['transport']) {
        $transport = ($rs['transport'] / 100) * $gross;
        $transport2 = $transport / 12;
    } else {
        $transport = '0.00';
        $transport2 = '0.00';
    }

    $sum = $basic + $housing + $transport;

    $stat = ($_POST['staff_stat'] / 100) * $sum;
    $stat2 = $stat / 12;

    $coy_stat = ($rs['comp_stat_cont'] / 100)  * $sum;
    $coy_stat2 = $coy_stat / 12;


    if ($_POST['staff_vol']) {

        $staff_vol = ($_POST['staff_vol'] / 100) * $sum;
        $staff_vol2 = $staff_vol / 12;
    } else {
        $staff_vol = '0.00';
        $staff_vol2 = '0.00';
    }

    if ($rs['pen_cop_vol']) {
        $cop_vol = ($rs['pen_cop_vol'] / 100) * $sum;
        $cop_vol2 = $cop_vol / 12;
    } else {
        $cop_vol = '0.00';
        $cop_vol2 = '0.00';
    }

    if ($rs['leave_allo']) {
        $leave = ($rs['leave_allo'] / 100) * $gross;
        $leave2 = $leave / 12;
    } else {
        $leave = '0.00';
        $leave2 = '0.00';
    }

    if ($rs['utility']) {
        $utility = ($rs['utility'] / 100) * $gross;
        $utility2 = $utility / 12;
    } else {
        $utility = '0.00';
        $utility2 = '0.00';
    }

    if ($rs['meals']) {
        $meals = ($rs['meals'] / 100) * $gross;
        $meals2 = $meals / 12;
    } else {
        $meals = '0.00';
        $meals2 = '0.00';
    }

    if ($rs['dressing']) {
        $dress = ($rs['dressing'] / 100) * $gross;
        $dress2 = $dress / 12;
    } else {
        $dress = '0.00';
        $dress2 = '0.00';
    }

    if ($rs['13th_month']) {
        $month13 = ($rs['13th_month'] / 100) * $gross;
        $month132 = $month13 / 12;
    } else {
        $month13 = '0.00';
        $month132 = '0.00';
    }

    if ($rs['nhf']) {
        $nhf = ($rs['nhf'] / 100) * $basic;
        $nhf2 = $nhf / 12;
    } else {
        $nhf = '0.00';
        $nhf2 = '0.00';
    }

    $con_relief = $gross * (20 / 100) + 200000;

    $non_taxable = $con_relief + $stat + $staff_vol + $nhf;

    $taxable = $gross - $non_taxable;

    if ($taxable > 300000) {
        $_7 = 300000;
        $tax7per = 300000 * (7 / 100);
    } else {
        $tax7per = $taxable / 100 * 7;
        $_7 = $tax7per;
    }

    if (($taxable - $_7) > 300000) {
        $_11 = 300000;
        $tax11per = 300000 * (11 / 100);
    } else {
        $tax11per = ($taxable - $_7) / 100 * 11;
        $_11 = ($taxable - $_7);
    }

    if ($taxable - ($_7 + $_11) > 500000) {
        $_15 = 500000;
        $tax15per = 500000 * (15 / 100);
    } else {
        $tax15per = ($taxable - ($_7 + $_11)) / 100  * 15;
        $_15 = $taxable - ($_7 + $_11);
    }

    if ($taxable - ($_7 + $_11 + $_15) > 500000) {
        $_19 = 500000;
        $tax19per = (500000) * (19 / 100);
    } else {
        $tax19per = ($taxable - ($_7 + $_11 + $_15)) / 100  * 19;
        $_19 = $taxable - ($_7 + $_11 + $_15);
    }

    if ($taxable - ($_7 + $_11 + $_15 + $_19) > 1600000) {
        $_21 = 1600000;
        $tax21per = (1600000) * (21 / 100);
    } else {
        $tax21per = ($taxable - ($_7 + $_11 + $_15 + $_19)) / 100  * 21;
        $_21 = $taxable - ($_7 + $_11 + $_15 + $_19);
    }

    if (($taxable - 300000) >= 3200000) {
        $tax24per = ($taxable - 3200000) * (24 / 100);
    } else {
        $_24 = ($taxable - ($_7 + $_11 + $_15 + $_19 + $_21)) / 100 * 24;
        $tax24per = $_24;
    }

    $paye = $tax7per + $tax11per + $tax15per + $tax19per + $tax21per + $tax24per;

    $monthlyPaye = $paye / 12;


    if ($days_work) {

        $dateR = date('d', strtotime($days_work));

        $days = date('t', strtotime($today));

        $diff = $days - $dateR + 1;

        $net_pay = ($diff / $days * $gross2);
    } else {
        $diff = date('t', strtotime($today));
        $net_pay = $gross2;
    }

    $take_home = $net_pay - ($stat2 + $staff_vol2 + $nhf2 + $monthlyPaye + $loan) + $allowance;

    mysqli_query($db, "insert into payroll set client = '$client', name='$name', designation='$position', staff_id='$staffID', email = '$email', gross='$gross', basic = '$basic', housing = '$housing', transport = '$transport', leave_allo='$leave', utility='$utility', meals='$meals', dressing='$dress', 13th_month = '$month13', consolidated_relief = '$con_relief', nhf = '$nhf', stat_pen='$stat', vol_pen = '$staff_vol', non_taxable = '$non_taxable', taxable = '$taxable', tax7per = '$tax7per', tax11per = '$tax11per', tax15per = '$tax15per', tax19per = '$tax19per', tax21per = '$tax21per', tax24per = '$tax24per', total_paye = '$paye', monthly_paye = '$monthlyPaye', monthly_net = '$net_pay', bank = '$bank', acc_no = '$acc_no', pen_pro = '$pen_pro', rsa_pin = '$pin', staff_vol_per = '{$_POST['staff_vol']}', monthly_stat_pen='$stat2', monthly_vol_pen = '$staff_vol2', monthly_comp_pen = '$coy_stat2', monthly_comp_vol = '$cop_vol2', monthly_nhf = '$nhf2', take_home = '$take_home', current_month = '$month', current_year = '$year', days_work = '$diff', resumed_date = '$days_work'");

    mysqli_query($db, "insert into emp_leave_planner set staff_id='$staffID', total_days='$leaveDays', scheduled_days='0', outstanding_days='$leaveDays', current_year='$year'");

    $qsOnboard = mysqli_query($db, "insert into onboarding set pin = '$pin2', firstname = '$first', lastname = '$last', email = '$email', position = '$position', client = '$client', bank = '$bank', acc_no = '$acc_no', pen_pro = '$pen_pro', rsa_pin = '$pin'");

    $lastID = mysqli_insert_id($db);

    mysqli_query($db, "insert into employees set staff_id = '$staffID', onboard_id = '$lastID', position = '$position', firstname = '$first', lastname = '$last', email = '$email', salary = '$take_home',  paye = '$monthlyPaye', pension = '$stat2', client = '$client', doe = '$days_work', emp_status = 'active', year = '$year', month = '$month', month_year = '$month_year'");

    mysqli_query($db, "insert into employee_login set user = '$staffID', pass = '$staffID', staff_id = '$staffID'");

    mysqli_query($db, "insert into payslip set client = '$client', name='$name', designation='$position', staff_id='$staffID', email = '$email', bank = '$bank', acc_no = '$acc_no', pen_pro = '$pen_pro', rsa_pin = '$pin', staff_vol_per = '{$_POST['staff_vol']}', paye = '$monthlyPaye', stat_pen='$stat2', vol_pen = '$staff_vol2', comp_pen = '$coy_stat2', comp_vol = '$cop_vol2', nhf = '$nhf2', net_pay = '$net_pay', take_home = '$take_home', pay_month = '$pay_month', current_month = '$month', current_year = '$year', days_work = '$diff'");

    // $message  = '<html>
    // <head>
    // <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    // <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
    // <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
    // <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
    // <title>Single Column</title>

    // <style type="text/css">
    // body {
    // margin: 0;
    // padding: 0;
    // -ms-text-size-adjust: 100%;
    // -webkit-text-size-adjust: 100%;
    // }
    // table {
    // border-spacing: 0;
    // }
    // table td {
    // border-collapse: collapse;
    // }
    // .ExternalClass {
    // width: 100%;
    // }
    // .ExternalClass,
    // .ExternalClass p,
    // .ExternalClass span,
    // .ExternalClass font,
    // .ExternalClass td,
    // .ExternalClass div {
    // line-height: 100%;
    // }
    // .ReadMsgBody {
    // width: 100%;
    // background-color: #ebebeb;
    // }
    // table {
    // mso-table-lspace: 0pt;
    // mso-table-rspace: 0pt;
    // }
    // img {
    // -ms-interpolation-mode: bicubic;
    // }
    // .yshortcuts a {
    // border-bottom: none !important;
    // }
    // @media screen and (max-width: 599px) {
    // .force-row,
    // .container {
    // width: 100% !important;
    // max-width: 100% !important;
    // }
    // }
    // @media screen and (max-width: 400px) {
    // .container-padding {
    // padding-left: 12px !important;
    // padding-right: 12px !important;
    // }
    // }
    // .ios-footer a {
    // color: #aaaaaa !important;
    // text-decoration: underline;
    // }
    // </style>
    // </head>

    // <body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

    // <!-- 100% background wrapper (grey background) -->
    // <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
    // <tr>
    // <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

    // <br>

    // <!-- 600px container (white background) -->
    // <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
    // <tr>
    // <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px">
    // <a href="'.host().'" title="Visit our website"><img src="'.host().'/logo.png"></a>
    // </td>
    // </tr>
    // <tr>
    // <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
    // <br>

    // <br>

    // <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#000000; padding-bottom:100px">

    // <p>Dear '.ucfirst($first).',</p>

    // <p>You can login to the employee staff portal with your staff ID as your username and password. </p><br>

    // <p>Visit <a href="'.host().'/Klinhr/staff-portal/">Employee Staff Portal</a> to begin.</p><br>

    // <p>You have our best wishes in your new assignment.</p>

    // <p>Best regards,<br>
    // '.ucfirst(host_name()).'
    // </p>

    // </div>

    // </td>
    // </tr>
    // </table>
    // <!--/100% background wrapper-->
    // </body>
    // </html>';


    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    $mail->setFrom($from_email, ucfirst(host_name()));
    $mail->addAddress($email, $first);
    $mail->isHTML();
    $mail->Subject = $subject;
    $mail->Body = $message;

    //send the message, check for errors
    // $mail->send();

    header('Location:emp_salary?success=1');
    exit;
} else {

    header('Location: emp_salary?error');
    exit;
}
