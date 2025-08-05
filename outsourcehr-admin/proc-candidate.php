<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
	header("Location: index");
	exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$surname =   mysqli_real_escape_string($db, $_POST['surname']);
$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$middlename = mysqli_real_escape_string($db, $_POST['middlename']);
$email =     mysqli_real_escape_string($db, $_POST['email_address']);
$company_code = mysqli_real_escape_string($db, $_POST['company_code']);
$mobile =       mysqli_real_escape_string($db, $_POST['mobile_phone_number']);
$marital_status = mysqli_real_escape_string($db, $_POST['marital_status']);
$sex =          mysqli_real_escape_string($db, $_POST['sex']);
$date_of_birth = mysqli_real_escape_string($db, $_POST['date_of_birth']);

$current_address_1 = mysqli_real_escape_string($db, $_POST['current_address_1']);
$current_address_2 = mysqli_real_escape_string($db, $_POST['current_address_2']);
$current_address_town = mysqli_real_escape_string($db, $_POST['current_address_town']);
$current_address_state_code = mysqli_real_escape_string($db, $_POST['current_address_state_code']);

$prev_employer_position = mysqli_real_escape_string($db, $_POST['prev_employer_position']);
$prev_employer = mysqli_real_escape_string($db, $_POST['1st_previous_employer_name']);
$prev_employer1_address = mysqli_real_escape_string($db, $_POST['1st_previous_employer_address_1']);
$prev_employer1_address2 = mysqli_real_escape_string($db, $_POST['1st_previous_employer_address_2']);
$prev_employer1_city = mysqli_real_escape_string($db, $_POST['1st_previous_employer_town']);
$prev_employer1_state = mysqli_real_escape_string($db, $_POST['1st_previous_employer_state_code']);
$n_prev_2nd_emp_person = mysqli_real_escape_string($db, $_POST['n_prev_2nd_emp_person']);
$n_prev_2nd_emp_email = mysqli_real_escape_string($db, $_POST['n_prev_2nd_emp_email']);
$n_prev_2nd_emp_phone = mysqli_real_escape_string($db, $_POST['n_prev_2nd_emp_phone']);
$n_prev_1st_emp_person = mysqli_real_escape_string($db, $_POST['n_prev_1st_emp_person']);
$n_prev_1st_emp_email = mysqli_real_escape_string($db, $_POST['n_prev_1st_emp_email']);
$n_prev_1st_emp_phone = mysqli_real_escape_string($db, $_POST['n_prev_1st_emp_phone']);
$prev_employer2 = mysqli_real_escape_string($db, $_POST['2nd_previous_employer_name']);
$prev_employer2_address = mysqli_real_escape_string($db, $_POST['2nd_previous_employer_address_1']);
$prev_employer2_address2 = mysqli_real_escape_string($db, $_POST['2nd_previous_employer_address_2']);
$prev_employer2_city = mysqli_real_escape_string($db, $_POST['2nd_previous_employer_town']);
$prev_employer2_state = $_POST['2nd_previous_employer_state_code'];


$guarantor = mysqli_real_escape_string($db, $_POST['1st_guarantor_name']);
$guarantor_address = mysqli_real_escape_string($db, $_POST['1st_guarantor_address_1']);
$guarantor_address2 = mysqli_real_escape_string($db, $_POST['1st_guarantor_address_2']);
$guarantor_city = mysqli_real_escape_string($db, $_POST['1st_guarantor_town']);
$guarantor_state = mysqli_real_escape_string($db, $_POST['1st_guarantor_state_code']);
$guarantor_phone = mysqli_real_escape_string($db, $_POST['1st_guarantor_phone']);
$guarantor_email = mysqli_real_escape_string($db, $_POST['1st_guarantor_email']);
$n_1st_guarantor_company = mysqli_real_escape_string($db, $_POST['n_1st_guarantor_company']);
$n_1st_guarantor_address = mysqli_real_escape_string($db, $_POST['n_1st_guarantor_address']);
$n_1st_guarantor_grade = mysqli_real_escape_string($db, $_POST['n_1st_guarantor_grade']);
$n_1st_guarantor_no_years = mysqli_real_escape_string($db, $_POST['n_1st_guarantor_no_years']);
$guarantor2 = mysqli_real_escape_string($db, $_POST['2nd_guarantor_name']);
$guarantor2_address = mysqli_real_escape_string($db, $_POST['2nd_guarantor_address_1']);
$guarantor2_address2 = mysqli_real_escape_string($db, $_POST['2nd_guarantor_address_2']);
$guarantor2_city = mysqli_real_escape_string($db, $_POST['2nd_guarantor_town']);
$guarantor2_state = mysqli_real_escape_string($db, $_POST['2nd_guarantor_state_code']);
$guarantor2_phone = mysqli_real_escape_string($db, $_POST['2nd_guarantor_phone']);
$guarantor2_email = mysqli_real_escape_string($db, $_POST['2nd_guarantor_email']);
$n_2nd_guarantor_company = mysqli_real_escape_string($db, $_POST['n_2nd_guarantor_company']);
$n_2nd_guarantor_address = mysqli_real_escape_string($db, $_POST['n_2nd_guarantor_address']);
$n_2nd_guarantor_grade = mysqli_real_escape_string($db, $_POST['n_2nd_guarantor_grade']);
$n_2nd_guarantor_no_years = mysqli_real_escape_string($db, $_POST['n_2nd_guarantor_no_years']);

$nok = mysqli_real_escape_string($db, $_POST['next_of_kin_name']);
$nok_relationship = mysqli_real_escape_string($db, $_POST['nok_relationship']);
$nok_address = mysqli_real_escape_string($db, $_POST['next_of_kin_address_1']);
$nok_address2 = mysqli_real_escape_string($db, $_POST['next_of_kin_address_2']);
$nok_city = mysqli_real_escape_string($db, $_POST['next_of_kin_town']);
$nok_state = mysqli_real_escape_string($db, $_POST['next_of_kin_state_code']);
$nok_phone = mysqli_real_escape_string($db, $_POST['next_of_kin_phone']);
$nok_email = mysqli_real_escape_string($db, $_POST['next_of_kin_email']);

$referee = mysqli_real_escape_string($db, $_POST['1st_referee_name']);
$referee_address1 = mysqli_real_escape_string($db, $_POST['1st_referee_address_1']);
$referee_address2 = mysqli_real_escape_string($db, $_POST['1st_referee_address_2']);
$referee_city = mysqli_real_escape_string($db, $_POST['1st_referee_town']);
$referee_state = mysqli_real_escape_string($db, $_POST['1st_referee_state_code']);
$referee_phone = mysqli_real_escape_string($db, $_POST['1st_referee_phone']);
$referee_email = mysqli_real_escape_string($db, $_POST['1st_referee_email']);

$referee2 = mysqli_real_escape_string($db, $_POST['2nd_referee_name']);
$referee2_address1 = mysqli_real_escape_string($db, $_POST['2nd_referee_address_1']);
$referee2_address2 = mysqli_real_escape_string($db, $_POST['2nd_referee_address_2']);
$referee2_city = mysqli_real_escape_string($db, $_POST['2nd_referee_town']);
$referee2_state = mysqli_real_escape_string($db, $_POST['2nd_referee_state_code']);
$referee2_phone = mysqli_real_escape_string($db, $_POST['2nd_referee_phone']);
$referee2_email = mysqli_real_escape_string($db, $_POST['2nd_referee_email']);

$state_origin = mysqli_real_escape_string($db, $_POST['state_origin']);
$local_govt = mysqli_real_escape_string($db, $_POST['local_govt_of_origin_code']);
$country = mysqli_real_escape_string($db, $_POST['country']);
$pfa = mysqli_real_escape_string($db, $_POST['pfa_code']);
$pension_pin = mysqli_real_escape_string($db, $_POST['pension_pin']);
$nhf_pin = mysqli_real_escape_string($db, $_POST['nhf_pin']);
$bvn = mysqli_real_escape_string($db, $_POST['bvn']);
$nin = mysqli_real_escape_string($db, $_POST['nin']);

$other_institution_2 = mysqli_real_escape_string($db, $_POST['other_institution_2']);
$other_institution = mysqli_real_escape_string($db, $_POST['other_institution']);
$other_courses2 = mysqli_real_escape_string($db, $_POST['other_courses2']);
$other_courses = mysqli_real_escape_string($db, $_POST['other_courses']);
$institution = mysqli_real_escape_string($db, $_POST['1st_institution_code']);
$qualification = mysqli_real_escape_string($db, $_POST['1st_qualification_code']);
$course_study = mysqli_real_escape_string($db, $_POST['1st_course_code']);
$grade = mysqli_real_escape_string($db, $_POST['1st_result_grade']);
$graduation_year = mysqli_real_escape_string($db, $_POST['1st_graduation_year']);
$institution2 = mysqli_real_escape_string($db, $_POST['2nd_institution_code']);
$qualification2 = mysqli_real_escape_string($db, $_POST['2nd_qualification_code']);
$course_study2 = mysqli_real_escape_string($db, $_POST['2nd_course_code']);
$grade2 = mysqli_real_escape_string($db, $_POST['2nd_result_grade']);
$graduation_year2 = mysqli_real_escape_string($db, $_POST['2nd_graduation_year']);
$institution3 = mysqli_real_escape_string($db, $_POST['3rd_institution_code']);
$qualification3 = mysqli_real_escape_string($db, $_POST['3rd_qualification_code']);
$course_study3 = mysqli_real_escape_string($db, $_POST['3rd_course_code']);
$grade3 = mysqli_real_escape_string($db, $_POST['3rd_result_grade']);
$graduation_year3 = mysqli_real_escape_string($db, $_POST['3rd_graduation_year']);
$start_date = mysqli_real_escape_string($db, $_POST['start_date']);
$end_date = mysqli_real_escape_string($db, $_POST['end_date']);
$nysc_id_no = mysqli_real_escape_string($db, $_POST['nysc_id_no']);
$ist_graduation_month_started = mysqli_real_escape_string($db, $_POST['1st_graduation_month_started']);
$ist_graduation_year_started = mysqli_real_escape_string($db, $_POST['1st_graduation_year_started']);
$ist_graduation_month_ended = mysqli_real_escape_string($db, $_POST['1st_graduation_month_ended']);
$nd_graduation_month_started = mysqli_real_escape_string($db, $_POST['2nd_graduation_month_started']);
$nd_graduation_year_started = mysqli_real_escape_string($db, $_POST['2nd_graduation_year_started']);
$nd_graduation_month_ended = mysqli_real_escape_string($db, $_POST['2nd_graduation_month_ended']);
$payment_code = mysqli_real_escape_string($db, $_POST['payment_code']);
$bank_account_number = mysqli_real_escape_string($db, $_POST['bank_account_number']);
$completed = mysqli_real_escape_string($db, $_POST['completed']);
$staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);

$candidate_id = date('U') . $mobile;


$staff_id_split = explode('/', $staff_id);

$serial_no = $staff_id_split[2];




$document = mysqli_real_escape_string($db, $_POST['document_type']);
$userfile = mysqli_real_escape_string($db, $_POST['userfile']);


$staff_conflict = stafflogin_conflict($email, $company_code);


$query = "insert into emp_staff_details set 			
			current_address_1 = '$current_address_1',
			EmployeeID	= '$staff_id',
			staff_id	= '$staff_id',			
			staff_serial_no = '$serial_no',
			candidate_id = '$candidate_id',
			current_address_2 = '$current_address_2',
			current_address_town = '$current_address_town',
			current_address_state_code = '$current_address_state_code',
			1st_previous_employer_name = '$prev_employer',
			prev_employer_position = '$prev_employer_position',
			1st_previous_employer_address_1 = '$prev_employer1_address',
			1st_previous_employer_address_2 = '$prev_employer1_address2',
			1st_previous_employer_town = '$prev_employer1_city',
			1st_previous_employer_state_code = '$prev_employer1_state',			
			n_prev_1st_emp_person = '$n_prev_1st_emp_person',
			n_prev_1st_emp_email = '$n_prev_1st_emp_email',
			n_prev_1st_emp_phone = '$n_prev_1st_emp_phone',			
			2nd_previous_employer_name = '$prev_employer2',
			2nd_previous_employer_address_1 = '$prev_employer2_address',
			2nd_previous_employer_address_2 = '$prev_employer2_address2',
			2nd_previous_employer_town = '$prev_employer2_city',
			2nd_previous_employer_state_code = '$prev_employer2_state',		
			n_prev_2nd_emp_person = '$n_prev_2nd_emp_person',
			n_prev_2nd_emp_email = '$n_prev_2nd_emp_email',
			n_prev_2nd_emp_phone = '$n_prev_2nd_emp_phone',	
			1st_referee_name = '$referee',
			1st_referee_address_1 = '$referee_address1',
			1st_referee_address_2 = '$referee_address2',
			1st_referee_town = '$referee_city',
			1st_referee_state_code = '$referee_state',
			payment_code = '$payment_code',
			bank_account_number = '$bank_account_number',
			1st_referee_phone = '$referee_phone',
			1st_referee_email = '$referee_email',
			2nd_referee_name = '$referee2',
			2nd_referee_address_1 = '$referee2_address1',
			2nd_referee_address_2 = '$referee2_address2',
			2nd_referee_town = '$referee2_city',
			2nd_referee_state_code = '$referee2_state',
			2nd_referee_phone = '$referee2_phone',
			2nd_referee_email = '$referee2_email',
			1st_guarantor_name = '$guarantor',
			1st_guarantor_address_1 = '$guarantor_address',
			1st_guarantor_address_2 = '$guarantor_address2',
			1st_guarantor_town = '$guarantor_city',
			1st_guarantor_state_code = '$guarantor_state',
			1st_guarantor_phone = '$guarantor_phone',
			1st_guarantor_email = '$guarantor_email',			
			n_1st_guarantor_company = '$n_1st_guarantor_company',
			n_1st_guarantor_address = '$n_1st_guarantor_address',
			n_1st_guarantor_grade = '$n_1st_guarantor_grade',
			n_1st_guarantor_no_years = '$n_1st_guarantor_no_years',			
			2nd_guarantor_name = '$guarantor2',
			2nd_guarantor_address_1 = '$guarantor2_address',
			2nd_guarantor_address_2 = '$guarantor2_address2',
			2nd_guarantor_town = '$guarantor2_city',
			2nd_guarantor_state_code = '$guarantor2_state',
			2nd_guarantor_phone = '$guarantor2_phone',
			2nd_guarantor_email = '$guarantor2_email',
			n_2nd_guarantor_company = '$n_2nd_guarantor_company',
			n_2nd_guarantor_address = '$n_2nd_guarantor_address',
			n_2nd_guarantor_grade = '$n_2nd_guarantor_grade',
			n_2nd_guarantor_no_years = '$n_2nd_guarantor_no_years',
			next_of_kin_name = '$nok',
			nok_relationship = '$nok_relationship',
			next_of_kin_address_1 = '$nok_address',
			next_of_kin_address_2 = '$nok_address2',
			next_of_kin_town = '$nok_city',
			next_of_kin_state_code = '$nok_state',
			next_of_kin_phone = '$nok_phone',
			next_of_kin_email = '$nok_email',			 
            	surname = '$surname',
			firstname = '$firstname',
			middlename = '$middlename',
			email_address = '$email',
			company_code = '$company_code',
			mobile_phone_number = '$mobile',
			marital_status = '$marital_status',
			sex = '$sex',
			date_of_birth = '$date_of_birth',
            local_govt_of_origin_code = '$local_govt',state_origin = '$state_origin', pfa_code = '$pfa', pension_pin = '$pension_pin', nhf_pin = '$nhf_pin', bvn = '$bvn', nin = '$nin',1st_institution_code = '$institution',
		1st_qualification_code = '$qualification',
		1st_course_code = '$course_study',
		1st_result_grade = '$grade',
		1st_graduation_month_started = '$ist_graduation_month_started',
		1st_graduation_year_started = '$ist_graduation_year_started',
		1st_graduation_month_ended = '$ist_graduation_month_ended',
		1st_graduation_year = '$graduation_year',
		2nd_institution_code = '$institution2',
		2nd_qualification_code = '$qualification2',
		2nd_course_code = '$course_study2',
		2nd_result_grade = '$grade2',
		2nd_graduation_month_started = '$nd_graduation_month_started',
		2nd_graduation_year_started = '$nd_graduation_year_started',
		2nd_graduation_month_ended = '$nd_graduation_month_ended',
		2nd_graduation_year = '$graduation_year2',
		3rd_institution_code = '$institution3',
		3rd_qualification_code = '$qualification3',
		3rd_course_code = '$course_study3',
		3rd_result_grade = '$grade3',
		3rd_graduation_year = '$graduation_year3',
		nysc_id_no = '$nysc_id_no',
		end_date = '$end_date',
        completed = '$completed',
		start_date = '$start_date',
		date = '" . date('Y-m-d') . "'";
// echo $query;
// exit;

$result = mysqli_query($db, $query);

if ($result) {
	$success = 'Details Updated';
	// include("edit-candidate.php");
	$d = base64_encode($id);
	header("Location: add-staff?d=$d&del=success");
	exit;
} else {
	$error = 'Database Error';
	header("Location: add-staff?d=$id&del=error");
	exit;
}
