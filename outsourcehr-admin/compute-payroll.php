<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$pay_token = md5(date('U'));

$pay_month = date('F-Y');
$year = date('Y');
$month = date('F');
$month_year = date('F-Y');

$query = "select * from payroll_schedule where pay_month_year = '$pay_month'";

$result = mysqli_query($db, $query);
$num_rows = mysqli_num_rows($result);
$rows = mysqli_fetch_array($result);

if ($num_rows == 0) {

    $result_sch = mysqli_query($db, "insert into payroll_schedule set token = '$pay_token', pay_month_year = '$pay_month'");


    if ($result_sch) {
        $emp_query = "select * from emp_staff_details where staff = 'yes' and status = 'active'";
        $emp_result = mysqli_query($db, $emp_query);
        $emp_num = mysqli_num_rows($emp_result);
       

        for ($i = 0; $i < $emp_num; $i++) {
            $emp_row = mysqli_fetch_array($emp_result);
            //insert into the employees table
            // echo $emp_row['email_address'];
            // echo $emp_row['staff_id'];

            //get updated salary 

            //compute components

            $gross = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'salary');

            $basic = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'basic');

            $housing = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'housing');

            $transport = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'transport');

            $leave_allo = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'leave_allo');

            $utility = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'utility');

            $meals = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'meals');

            $dressing = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'dressing');

            $month13 = compute_pay($emp_row['company_code'], $emp_row['salary_band'], '13th_month');

            $loan = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'loan');

            $comp_stat_cont = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'comp_stat_cont');

            $staff_stat_cont = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'staff_stat_cont');

            $tax = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'tax');

            $nhf = (floatval($gross) * (2.5 / 100));

            $annual_salary = floatval($gross) * 12;

            $annual_nhf = $nhf * 12;

            $consolidated = (floatval($annual_salary) * 0.2) + 200000;

            $pension = (floatval($basic) + floatval($housing) + floatval($transport)) * 0.08;

            $annual_pension = $pension * 12;

            $total_relief = ($consolidated + $annual_pension + $annual_nhf);

            $taxable = ($annual_salary - $total_relief);

            $annual_tax = get_annual_tax($taxable);

            $payee = $annual_tax / 12;

            $total_deduction = $pension + $leave_allo + $month13 + $nhf + $payee;

            $net_pay = floatval($gross) + floatval($total_deduction);

            $employer_pension = ($basic + $transport + $housing) * 0.1;

            $nsitf = 0.01 * floatval($gross);

            $gross_income = floatval($gross) - $pension - $nhf;
            $annual_gross_income = $gross_income * 12;
            //insert into payroll table            

            $fullName = addslashes($emp_row['surname'] . ' ' . $emp_row['lastname'] . ' ' . $emp_row['middlename']);
            $result_pay = mysqli_query($db, "insert into payroll set
            pay_token = '$pay_token',
                gross = '$gross',
                gross_income = '$gross_income',
                annual_gross_income = '$annual_gross_income',
                basic = '$basic',
                housing = '$housing',
                transport = '$transport',
                leave_allo = '$leave_allo',
                utility = '$utility',
                meals = '$meals',
                tax = '$tax',
                dressing = '$dressing',
                13th_month = '$month13',
                loan = '$loan',
                taxable = '$taxable',
                staff_vol = '$staff_stat_cont',
                employer_pension = '$employer_pension',
                nsitf = '$nsitf',
                itf = '$nsitf',
                comp_const = '$comp_stat_cont',
                consolidated_relief  = '$consolidated',
                pension = '$pension',
                total_relief = '$total_relief',
                annual_pension = '$annual_pension',                                
                net_pay = '$net_pay',              
                total_paye = '$payee',
                annual_tax = '$annual_tax',
                total_deduction = '$total_deduction',
                monthly_nhf = '$nhf', annual_nhf = '$annual_nhf', client = '" . addslashes($emp_row['company_code']) . "', name = '$fullName', designation = '" . addslashes($emp_row['position_code']) . "', staff_id = '" . addslashes($emp_row['staff_id']) . "', email = '" . addslashes($emp_row['email_address']) . "'");


            $salary = compute_pay($emp_row['company_code'], $emp_row['salary_band'], 'salary');

            //update the employees table with total payee and total deductions.
            // $total_paye = $tax + $comp_stat_cont + $staff_stat_cont + $loan;   //total deduction
            // $pension = 22500; // value for pension


            // $total_deduction = $total_paye + $pension;
            // $actual_salary = $salary - $total_deduction;


            $query_emp = "insert into employees set onboard_id = '" . $emp_row['onboarding_code'] . "', pay_token = '$pay_token', staff_id = '" . $emp_row['staff_id'] . "', position = '" . $emp_row['position_code'] . "', department = '" . addslashes($emp_row['department_code']) . "', firstname = '" . addslashes($emp_row['firstname']) . "', lastname = '" . addslashes($emp_row['surname']) . "', email = '" . addslashes($emp_row['email_address']) . "', phone = '" . addslashes($emp_row['mobile_phone_number']) . "',bank_name ='" . addslashes($emp_row['payment_code']) . "', bank_account = '" . addslashes($emp_row['bank_account_number']) . "', pay_month = '$pay_month', salary = '" . $salary . "', paye = '$payee', pension='$pension', total_deduction = '$total_deduction', client = '" . $emp_row['company_code'] . "', emp_status = 'active', year = '$year', month = '$month', month_year = '$month_year'";            
            $result_emp = mysqli_query($db, $query_emp);
        }        
        header('Location:emp_salary?sent=3');
    } else {
        header('Location:emp_salary?sch_error=1');
    }
} else {
    header('Location:emp_salary?sch_error=4');
}
