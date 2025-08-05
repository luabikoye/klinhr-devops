<?php

date_default_timezone_set("Africa/Lagos");


if ($_SERVER['HTTP_HOST'] == 'localhost:8062'){
  define("FILE_DIR", "/uploads/"); 
  define("UPLOAD_DIR", "../uploads/"); 
}else{
  define("FILE_DIR", "/uploads/");
  define("UPLOAD_DIR", "../uploads/");
}

//configuration difference for online and offline mode
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8888' || $_SERVER['HTTP_HOST'] == 'localhost:8062') {

  $_SESSION['testing_mode'] = 'yes'; //define uploads dir on local server 

} else {
  $_SESSION['testing_mode'] = '';
}
//Override the above on which ever
$_SESSION['testing_mode'] = 'yes';

function cutoff($cut_off)
{
  if ($_SESSION['testing_mode'] == 'yes') {
    return 2;
  } else {
    return $cut_off;
  }
}

function test_email()
{
  return 'mayowadelu@gmail.com';
  // return 'luabikoye@gmail.com';
  // return 'devops@aledoy.com';
}

function test_phone()
{
  // return 'luabikoye@yahoo.com';
  return '08181479043';
}

function approved_points()
{
  return 20;
}


function hrbp_admin_email()
{
  return 'devops@aledoy.com';
}

function root2()
{

  return 'http://' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI']));
}

function getWorkingDays($startDate,$endDate){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }    


    return $workingDays;
}



// function checkImage($image)
// {
//   require_once '/vendor/autoload.php';

//   $bucket = 'klinhr-demo';
//   $key = "document/$image"; // Adjust the key based on your file's location

//   $s3 = new S3Client([
//     'version' => 'latest',
//     'region'  => 'us-west-2',
//     'credentials' => [
//       'key'    => 'AKIAWMMZBL2XTD5SS7UO',
//       'secret' => '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',
//     ],
//   ]);

//   try {
//     $result = $s3->headObject([
//       'Bucket' => $bucket,
//       'Key' => $key,
//     ]);

//     // If the headObject request is successful, the file exists
//     echo "File exists!";
//   } catch (AwsException $e) {
//     // If an exception occurs, the file doesn't exist
//     if ($e->getStatusCode() === 404) {
//       echo "File does not exist.";
//     } else {
//       echo "Error: " . $e->getMessage();
//     }
//   }
// }



// function s3Image($logo)
// {

//   require_once '/vendor/autoload.php';


//   // Replace these values with your actual AWS credentials and S3 bucket information
//   $bucketName = 'klinhr-demo';
//   $accessKey = 'AKIAWMMZBL2XTD5SS7UO';
//   $secretKey = 'rO+YHBnjlK8m1ekK5Ts2cLU40mkZXcFE6Y2oT9E4';
//   $imageKey = 'https://klinhr-demo.s3.us-west-2.amazonaws/testing/' . $logo . ' ';

//   // Initialize the S3 client
//   $s3 = new S3Client([
//     'version'     => 'latest',
//     'region'  => 'us-west-2', // Replace with your AWS region
//     'credentials' => [
//       'key'    => $accessKey,
//       'secret' => $secretKey,
//     ],
//   ]);

//   // Check if the image exists in the S3 bucket
//   try {
//     $result = $s3->headObject([
//       'Bucket' => $bucketName,
//       'Key'    => $imageKey,
//     ]);

//     // The headObject call was successful, so the image exists
//     echo "The image with key '$imageKey' exists in the '$bucketName' bucket.\n";
//   } catch (AwsException $e) {
//     // If the headObject call fails, catch the exception and check the error code
//     if ($e->getAwsErrorCode() === 'NoSuchKey') {
//       echo "The image with key '$imageKey' does not exist in the '$bucketName' bucket.\n";
//     } else {
//       // Handle other exceptions or errors as needed
//       echo "Error: {$e->getMessage()}\n";
//     }
//   }
// }


// function getS3Image($objectKey)
// {
//   // require_once('../vendor/autoload.php'); 

//   // $bucketName = 'outsourcehr'; 

//   // // Create an S3 client
//   // $s3Client = new S3Client([
//   //   'version' => 'latest',
//   //   'region'  => 'eu-north-1', // Replace with your AWS region
//   //   'credentials' => [
//   //     'key'    => 'AKIATL6POK7NGMEYWAGY',
//   //     'secret' => 'SEkzdyXk/2f4yRkEAxKpwrRBMfaJe6xvpfkovJ2R',
//   //   ],
//   // ]);

//   // $presignedUrl = $s3Client->getCommand('GetObject', [
//   //   'Bucket' => $bucketName,
//   //   'Key' => $objectKey,
//   // ]);

//   // return $presignedUrl;

//   return "https://klinhr-demo.s3.us-west-2.amazonaws.com/$objectKey/";
// }

// function s3Upload($bucketName, $fileName, $fileLocation, $s3Folder)
// {
//   require_once 'vendor/autoload.php';

//   // Get credentials from environment variables (recommended)
//   $credentials = [
//     'version' => 'latest',
//     'region'  => 'us-west-2',
//     'credentials' => [
//       'key'    => 'AKIAWMMZBL2XTD5SS7UO',
//       'secret' => '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',
//     ],
//   ];

//   try {
//     $s3Client = new Aws\S3\S3Client($credentials);

//     // Determine content type
//     $finfo = finfo_open(FILEINFO_MIME_TYPE);
//     $contentType = finfo_file($finfo, $fileLocation);
//     finfo_close($finfo);

//     $result = $s3Client->putObject([
//       'Bucket' => $bucketName,
//       'Key'    => $s3Folder . $fileName,
//       'Body'   => fopen($fileLocation, 'rb'),
//       'ContentType' => $contentType,
//       'ACL'    => 'public-read' // If you want the file to be publicly accessible
//     ]);

//     return $result->get('ObjectURL');
//   } catch (Aws\Exception\AwsException $e) {
//     error_log("S3 Upload Error: " . $e->getMessage());
//     return "error";
//   }
// }



function list_bank()
{
  echo '<option>Access Bank Plc</option>
  <option>Accion Microfinance Bank</option>
  <option>Advans La Fayette Microfinance Bank</option>
  <option>Citibank Nigeria Limited</option>
  <option>Coronation Merchant Bank</option>
  <option>Covenant Microfinance Bank Ltd</option>
  <option>Ecobank Nigeria</option>
  <option>Empire Trust Microfinance Bank</option>
  <option>FBNQuest Merchant Bank</option>
  <option>Fidelity Bank Plc</option>
  <option>Fina Trust Microfinance Bank</option>
  <option>Finca Microfinance Bank Limited</option>
  <option>First Bank of Nigeria Limited</option>
  <option>First City Monument Bank Limited</option>
  <option>FSDH Merchant Bank</option>
  <option>Globus Bank Limited[3]</option>
  <option>Guaranty Trust Holding Company Plc</option>
  <option>Heritage Bank Plc</option>
  <option>Infinity Microfinance Bank</option>
  <option>Jaiz Bank Plc</option>
  <option>Keystone Bank Limited</option>
  <option>Kuda Bank</option>
  <option>LOTUS BANK</option>
  <option>Mint Finex MFB</option>
  <option>Mkobo MFB</option>
  <option>Mutual Trust Microfinance Bank</option>
  <option>Nova Merchant Bank</option>
  <option>Opay</option>
  <option>Palmpay</option>
  <option>Parallex Bank Limited</option>
  <option>Peace Microfinance Bank</option>
  <option>Pearl Microfinance Bank Limited</option>
  <option>Polaris Bank Limited</option>
  <option>PremiumTrust Bank Limited</option>
  <option>Providus Bank Limited</option>
  <option>Rand Merchant Bank</option>
  <option>Rephidim Microfinance Bank</option>
  <option>Rubies Bank</option>
  <option>Shepherd Trust Microfinance Bank</option>
  <option>Sparkle Bank</option>
  <option>Stanbic IBTC Bank Plc</option>
  <option>Standard Chartered</option>
  <option>Sterling Bank Plc</option>
  <option>SunTrust Bank Nigeria Limited</option>
  <option>TAJBank Limited</option>
  <option>Titan Trust Bank Limited</option>
  <option>Union Bank of Nigeria Plc</option>
  <option>United Bank for Africa Plc</option>
  <option>Unity Bank Plc</option>
  <option>VFD Microfinance Bank</option>
  <option>Wema Bank Plc</option>
  <option>Zenith Bank Plc</option>';
}
function get_time_ago($time)
{
  $time = strtotime($time);

  $time_difference = time() - $time;

  if ($time_difference < 1) {
    return 'less than 1 second ago';
  }
  $condition = array(
    12 * 30 * 24 * 60 * 60 =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach ($condition as $secs => $str) {
    $d = $time_difference / $secs;

    if ($d >= 1) {
      $t = round($d);
      return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
    }
  }
}

function get_info($candidate_id, $return_col)
{
  global $db;
  $query = "select * from jobseeker where candidate_id = '$candidate_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row[$return_col];
}

function Klin_admin_email()
{
  global $db;
  $query = "select * from login where privilege = 'admin' order by id asc";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['email'];
  // return 'luabikoye@yahoo.com';
}

function recruitment_approval()
{
  global $db;
  $select = "SELECT recruitment FROM smtp";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row['recruitment'];
}

function organisation()
{
  return 'KlinHR';
}
function org()
{
  return 'KlinHR';
}


function sender_name()
{
  return 'KlinHR';
}

function host_name()
{
  return 'https://' . $_SERVER['HTTP_HOST'];
}

function staff_portal()
{
  return $_SERVER['HTTP_HOST'].'/staffportal/';
}

function sender_email()
{
  // return 'noreply@'.$_SERVER['HTTP_HOST'];
  return smtp_detail('sender');
  // return 'testadministrator@icsoutsourcing.com';
}

function hr()
{
  // return 'noreply@'.$_SERVER['HTTP_HOST'];  
  return smtp_detail('hr');
  // return 'testadministrator@icsoutsourcing.com';
}

function smtp_hr_email()
{
  // return 'noreply@'.$_SERVER['HTTP_HOST'];  
  return smtp_detail('hr_email');
  // return 'testadministrator@icsoutsourcing.com';
}


function reply_email()
{
  return smtp_detail('reply');
}



function host()
{
  return 'http://' . $_SERVER['HTTP_HOST'];
}

function assessment_link()
{
  return '' . host() . '/assessment';
}


function root()
{
  if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8888' || $_SERVER['HTTP_HOST'] == 'localhost:8062') {
    return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
  } else {
    return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
  }

  // return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
}
function mydatetime()
{
  return date('Y-m-d h:i:s');
}
//  functions end
function admin_email()
{
  return smtp_detail('admin');
}

function show_img($image_name)
{
  if (file_exists($image_name)) {
    echo $image_name;
  } else {
    echo '/dist/images/dash-img.png';
  }
}
function candidate_image($tab, $can_id)
{

  global $db;
  $select = "select * from $tab where candidate_id = '$can_id'";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row['passport'];
}

function cat_by_jobs($jobName){
  global $db;  
  $select = mysqli_query($db, "SELECT * FROM job_post WHERE category = '$jobName'");
  $num = mysqli_num_rows($select);
  if ($num > 100) {
    return '100+';
  }else{
    return $num;
  }

}

function basic_profile($email)
{
   global $db;
  $select = "select * from jobseeker where email = '$email' and completed = 'updated'";
  $result = mysqli_query($db, $select);
  $num = mysqli_num_rows($result);
  if($num > 0)
  {
     return 'complete';
  }
  else{
    return 'incomplete';
  }
}

function check_yes_no($table, $col, $val)
{
  global $db;
  $select = "SELECT * FROM $table WHERE $col = '$val'";
  $result = mysqli_query($db, $select);
  $num = mysqli_num_rows($result);
  return $num;
}
function check_client()
{
  global $db;
  $select = "SELECT * FROM client";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row['client_logo'];
}



function list_documents()
{
  echo '
  <option value="Academics">Academics</option>
  <option value="Guarantor 1">Guarantor 1</option>
  <option value="Guarantor 2">Guarantor 2</option>
  <option disabled >-----------------------------</option>
  <option value="Address">Address</option>
  <option value="NYSC">NYSC</option>
  <option value="Criminal Check">Criminal Check</option>
  <option value="Previous Employer">Previous Employer</option>
  <option value="Medical Test">Medical Test</option>
  <option disabled >-----------------------------</option>
  <option value="Exit Letter">Exit Letter</option>
  <option value="Query">Query</option>
  <option value="Other">Other</option>
  ';
}
function country()
{
  echo '
  <option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D\'ivoire">Cote D\'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic People\'s Republic of">Korea, Democratic People\'s Republic of</option>
                <option value="Korea, Republic of">Korea, Republic of</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People\'s Democratic Republic">Lao People\'s Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
  ';
}

function country_code()
{
  echo '
  <option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91">India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		<!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		<!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
  ';
}

function pay_month($paymonth)
{
  global $db;
  $select = "select * from employees where pay_month = '$paymonth'";
  $result = mysqli_query($db, $select);
  $num = mysqli_num_rows($result);
  return $num;
}

function check_applied($id, $can_id)
{
  global $db;
  $query = "SELECT * FROM jobs_applied WHERE job_id = '$id' AND candidate_id = '$can_id'";
  $result = mysqli_query($db, $query);

  if ($result) {
    // mysqli_num_rows returns the number of rows in the result
    if (mysqli_num_rows($result) > 0) {
      return false;  // Candidate has applied for the job
    } else {
      return true; // Candidate has not applied
    }
  } else {
    // Handle query failure (optional)
    echo "Error fetching application data";
    return null;  // Or return a specific value to indicate error
  }
}



function VerificationStatus($candidate_id)
{
  global $db;

  $query = "select * from verified_document where candidate_id = '$candidate_id' || document_name  like '%Academics%'  and document_name like '%Guarantor 1%' and document_name like '%Guarantor 2%'  ";
  // $query = "select * from verified_document where candidate_id = '$candidate_id' || document_name  like '%Academics%'  and document_name like '%Guarantor 1%' and document_name like '%Guarantor 2%'  ";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  if ($num > 2) {
    return '<i style="color: green; font-size: 20px;" class="bi-check"> </i>';
  } else {
    return '<i style="color: red; font-size: 20px;" class="bi-x"> </i>';
  }
}

function SessionCheck()
{
  ob_start();
  session_start();
  // include('outsourcehr-admin/connection/connect.php');
  if (!isset($_SESSION['Klin_user'])) {
    include('login.php');
    exit;
  }
}


function get_job_salary($job_id)
{
  global $db;

  // $candidate = $_SESSION['Klin_user'];
  $job_id = "select * from job_post where id = '" . $job_id . "'";
  $result = mysqli_query($db, $job_id);
  $num  = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  return $row['salary'];
}


function check_updated($candidate_id)
{
  global $db;
  $query = "select * from jobseeker where firstname != '' and lastname != '' and email != '' and phone != '' and gender != '' and dob != '' and state != '' and local_govt != '' and address != '' and first_qualification != '' and first_institution != '' and first_degree != '' and first_course != '' and cv != '' and candidate_id = '$candidate_id'";

  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num != 0) {
    return 'yes';
  }
}



function CompleteProfile()
{
  include('app/connection/connect.php');
  return $return;
}

function StatusCheck()
{
  global $db;

  $status_query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "' ";
  $status_result = $db->query($status_query);
  $status_row = mysqli_fetch_array($status_result);

  if ($status_row['status'] == 'registerd') {
    echo '10';
  } elseif (!$status_row['firstname'] || !$status_row['lastname']  || !$status_row['passport']) {
    echo '20';
  } elseif ((!$status_row['first_qualification'])  || (!$status_row['first_institution'])   || !$status_row['first_degree'] || !$status_row['first_course']) {
    echo '30';
  } elseif (!$status_row['name_of_org'] || !$status_row['job_level']  || !$status_row['position'] || !$status_row['exp_year_start']  || !$status_row['experience_1'] || !$status_row['industry']  || !$status_row['achievement']) {
    echo '40';
  } elseif (!$status_row['facebook'] || !$status_row['instagram'] || !$status_row['twitter'] || !$status_row['linkedin']) {
    echo '50';
  } elseif (!$status_row['refName'] || !$status_row['refEmail'] || !$status_row['refPhone'] || !$status_row['refCompany']) {
    echo '60';
  } elseif (get_val('credentials', 'candidate_id', $status_row['candidate_id'], 'document') == 'CV') {
    echo '70';
  } elseif ($status_row['completed'] == 'updated') {
    echo '100';
  } else {
    echo '0';
  }
}
function  ProfileStatus()
{
  global $db;

  $status_query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "' ";
  $status_result = $db->query($status_query);
  $status_row = mysqli_fetch_array($status_result);

  if ($status_row['first_qualification'] == 'BACHELOR DEGREE') {
    echo '10';
  } elseif ($status_row['first_qualification'] == 'HND') {
    echo '20';
  } elseif ($status_row['first_qualification'] == 'MASTERS') {
    echo '30';
  } elseif ($status_row['first_degree'] == 'First Class') {
    echo '40';
  } elseif ($status_row['profCert']) {
    echo '50';
  } elseif ($status_row['name_of_org'] && $status_row['exp_year_start'] && $status_row['exp_year_end'] && $status_row['position']) {
    echo '60';
  } else {
    echo '0';
  }
}

function UserCheck($email)
{
  $email = $_SESSION['Klin_user'];
  global $db;

  $user_check = "select * from jobseeker_signup where email = '$email' ";
  $user_result =  mysqli_query($db, $user_check);
  $user_row = mysqli_fetch_assoc($user_result);
  return  $user_row['fullname'];
}


function user_roles()
{
  echo '
  <option value="Activity Log">Activity Log</option>
  <option value="Assessment">Assessment</option>
  <option value="Clients">Clients</option>
  <option value="Onboarding">Documentation</option>
  <option value="Deployment">Deploy Candidate</option>
  <option value="Appraisal">Employee Appraisal</option>
  <option value="General Setting">General Setting</option>
  <option value="Generate Report">Generate Report</option>
  <option value="Hr Operations">Hr Operations</option>
  <option value="HRBP">HRBP</option>
  <option value="Job Seeker">Job Seeker</option>
  <option value="Live Chat">Live Chat</option>
  <option value="Legal">Legal</option>
  <option value="Vacancies">Vacancies</option>
  <option value="Verification">Verification</option>
  <option value="Staff Documents">Staff Documents</option>
  <option value="Payroll">Payroll</option>
  <option value="Learning & Development">Learning & Development</option>
  <option value="">------------------------</option>
  <option value="Admin">Admin</option>
  <option value="Super Admin">Super Admin</option>';
}

function sub_user_roles()
{
  global $db;
  $account_token = $_SESSION['account_token'];
  $select = mysqli_query($db, "SELECT * FROM sub_account WHERE account_token = '$account_token' ");
  $row = mysqli_fetch_array($select);
  $user = $row['modules'];
  $roles = explode(',', $user);
  foreach ($roles as $role) {
    echo '<option value="' . trim($role) . '">' . trim($role) . '</option>';
  }
}
function sub_client(){
  global $db;
  $account_token = $_SESSION['account_token'];
  $select = mysqli_query($db, "SELECT * FROM clients WHERE account_token = '$account_token'");
  $num = mysqli_num_rows($select);
  for ($i=0; $i < $num; $i++) { 
    $row = mysqli_fetch_array($select);
    $client_code = $row['client_code'];
    $client_name = $row['client_name'];
    echo '<option value="' . trim($client_code) . '">' . trim($client_name) . '</option>';
  }
}
function check_module($privilege, $menu)
{
  if (strpos($privilege, $menu) !== false) {
    return 'yes';
  }
  if ($privilege == 'Super Admin' || $privilege == 'Admin') {
    return 'yes';
  }
}

function Check_Staff_Status($staff_id)
{

  global $db;
  $query = "select * from emp_staff_details where staff_id = '$staff_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  if ($row['status'] != 'Active') {
    $error = "Kindly check if your profile is  up to date before you can use the Staff Portal";
    include('update_profile.php');
    exit;
  }
}

function search($clients)
{
  $single = explode(',', $clients);
  return $clause = implode("%' || client like '%", $single);
}

function count_num_whr($tab, $ref)
{
  global $db;
  $qsPin =  mysqli_query($db, "SELECT * FROM $tab where refID = '$ref'");
  $nsPin = mysqli_num_rows($qsPin);
  return $nsPin;
}

function get_value($tab, $coln, $col, $id)
{
  global $db;
  $query = "select * from $tab where $coln = '$id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row[$col];
}

function search_emp($clients, $search)
{
  $single = explode(',', $clients);
  return $clause = implode("%' || firstname like '%$search%' && client like '%", $single);
}

function use_pin($tab, $pin, $col)
{
  global $db;
  $qsPin =  mysqli_query($db, "SELECT * FROM $tab WHERE pin = '$pin'");
  $rsPin = mysqli_fetch_assoc($qsPin);
  return $rsPin[$col];
}

function use_id($tab, $id, $col)
{
  global $db;
  $qsPin =  mysqli_query($db, "SELECT * FROM $tab WHERE id = '$id'");
  $rsPin = mysqli_fetch_assoc($qsPin);
  return $rsPin[$col];
}


function get_band_id($band, $client)
{
  global $db;
  "SELECT * FROM salary_band WHERE client = '$client' and band = '$band'";
  $qsPin =  mysqli_query($db, "SELECT * FROM salary_band WHERE client = '$client' and band = '$band'");
  $rsPin = mysqli_fetch_assoc($qsPin);
  return $rsPin['id'];
}

function get_deduct_id($band)
{
  global $db;
  // echo "SELECT * FROM deduct_name WHERE band_name= '$band'";
  $qsPin =  mysqli_query($db, "SELECT * FROM deduct_name WHERE band_name= '$band'");
  $rsPin = mysqli_fetch_assoc($qsPin);
  return $rsPin['deduct_id'];
}



function checkLoan($staffID)
{
  global $db;
  $qsFind = mysqli_query($db, "select * from loans where staff_id = '$staffID' && CURDATE() > expiration");
  $nsFind = mysqli_num_rows($qsFind);
  $rsFind = mysqli_fetch_assoc($qsFind);

  if ($nsFind > 0) {
    return $rsFind['per_month'];
  } else {
    return 0.00;
  }
}

function checkPayroll($staffID, $month, $year)
{
  global $db;

  $qsFind = mysqli_query($db, "select * from payroll where staff_id = '$staffID' && current_month = '$month' && current_year = '$year'");
  $nsFind = mysqli_num_rows($qsFind);

  if ($nsFind > 0) {
    return true;
  } else {
    return false;
  }
}


function validatePermission($module)
{

  include 'connection/connect.php';
  

  $modules = $_SESSION['privilege'];

  if (strpos($modules, $module) !== false) {
  } elseif ($modules == 'Super Admin' || $modules == 'Admin') {
  } else {
    header('location: dashboard?access=denied');
  }
}


function today()
{
  return date('Y-m-d');
}

function year()
{
  return date('Y');
}

function week()
{
  return date('W');
}

function doc_root()
{
  return $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);
}

function check_date()
{
  return date("Y-m-d", strtotime("-7 days", strtotime(today())));
}

function check_month()
{
  return date("Y-m-d", strtotime("-1 month", strtotime(today())));
}

function check_year()
{
  return date("Y");
}


function yesterday()
{
  return date("Y-m-d", strtotime("-1 day", strtotime(today())));
}

function end_date($effective_date)
{
  return date("Y-m-d", strtotime("+364 day", strtotime($effective_date)));
}

function long_date($date)
{
  return date('jS M, Y', strtotime($date));
}



function long_datetime($date)
{
  return date('jS M Y g:i:s A ', strtotime($date));
}
function short_date($date)
{
  return date('d M Y', strtotime($date));
}
function valid_date($date)
{
  $date = str_replace('/', '-', $date);

  return date('Y-m-d', strtotime($date));
}


function decode_client_name($client_code)
{

  global $db;
  $query = "select * from clients where client_code = '$client_code'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['client_name'];
  } else {
    return $client_code;
  }
}

function decode_position_name($position_code)
{

  global $db;
  $query = "select * from positions where positionCode = '$position_code'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['positionName'];
  } else {
    return $position_code;
  }
}

function decode_location_name($location_code)
{

  global $db;
  $query = "select * from locations where locationCode = '$location_code'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['locationName'];
  } else {
    return $location_code;
  }
}
function mytime()
{
  return date('Y-m-d h:i:s');
}

function now()
{
  return date('U');
}

function expire_time()
{
  return date("Y-m-d H:i:s", strtotime("+48 hours", strtotime(now())));
}


function getNextInterview($numDays = 3)
{
  $workingDays = [];
  $date = new DateTime(); // Start from today

  while (count($workingDays) < $numDays) {
    $dayOfWeek = $date->format('N'); // 1 (for Monday) through 7 (for Sunday)

    // If it's a weekday (Monday to Friday)
    if ($dayOfWeek <= 5) {
      $workingDays[] = $date->format('Y-m-d'); // Add to working days
    }

    // Move to the next day
    $date->modify('+1 day');
  }

  return $workingDays[2];
}


function reminder_48()
{
  return date("Y-m-d", strtotime("+48 hours", strtotime(today())));
}

function profile_img()
{
  global $db;
  $query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $file = 'app/document/' . $row['passport'];
  if (!$row['passport']) {
    $file =  'images/dashpic.png';
  }
  echo $file;
}
// exam
function exam_time($job_id)
{
  global $db;
  $query = "select * from assessment where job_id = '$job_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['duration'];
}

function num_questions($job_id)
{
  global $db;
  $query = "select * from assessment where job_id = '$job_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['no_of_question'];
}

function get_exam_end_time($start, $job_id)
{
  $exam_time = exam_time($job_id);

  return date("Y-m-d H:i:s", strtotime("+ $exam_time mins", strtotime($start)));
}

function check_exam_status($email, $code)
{
  global $db;
  $query = "select * from exam_result where email = '$email' and exam_code = '$code'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['status'];
}

function check_flag($candidate_id)
{
  global $db;
  $query = "select * from application_history where candidate_id = '$candidate_id' and action = 'Returned to pool'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return '<a href="view-comment?id=' . base64_encode($candidate_id) . '" title="Candidate returned to available pool"><small><i
	class="fas fa-x1 text-danger bi-flag-fill"></i></small></a>';
  }
}
function get_time_left($end_time)
{
  $datetime1 = new DateTime();
  $datetime2 = new DateTime($end_time);
  $interval = $datetime1->diff($datetime2);
  //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
  $elapsed = $interval->format('%i:00');
  return $elapsed;
}

function score_question($user, $q_a, $q_type)
{

  global $db;

  if ($q_type == 'multiple') {

    $q_a =  explode(',', $q_a); // seperate value by comma into array

    for ($i = 0; $i < count($q_a); $i++) {
      $ques = explode('=', $q_a[$i]);
      $ques_no = $ques[0];
      $list_ans[] = $ques[1];
    }
    sort($list_ans);
    $ans = implode(',', $list_ans);
  } else {

    $ques = explode('=', $q_a);
    $ques_no = $ques[0];
    $ans = $ques[1];
  }

  if (!$q_a) {
    return NULL;
  } else {

    $query = "select * from questions where id = '$ques_no' and answer = '$ans'";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
      return 1;
    } else {
      return 0;
    }
  }
}
function string_by_colD($col, $id)

{
  global $db;
  $query = "select * from appraisald where appraisal_id='$id'";

  $result = mysqli_query($db, $query);

  if ($result) {

    $row = mysqli_fetch_array($result);

    return $row[$col];
  }
}


function string_by_col($col, $staff_id)

{

  global $db;
  $query = "select * from emp_appraisald_self where staff_id = '$staff_id'";
  $result = mysqli_query($db, $query);
  if ($result) {
    $row = mysqli_fetch_array($result);
    return $row[$col];
  }
}



function value_by_col($col, $id)

{

  global $db;

  $query = "select * from appraisal where appraisal_id='$id'";

  $result = mysqli_query($db, $query);


  if ($result) {

    $row = mysqli_fetch_array($result);

    return intval($row[$col]);
  } else {

    return intval(0);
  }
}

//exam

function test_expiration()
{
  $now = date("Y-m-d g:i:s");
  return date("Y-m-d g:i:s", strtotime("+48 hours", strtotime($now)));
}

function mydate($date)
{
  $date = str_replace('/', '-', $date);

  return date('Y-m-d', strtotime($date));
}


function test_code($email, $candidate_id)
{
  $char = $candidate_id . rand(120833, 999999);
  return substr($char, 0, 6);
}

function check_assessment($job_title = 'General')
{
  global $db;

  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return 'confirm';
  } else {
    return 'not available';
  }
}

function get_admin_name($user)
{

  global $db;

  $user = $_SESSION['Klin_admin_user'];
  $query = "select * from login where username = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}
function get_job_id()
{

  global $db;

  // $candidate = $_SESSION['Klin_user'];
  $job_id = "select * from jobs_applied where candidate_id = '" . $_SESSION['Klin_user'] . "'";
  $result = mysqli_query($db, $job_id);
  $num  = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  return $row['job_id'];
}

function get_hrbp($client)
{
  global $db;
  $query = "select * from login where privilege like '%HRBP%' and client like '%$client%' OR client = 'ALL' order by id asc";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['email'];

  // return 'luabikoye@yahoo.com';

}


function get_job()
{

  global $db;

  // $candidate = $_SESSION['Klin_user'];
  $query = "select * from jobseeker where id = '" . $_SESSION['candidate_id'] . "'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $_SESSION['candidate_id'];
}

function get_user($user)
{

  global $db;

  $user = $_SESSION['Klin_user'];
  $query = "select * from login where username = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}
function get_onboarding_user($email)
{

  global $db;

  $query = "select * from emp_staff_details where email_address = '$email'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['surname']);
}

function get_age($date)
{
  return floor((time() - strtotime($date)) / 31556926);
}

function user_name($user_name)
{

  global $db;

  $user_name = $_SESSION['Klin_admin_user'];
  $query = "select * from login where username = '$user_name'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}


function payroll_mail()
{
  return 'devops@aledoy.com';
}

function privilege()
{
  ob_start();
  session_start();
  global $db;
  $priv = $_SESSION['Klin_admin_user'];
  $sql =  "select * from login where username = '$priv'  ";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);
  $privilege = $row['privilege'];
  return $privilege;
}

function count_num_val($tab, $col, $val)
{
  global $db;
  $query = "select * from $tab where $col = '$val'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return $num;
  } else {
    return 0;
  }
}

function get_data($id, $col)
{
  global $db;
  $query = "select * from course where refID = '$id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_num_rows($result);
  return $row[$col];
}

function get_job_post_id($job_title)
{

  global $db;
  $query = "select * from job_post where job_title = '$job_title'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['category'];
}

function job_author($job_id)
{
  global $db;
  $query = "select * from job_post where id = '$job_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $user = $row['author'];

  //get user full name
  $query = "select * from login where username = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $fullname = $row['firstname'] . ' ' . $row['lastname'];

  return $fullname;
}

function get_client_name($id)
{

  global $db;
  $query = "select * from clients where id = '$id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['client_name'];
}


function get_fullname($email)
{
  global $db;

  $query = "select * from jobseeker where email = '$email'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num) {
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  } else {
    $query = "select * from login where email = '$email'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  }
}

function get_firstname($email)
{
  $names = explode(' ', get_fullname($email));

  return $names[0];
}
function get_candidate_name($email)
{
  global $db;

  $query = "select * from participant where email = '$email'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num) {
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  }
}

function get_post_per($job_id)
{
  global $db;
  // $query = "select * from jobs_applied";
  // $result = mysqli_query($db, $query);
  // $total = mysqli_num_rows($result);

  // $query2 = "select * from jobs_applied where job_id = '$job_id'";
  // $result2 = mysqli_query($db, $query2);
  // $total_post = mysqli_num_rows($result2);

  // $percentage = $total_post / $total * 100;

  // return round($percentage) . '%';


  $job_id = 'some_job_id'; // replace with the actual job_id value

  // Fetch total number of job applications
  $query = "SELECT * FROM jobs_applied";
  $result = mysqli_query($db, $query);

  if (!$result) {
    die('Error: ' . mysqli_error($db));
  }

  $total = mysqli_num_rows($result);

  // Fetch number of job applications for a specific job_id using prepared statement
  $query2 = "SELECT * FROM jobs_applied WHERE job_id = ?";
  $stmt = $db->prepare($query2);
  $stmt->bind_param('s', $job_id); // Assuming job_id is a string. Use 'i' if it's an integer.
  $stmt->execute();
  $result2 = $stmt->get_result();

  if (!$result2) {
    die('Error: ' . mysqli_error($db));
  }

  $total_post = $result2->num_rows;

  // Calculate percentage
  if ($total > 0) {
    $percentage = ($total_post / $total) * 100;
    $rounded_percentage = round($percentage) . '%';
  } else {
    $rounded_percentage = '0%';
  }

  return $rounded_percentage;
}

function get_candidate_status($candidate_id)
{
  global $db;
  $query = "select * from application_history where candidate_id = '$candidate_id' order by id desc";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['status'];
  } else {
    return 'Registration';
  }
}

function status_color($value)
{
  $status = strtolower($value);

  if ($status == 'approved' || $status == 'active' || $status == 'updated') {
    return 'success';
  } else {
    return 'warning';
  }
}

function progress($value)
{
  $status = strtolower($value);

  if ($status == 'approved') {
    return '50';
  } elseif ($status == 'active') {
    return '100';
  } elseif ($status == 'updated') {
    return '25';
  } else {
    return '0';
  }
}

function progress_color($value)
{
  $status = strtolower($value);

  if ($status == 'approved') {
    return 'success';
  } elseif ($status == 'active') {
    return 'success';
  } elseif ($status == 'updated') {
    return 'primary';
  } else {
    return 'warning';
  }
}

function count_tab($tab)
{
  if ($_SESSION['account_token']) {
    sub_count_tab($tab);
  }else{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from $tab"));
  return $count;
  }
}

function sub_count_tab($tab)
{
  global $db;
  $email = $_SESSION['account_token'];
  $count = mysqli_num_rows(mysqli_query($db, "select * from $tab WHERE account_token = '$email'"));
  return $count;
}

function counts()
{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from job_post where status != 'approved'"));
  return $count;
}

function seeker_percent()
{
  global $db;
  $total = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup"));
  $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status = 'active' "));


  $percentage = ($count / $total) * 100;
  return $percentage;
}

function not_seeker_percent()
{
  global $db;
  $seeker_percent = seeker_percent();
  $not_seeker_percent = 100 - $seeker_percent;
  return $not_seeker_percent;
}
function sub_seeker_percent()
{
  if (!$_SESSION['account_token']) {
    seeker_percent();
  } else {
    global $db;
    $total = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where account_token = '" . $_SESSION['account_token'] . "'"));
    $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status = 'active' and account_token = '" . $_SESSION['account_token'] . "' "));
    if ($count == 0) {
      return 0;
    }

    $percentage = ($count / $total) * 100;
    return $percentage;
  }
}

function sub_not_seeker_percent()
{
  if (!$_SESSION['account_token']) {
    not_seeker_percent();
  } else {
    global $db;
    $seeker_percent = sub_seeker_percent();
    if (sub_seeker_percent() == 0) {
      return 0;
    }
    $not_seeker_percent = 100 - $seeker_percent;
    return $not_seeker_percent;
  }
}

function sub_account(){
  global $db;
  $email = $_SESSION['Klin_admin_email'];
  $stmt = mysqli_query($db, "SELECT * FROM sub_account WHERE email = '$email'");
  $num = mysqli_num_rows($stmt);
  if ($num != 0) {
    return 'yes';
  }else{
    return 'no';
  }
}

function not_active()
{
  if ($_SESSION['account_token']) {
    sub_not_active();
  } else {
    global $db;
    $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status != 'active'"));
    return $count;
  }
}
function sub_not_active()
{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status != 'active' and account_token = '".$_SESSION['account_token']."'"));
  return $count;
}

function count_tab_val($tab, $col, $val)
{
  if($_SESSION['account_token']){
    sub_count_tab_val($tab, $col, $val, $email = $_SESSION['account_token']);
  }else{
    
  global $db;
  if ($val == 'NULL') {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col IS NULL"));
  } else {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col = '$val'"));
  }
  return $count;
  }
}
function sub_count_tab_val($tab, $col, $val, $email)
{
  global $db;
  if ($val == 'NULL') {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col IS NULL AND account_token = '$email'"));
  } else {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col = '$val' AND account_token = '$email'"));
  }
  return $count;
}

function get_client($tab, $col, $val)
{
  global $db;
  $query = "select * from $tab order by $val";
  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);
  echo '' . $row[$val] . '"' . $row[$col] . '';
}

function get_extension($filename)

{

  $ext = explode('.', $filename);

  $ext2 = str_replace(' ', '', $ext);

  $extension = array_reverse($ext2);

  return strtolower($extension[0]);
}

function resigned_staff($staff_id)
{
  $today = date('Y-m-d');
  global $db;
  $query = "select * from emp_resignation where staff_id = '$staff_id' and date < '$today'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return 'true';
    exit;
  }

  $query1 = "select * from emp_staff_details where staff_id = '$staff_id' and status = 'Inactive' ";
  $result1 = mysqli_query($db, $query1);
  $num1 = mysqli_num_rows($result1);
  if ($num1 > 0) {
    return 'valid';
    exit;
  }
}


function validate_file($filename)
{
  $get_ext = explode('.', $filename);
  $get_ext2 = array_reverse($get_ext);
  $file_extension = $get_ext2[0];
  $extension = strtolower($file_extension);

  if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif' || $extension == 'pdf' || $extension == 'ppt' || $extension == 'pptx') {
    return 'valid';
  } else {
    return 'invalid';
  }
}



function list_val($tab, $col, $val)
{
  if ($_SESSION['account_token']) {    
    sub_list_val($tab, $col, $val);
  }else{
  global $db;
  $query = "select * from $tab order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$val] . '">' . $row[$col] . '</option>';
  }
}
}

function sub_list_val($tab, $col, $val)
{
  global $db;
  $query = "select * from $tab";
  if ($tab != 'locations' && $_SESSION['account_token']) {
    $query .= " where account_token = '{$_SESSION['account_token']}'";
  }
  $query .= " order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$val] . '">' . $row[$col] . '</option>';
  }
}

function manager_name()
{
  global $db;
  $query = "select * from emp_staff_details order by id";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['staff_id'].'">' . $row['firstname'] . ' ' . $row['surname'] . '</option>';
  }
}



function get_val($tab, $col, $val, $return_val)
{
  global $db;
  $query = "select * from $tab where $col = '$val';";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row[$return_val];
}

function get_result($email)
{
  global $db;
  $query = "select * from exam_result where email = '$email' order by average desc";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['average'];
}

function getmessagetem()
{
  global $db;
  $query = "select * from message_template where template_name like '%Offer Letter%' order by template_name";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['id'] . '">' . $row['template_name'] . '</option>';
  }
}

function staff_id_exists($staff_id)
{
  global $db;
  $query = "select * from emp_staff_details where staff_id = '$staff_id'";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);
  if ($num_result > 0) {
    return 'yes';
  }
}
function get_val2($tab, $col, $val, $col2, $val2, $return_val)
{
  global $db;
  $query = "select * from $tab where $col = '$val' && $col2 = '$val2'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row[$return_val];
}

function CheckValue($tab, $col, $val)
{
  global $db;
  $new_notification_query = "select * from $tab where $col = '$val' ";
  $new_notification_result = mysqli_query($db, $new_notification_query);
  $new_notification_num = mysqli_num_rows($new_notification_result);
  // $new_notification_row = mysqli_fetch_array($new_notification_result);
  if ($new_notification_num > 5) {
    echo '+';
  }
}


function random($col, $tab)
{
if ($_SESSION['account_token']) {
    random2($col, $tab);
}else{
    global $db;
    $query = "select distinct $col from $tab where $col != ''";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);
    for ($i = 0; $i < $num; $i++) {
      $row = mysqli_fetch_array($result);
      echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
    }
    return [$col];
  
  }
}

function random2($col, $tab)
{

  global $db;
  $query = "select distinct $col from $tab where $col != '' and account_token = '".$_SESSION['account_token']."'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
  }
  return [$col];
}

//list option from database table
function list_option($tab, $col, $val)
{
  global $db;

  $query = "select distinct $col,$val from $tab order by $col";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$val] . '">' . $row[$col] . '</option>';
  }
}

function list_option_whr($tab, $col, $val, $type)
{
  global $db;

  $query = "select distinct $col,$val from $tab where type = '$type' order by $col";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$val] . '">' . $row[$col] . '</option>';
  }
}

function list_val_distinct($tab, $col)
{
  global $db;
  $query = "select distinct $col from $tab where $col IS NOT NULL and $col != '' order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
  }
}

function list_val_distinct_active($tab, $col)
{
  if ($_SESSION['account_token']) {
    sub_list_val_distinct_active($tab, $col);
  } else {
    global $db;
    $query = "select distinct $col from $tab where $col IS NOT NULL and $col != '' and status = 'active' order by $col";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);
    for ($i = 0; $i < $num; $i++) {
      $row = mysqli_fetch_array($result);
      echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
    }
  }
}
function sub_list_val_distinct_active($tab, $col)
{
  global $db;
  $query = "select distinct $col from $tab where account_token = '".$_SESSION['account_token']."' and $col IS NOT NULL and $col != '' and status = 'active' order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
  }
}

function list_job_client()
{
  global $db;
  $query = "select distinct client_id from job_post";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['client_id'] . '">' . get_client_name($row['client_id']) . '</option>';
  }
}

function cat_selected($cat, $assessment_id)
{
  global $db;
  $query = "select * from assessment where id = '$assessment_id' and category like '%" . $cat . "%'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    echo 'selected';
  }
}

function list_month()
{
  echo ' <option>January</option>
  <option>February</option>
  <option>March</option>
  <option>April</option>
  <option>May</option>
  <option>June</option>
  <option>July</option>
  <option>August</option>
  <option>September</option>
  <option>October</option>
  <option>November</option>
  <option>December</option>';
}

function get_remark($job_title, $score)
{
  global $db;
  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return 'Passed';

  if ($score >= $row['pass_mark']) {
    return 'Passed';
  } else {
    return 'Failed';
  }
}
function get_off($job_title)
{
  global $db;
  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['pass_mark'];
  } else {
    return 50;
  }
}


function compute_pay($client, $salary_band, $comp)
{
  global $db;


  $query = "select * from salary_band where client = '$client' and band = '$salary_band'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  $annual_salary = $row['salary'];
  $salary = $row['salary'] / 12;


  if ($comp == 'salary') {
    if ($num > 0) {
      return $salary;
    }
    return 0;
  } else {
    //query settings to get component percentage]
    $query_set = "select * from settings where client = '$client' and band = '$salary_band'";
    $result_set = mysqli_query($db, $query_set);
    $row_set = mysqli_fetch_array($result_set);
    $comp_value = $row_set[$comp];

    $value = ($comp_value / 100) * $salary;

    return $value;
  }
}


function get_end_time($start)
{

  return date("Y-m-d: H:i:s", strtotime("+ 29 mins", strtotime($start)));
}

function list_district()

{

  global $db;

  $query = "select distinct state from local_govt where country = 'Ghana'";


  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {

    $row = mysqli_fetch_array($result);

    echo '<option value="' . $row['state'] . '">' . $row['state'] . '</option>';
  }
}
function list_state()

{

  global $db;

  $query = "select distinct state from local_govt order by state";


  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {

    $row = mysqli_fetch_array($result);

    echo '<option value="' . $row['state'] . '">' . $row['state'] . '</option>';
  }
}

function get_annual_tax($taxable)
{
  if ($taxable > 3200000) {
    $annual = 560000 + ($taxable - 3200000) * (24 / 100);
  } elseif ($taxable > 1100000) {
    $annual = 129000 + ($taxable - 1100000) * (19 / 100);
  } elseif ($taxable > 600000) {
    $annual = 54000 + ($taxable - 600000) * (15 / 100);
  } elseif ($taxable > 300000) {
    $annual = 21000 + ($taxable - 300000) * (11 / 100);
  } elseif ($taxable < 300000) {
    $annual = $taxable * (7 / 100);
  } else {
    $annual = $taxable;
  }

  return $annual;
}

function request_status($query, $status)
{
  global $db;
  $query_run = "$query and status = '$status'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
  //return 10;
}
function get_status($query, $tab, $status)
{
  global $db;
  $query_run = "$query and $tab = '$status'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
  //return 10;
}

function getClientIP() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



function token($length = 32) {
    return bin2hex(random_bytes($length));
}

function activity_log($Klin_user, $action)
{
  $date_time = date('Y-m-d h:i:s');

  global $db;
  $sql_1 = "insert into activity_log set author = '$Klin_user', fullname = '" . get_fullname($Klin_user) . "', action_taken = '$action', date = '$date_time'";
  $sql_result = mysqli_query($db, $sql_1);
}

function progress_percentage($jobs_num,$num){
  return ($num / $jobs_num) * 100;
}

function get_approve_details($id, $col)
{

  global $db;
  $select = "SELECT * FROM approve_message WHERE id = '$id'";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row[$col];
}
function get_clients($col)
{

  global $db;
  $select = "SELECT * FROM clients WHERE client_code = '$col'";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row['client_name'];
}

function notification_email($val)
{
  global $db;
  $query = "select * from notification_email where privilege = '$val'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row["email"];
}

function assessment_log($ats_candidate, $action)
{
  $ats_candidate = $_SESSION['ats_candidate'];

  global $db;
  $sql_1 = "insert into activity_log set author = '$ats_candidate', fullname = '" . get_candidate_name($ats_candidate) . "', action_taken = '$action'";
  $sql_result = mysqli_query($db, $sql_1);
}

function application_log($candidate_id, $job_id, $action, $status = 'Applied')
{
  $date_time = date('Y-m-d h:i:s');

  global $db;
  $sql_1 = "insert into application_history set candidate_id = '$candidate_id', job_id = '$job_id', action = '$action', status = '$status', date_modified = '$date_time'";
  $sql_result = mysqli_query($db, $sql_1);
}


function bold_text($status)
{
  if ($status == 'Unread' || $status == 'unread') {
    return 'style="font-weight:bold;"';
  }
}

function list_degree()
{
  echo ' <option id="1">First Class</option>

	<option value="Second Class Upper" id="2">Second Class Upper</option>
	<option value="Second Class Lower" id="3">Second Class Lower</option>
	<option value="Third Class" id="4">Third Class</option>
	<option value="Distinction" id="5">Distinction</option>
	<option value="Upper Credit" id="6">Upper Credit</option>
	<option value="Lower Credit" id="7">Lower Credit</option>';
}
function list_job_level()
{
  echo '

  <option value="Officer">Officer</option>
  <option value="Supervisor">Supervisor</option>
  <option value="Asst. Manager">Asst. Manager</option>
  <option value="Manager">Manager</option>
  <option value="Senior Manager">Senior Manager</option>
  <option value="Asst. General Manager">Asst. General Manager</option>
  <option value="General Manager">General Manager</option>
  <option value="Director">Director</option>';
}

function list_qualifications()
{
  echo '<option value="FSLC">First School Leaving Certificate(FSLC)</option>
  <option value="SSCE">SSCE</option>
  <option value="NCE">NCE</option>
  <option value="OND">OND</option>
  <option value="HND">HND</option>
  <option value="BACHELOR DEGREE">BACHELOR DEGREE</option>
	<option value="MASTERS">MASTERS</option>';
}

function list_class_degree()
{
  echo '<option value="First Class">First Class</option>
  <option value="Distinction">Distinction</option>
  <option value="Second Class Upper">Second Class Upper</option>
  <option value="Second Class Lower">Second Class Lower</option>
  <option value="Lower Credit">Lower Credit</option>
  <option value="Third Class">Third Class</option>
  <option value="Pass">Pass</option>
  ';
}
function list_salary()
{
  echo '
  <option value="50,000 - 100,000">  &#8358;50,000 -  &#8358;100,000</option>
  <option value="100,000 - 150,000"> &#8358;100,000 - &#8358;150,000</option>
  <option value="150,000 - 200,000"> &#8358;150,000 - &#8358;200,000</option>
  <option value="200,000 - 300,000"> &#8358;200,000 - &#8358;300,000</option>
  <option value="300,000 - 400,000"> &#8358;300,000 - &#8358;400,000</option>
  <option value="400,000 - 500,000"> &#8358;400,000 - &#8358;500,000</option>
  <option value="500,000 and Above"> &#8358;500,000 and Above</option>

			';
}

function list_roles()
{
  echo '<option>Accounting</option>
  <option>Administrative</option>
  <option>Finance</option>
  <option>IT and Development</option>
  <option>Programmer</option>
  <option>Full Stack Developer</option>
  <option>Design</option>
  <option>Customer Service</option>
  <option>Corporate Training </option>
  <option>Engineering</option>
  <option>Electrical Works</option>
  <option>Construction</option>
  <option>Oil and Gas</option>
  <option>Transportation & Logistics</option>
  <option>Banking & Banking Operations</option>
  <option>Healthcare</option>
  <option>Real Estate</option>
  <option>Manufacturing</option>
  <option>Sales</option>
  <option>Business Development</option>
  <option>Direct Sales – Retail </option>
  <option>Telecommunications</option>
  <option>FMCG</option>
  <option>Pharmaceutical</option>
  <option>Medical Sciences</option>
  <option>Radio & TV Broadcasting</option>
  <option>Hospital Services</option>
  <option>Education and Educational Services</option>
  <option>Hospitality</option>
  <option>Legal</option>';
}
function year_list($start)
{
  for ($i = $start; $i <= date('Y'); $i++) {
    echo '<option>' . $i . '</option>';
  }
}



function list_institution()
{
  echo ' <option value="Abia State University, Uturu.">Abia State University, Uturu.</option>
      	      <option value="Abubakar Tafawa Balewa University, Bauchi">Abubakar Tafawa Balewa University, Bauchi</option>
      	      <option value="Achievers University, Owo">Achievers University, Owo</option>
      	      <option value="Adamawa State University Mubi">Adamawa State University Mubi</option>
      	      <option value="Adekunle Ajasin University, Akungba.">Adekunle Ajasin University, Akungba.</option>
      	      <option value="Adeleke University,Ede.">Adeleke University,Ede.</option>
      	      <option value="Afe Babalola University, Ado-Ekiti - Ekiti State">Afe Babalola University, Ado-Ekiti - Ekiti State</option>
      	      <option value="African University of Science &amp; Technology, Abuja">African University of Science &amp; Technology, Abuja</option>
      	      <option value="Ahmadu Bello University, Zaria">Ahmadu Bello University, Zaria</option>
      	      <option value="Ajayi Crowther University, Ibadan">Ajayi Crowther University, Ibadan</option>
      	      <option value="Akwa Ibom State University of Technology, Uyo">Akwa Ibom State University of Technology, Uyo</option>
      	      <option value="Al-Hikmah University, Ilorin">Al-Hikmah University, Ilorin</option>
      	      <option value="Ambrose Alli University, Ekpoma">Ambrose Alli University, Ekpoma,</option>
      	      <option value="American University of Nigeria, Yola">American University of Nigeria, Yola</option>
      	      <option value="Anambra State University of Science &amp; Technology, Uli">Anambra State University of Science &amp; Technology, Uli</option>
      	      <option value="Babcock University,Ilishan-Remo">Babcock University,Ilishan-Remo</option>
      	      <option value="Bauchi State University, Gadau">Bauchi State University, Gadau</option>
      	      <option value="ayero University,Kano">Bayero University,Kano</option>
      	      <option value="Baze University">Baze University</option>
      	      <option value="Bells University of Technology, Otta">Bells University of Technology, Otta</option>
      	      <option value="Benson Idahosa University,Benin City">Benson Idahosa University,Benin City</option>
      	      <option value="Benue State University, Makurdi.">Benue State University, Makurdi.</option>
      	      <option value="Bingham University, New Karu">Bingham University, New Karu</option>
      	      <option value="Bowen University, Iwo">Bowen University, Iwo</option>
      	      <option value="Bukar Abba Ibrahim University, Damaturu.">Bukar Abba Ibrahim University, Damaturu.</option>
      	      <option value="Caleb University, Lagos">Caleb University, Lagos</option>
      	      <option value="Caritas University, Enugu">Caritas University, Enugu</option>
      	      <option value="CETEP City University, Lagos">CETEP City University, Lagos</option>
      	      <option value="Covenant University Ota">Covenant University Ota</option>
      	      <option value="Crawford University Igbesa">Crawford University Igbesa</option>
      	      <option value="Crescent University,">Crescent University,</option>
      	      <option value="Cross River State University of Science &amp;Technology, Calabar">Cross River State University of Science &amp;Technology, Calabar</option>
      	      <option value="Delta State University Abraka">Delta State University Abraka</option>
      	      <option value="Ebonyi State University, Abakaliki">Ebonyi State University, Abakaliki</option>
      	      <option value="Ekiti State University">Ekiti State University</option>
      	      <option value="Elizade University, Ilara-Mokin">Elizade University, Ilara-Mokin</option>
      	      <option value="Enugu State University of Science and Technology, Enugu">Enugu State University of Science and Technology, Enugu</option>
      	      <option value="Evangel University, Akaeze">Evangel University, Akaeze</option>
      	      <option value="Federal University Gashua">Federal University Gashua</option>
      	      <option value="Federal University of Petroleum Resources, Effurun">Federal University of Petroleum Resources, Effurun</option>
      	      <option value="Federal University of Technology, Akure">Federal University of Technology, Akure</option>
      	      <option value="Federal University of Technology, Minna.">Federal University of Technology, Minna.</option>
      	      <option value="Federal University of Technology, Owerri">Federal University of Technology, Owerri</option>
      	      <option value="Federal University, Dutse, Jigawa State">Federal University, Dutse, Jigawa State</option>
      	      <option value="Federal University, Dutsin-Ma, Katsina">Federal University, Dutsin-Ma, Katsina</option>
      	      <option value="Federal University, Kashere, Gombe State">Federal University, Kashere, Gombe State</option>
      	      <option value="Federal University, Lafia, Nasarawa State">Federal University, Lafia, Nasarawa State</option>
      	      <option value="Federal University, Lokoja, Kogi State">Federal University, Lokoja, Kogi State</option>
      	      <option value="Federal University, Ndufu-Alike, Ebonyi State">Federal University, Ndufu-Alike, Ebonyi State</option>
      	      <option value="Federal University, Otuoke, Bayelsa">Federal University, Otuoke, Bayelsa</option>
      	      <option value="Federal University, Oye-Ekiti, Ekiti State">Federal University, Oye-Ekiti, Ekiti State</option>
      	      <option value="Federal University, Wukari, Taraba State">Federal University, Wukari, Taraba State</option>
      	      <option value="ederal University,Birnin Kebbi.">Federal University,Birnin Kebbi.</option>
      	      <option value="Federal University,Gusau.">Federal University,Gusau.</option>
      	      <option value="Fountain Unveristy,Oshogbo">Fountain Unveristy,Oshogbo</option>
      	      <option value="Godfrey Okoye University, Ugwuomu-Nike - Enugu State">Godfrey Okoye University, Ugwuomu-Nike - Enugu State</option>
      	      <option value="Gombe State Univeristy, Gombe">Gombe State Univeristy, Gombe</option>
      	      <option value="Gregory University, Uturu">Gregory University, Uturu</option>
      	      <option value="Ibrahim Badamasi Babangida University, Lapai">Ibrahim Badamasi Babangida University, Lapai</option>
      	      <option value="Igbinedion University Okada">Igbinedion University Okada</option>
      	      <option value="Ignatius Ajuru University of Education,Rumuolumeni.">Ignatius Ajuru University of Education,Rumuolumeni.</option>
      	      <option value="Imo State University, Owerri">Imo State University, Owerri</option>
      	      <option value="Joseph Ayo Babalola University, Ikeji-Arakeji">Joseph Ayo Babalola University, Ikeji-Arakeji</option>
      	      <option value="Kaduna State University, Kaduna">Kaduna State University, Kaduna</option>
      	      <option value="Kano University of Science &amp; Technology, Wudil">Kano University of Science &amp; Technology, Wudil</option>
      	      <option value="Katsina University, Katsina">Katsina University, Katsina</option>
      	      <option value="Kebbi State University, Kebbi">Kebbi State University, Kebbi</option>
      	      <option value="Kogi State University Anyigba">Kogi State University Anyigba</option>
      	      <option value="Kwara State University, Ilorin">Kwara State University, Ilorin</option>
      	      <option value="Ladoke Akintola University of Technology, Ogbomoso">Ladoke Akintola University of Technology, Ogbomoso</option>
      	      <option value="Lagos State University Ojo, Lagos.">Lagos State University Ojo, Lagos.</option>
      	      <option value="Landmark University,Omu-Aran.">Landmark University,Omu-Aran.</option>
      	      <option value="Lead City University, Ibada">Lead City University, Ibadan</option>
      	      <option value="Madonna University, Okija">Madonna University, Okija</option>
      	      <option value="Mcpherson University, Seriki Sotayo, Ajebo">Mcpherson University, Seriki Sotayo, Ajebo</option>
      	      <option value="Michael Okpara Uni. of Agric., Umudike">Michael Okpara Uni. of Agric., Umudike</option>
      	      <option value="Modibbo Adama University of Technology, Yola">Modibbo Adama University of Technology, Yola</option>
      	      <option value="Nasarawa State University, Keffi">Nasarawa State University, Keffi</option>
      	      <option value="National Open University of Nigeria, Lagos.">National Open University of Nigeria, Lagos.</option>
      	      <option value="Niger Delta Unversity, Yenagoa">Niger Delta Unversity, Yenagoa</option>
      	      <option value="Nigerian Defence Academy,Kaduna">Nigerian Defence Academy,Kaduna</option>
      	      <option value="Nigerian-Turkish Nile University, Abuja">Nigerian-Turkish Nile University, Abuja</option>
      	      <option value="Nnamdi Azikiwe University, Awka">Nnamdi Azikiwe University, Awka</option>
      	      <option value="Northwest University, Kano">Northwest University, Kano</option>
      	      <option value="Novena University, Ogume">Novena University, Ogume</option>
      	      <option value="Obafemi Awolowo University,Ile-Ife">Obafemi Awolowo University,Ile-Ife</option>
      	      <option value="Obong University, Obong Ntak">Obong University, Obong Ntak</option>
      	      <option value="Oduduwa University, Ipetumodu - Osun  State">Oduduwa University, Ipetumodu - Osun  State</option>
      	      <option value="Olabisi Onabanjo University Ago-Iwoye">Olabisi Onabanjo University Ago-Iwoye</option>
      	      <option value="Ondo State University of Science &amp; Technology, Okitipupa">Ondo State University of Science &amp; Technology, Okitipupa</option>
      	      <option value="Osun State University, Oshogbo">Osun State University, Oshogbo</option>
      	      <option value="Pan-African University, Lagos">Pan-African University, Lagos</option>
      	      <option value="Paul University, Awka - Anambra State">Paul University, Awka - Anambra State</option>
      	      <option value="Plateau State University, Bokkos">Plateau State University, Bokkos</option>
      	      <option value="Police Academy Wudil">Police Academy Wudil</option>
      	      <option value="Redeemers University, Mowe">Redeemer\'s University, Mowe</option>
      	      <option value="Renaissance University,Enugu">Renaissance University,Enugu</option>
      	      <option value="Rhema University, Obeama-Asa - Rivers State">Rhema University, Obeama-Asa - Rivers State</option>
      	      <option value="Rivers State University of Science &amp; Technology">Rivers State University of Science &amp; Technology</option>
      	      <option value="Salem University,Lokoja">Salem University,Lokoja</option>
      	      <option value="Samuel Adegboyega University,Ogwa.">Samuel Adegboyega University,Ogwa.</option>
      	      <option value="Sokoto State University, Sokoto">Sokoto State University, Sokoto</option>
      	      <option value="Southwestern University, Oku Owa">Southwestern University, Oku Owa</option>
      	      <option value="Tai Solarin Univ. of Education, Ijebu-Ode">Tai Solarin Univ. of Education, Ijebu-Ode</option>
      	      <option value="Tansian University,Umunya">Tansian University,Umunya</option>
      	      <option value="Taraba State University, Jalingo">Taraba State University, Jalingo</option>
      	      <option value="Technical University,Ibadan">Technical University,Ibadan</option>
      	      <option value="Umaru Musa YarAdua University, Katsina">Umaru Musa Yar\'Adua University, Katsina</option>
      	      <option value="University of Abuja, Gwagwalada">University of Abuja, Gwagwalada</option>
      	      <option value="University of Agriculture, Abeokuta.">University of Agriculture, Abeokuta.</option>
      	      <option value="University of Agriculture, Makurdi.">University of Agriculture, Makurdi.</option>
      	      <option value="University of Benin">University of Benin</option>
      	      <option value="University of Calabar">University of Calabar</option>
      	      <option value="University of Ibadan">University of Ibadan</option>
      	      <option value="University of Ilorin">University of Ilorin</option>
      	      <option value="University of Jos">University of Jos</option>
      	      <option value="University of Lagos">University of Lagos</option>
      	      <option value="University of Maiduguri">University of Maiduguri</option>
      	      <option value="University of Mkar, Mkar">University of Mkar, Mkar</option>
      	      <option value="University of Nigeria, Nsukka">University of Nigeria, Nsukka</option>
      	      <option value="University of Port-Harcourt">University of Port-Harcourt</option>
      	      <option value="University of Uyo">University of Uyo</option>
      	      <option value="Usumanu Danfodiyo University">Usumanu Danfodiyo University</option>
      	      <option value="Veritas University">Veritas University</option>
      	      <option value="Wellspring University, Evbuobanosa - Edo State">Wellspring University, Evbuobanosa - Edo State</option>
      	      <option value="Wesley Univ. of Science &amp; Tech.,Ondo">Wesley Univ. of Science &amp; Tech.,Ondo</option>
      	      <option value="Western Delta University, Oghara">Western Delta University, Oghara</option>
      	      <option value="Wukari Jubilee University,">Wukari Jubilee University,</option>
      	      <option value="Wukari Jubilee University,Wukari">Wukari Jubilee University,Wukari</option>
      	      <option >++++++++++Select Polytechnic++++++++++</option>
      	      <option value="Akperan Orshi College of Agriculture"> Akperan Orshi College of Agriculture</option>
      	      <option value="Abubakar Tafari Ali Polytechnic">Abubakar Tafari Ali Polytechnic </option>
      	      <option value="Abdul Gusau Polytechnic"> Abdul Gusau Polytechnic</option>
      	      <option value="Auchi Polytechnic"> Auchi Polytechnic</option>
      	      <option value="Adamawa State Polytechnic">Adamawa State Polytechnic </option>
      	      <option value="Akwa Ibom State Polytechnic"> Akwa Ibom State Polytechnic</option>
      	      <option value="Akwa-Ibom College of Agriculture">Akwa-Ibom College of Agriculture </option>
      	      <option value="Allover Central Polytechnic"> Allover Central Polytechnic</option>
      	      <option value="Bayelsa State College of Arts and Science">Bayelsa State College of Arts and Science </option>
      	      <option value="Benue State Polytechnic"> Benue State Polytechnic</option>
      	      <option value="Borno College of Agriculture">Borno College of Agriculture </option>
      	      <option value="Delta State College of Agriculture"> Delta State College of Agriculture</option>
      	      <option value="Delta State Polytechnic:">Delta State Polytechnic: </option>
      	      <option value="Dorben Polytechnic">Dorben Polytechnic </option>
      	      <option value="Ekwenugo Okeke Polytechnic"> Ekwenugo Okeke Polytechnic</option>
      	      <option value="Federal Polytechnic, Mubi">Federal Polytechnic, Mubi </option>
      	      <option value="Federal Polytechnic, Oko">Federal Polytechnic, Oko </option>
      	      <option value="Federal Polytechnic, Bauchi">Federal Polytechnic, Bauchi </option>
      	      <option value="Federal Polytechnic, Nekede">Federal Polytechnic, Nekede </option>
      	      <option value="Federal Polytechnic, Idah">Federal Polytechnic, Idah </option>
      	      <option value="Federal Polytechnic, Bida"> Federal Polytechnic, Bida</option>
      	      <option value="Federal Polytechnic, Birnin-Kebbi">Federal Polytechnic, Birnin-Kebbi </option>
      	      <option value="Federal Polytechnic, Nassarawa">Federal Polytechnic, Nassarawa </option>
      	      <option value="Federal Polytechnic, Damaturu">Federal Polytechnic, Damaturu </option>
      	      <option value="Federal Polytechnic, Namoda">Federal Polytechnic, Namoda </option>
      	      <option value="Federal Polytechnic, Ado-Ekiti">Federal Polytechnic, Ado-Ekiti </option>
      	      <option value="Federal Polytechnic, Offa"> Federal Polytechnic, Offa</option>
      	      <option value="Federal Polytechnic, Ilaro">Federal Polytechnic, Ilaro </option>
      	      <option value="Federal Polytechnic, Ede">Federal Polytechnic, Ede </option>
      	      <option value="Gateway Polytechnic Saapade">Gateway Polytechnic Saapade</option>
      	      <option value="Grace Polytechnic">Grace Polytechnic </option>
      	      <option value="Hassan Usman Katsina Polytechnic">Hassan Usman Katsina Polytechnic </option>
      	      <option value="Hussaini Adamu Federal Polytechnic">Hussaini Adamu Federal Polytechnic </option>
      	      <option value="Hussani Adamu Polytechnic">Hussani Adamu Polytechnic </option>
      	      <option value="Ibrahim Babangida College of Agriculture">Ibrahim Babangida College of Agriculture </option>
      	      <option value="Imo State Polytechnic">Imo State Polytechnic </option>
      	      <option value="Imo State Technological Skills Acquisition Center">Imo State Technological Skills Acquisition Center </option>
      	      <option value="Institute of Management Technology, Enugu">Institute of Management Technology, Enugu </option>
      	      <option value="Kaduna Polytechnic">Kaduna Polytechnic </option>
      	      <option value="Kano State Polytechnic">Kano State Polytechnic </option>
      	      <option value="Kebbi State Polytechnic">Kebbi State Polytechnic</option>
      	      <option value="Kogi State Polytechnic">Kogi State Polytechnic </option>
      	      <option value="Kwara State Polytechnic"> Kwara State Polytechnic</option>
      	      <option value="Lagos City Polytechnic">Lagos City Polytechnic </option>
      	      <option value="Lagos State Polytechnic">Lagos State Polytechnic </option>
      	      >
      	      <option value="Maurid Institute of Management &amp; Technology, Nasarawa"> Maurid Institute of Management &amp; Technology, Nasarawa</option>
      	      <option value="Mai Idris Alooma Polytechnic">Mai Idris Alooma Polytechnic </option>
      	      <option value="Marvic Polytechnic">Marvic Polytechnic </option>
      	      <option value="Mohammed Abdullahi Wase Polytechnic">Mohammed Abdullahi Wase Polytechnic </option>
      	      <option value="Moshood Abiola Polytechnic">Moshood Abiola Polytechnic </option>
      	      <option value="Nasarawa State Polytechnic">Nasarawa State Polytechnic </option>
      	      <option value="Niger State Polytechnic"> Niger State Polytechnic</option>
      	      <option value="Nuhu Bamalli Polytechnic"> Nuhu Bamalli Polytechnic</option>
      	      <option value="Osun State College of Technology">Osun State College of Technology </option>
      	      <option value="Osun State Polytechnic">Osun State Polytechnic </option>
      	      <option value="Our Saviour Institute of Science and Technology">Our Saviour Institute of Science and Technology </option>
      	      <option value="Plateau State Polytechnic">Plateau State Polytechnic </option>
      	      <option value="Ramat Polytechnic">Ramat Polytechnic </option>
      	      <option value="Rufus Giwa Polytechnic">Rufus Giwa Polytechnic </option>
      	      <option value="Rivers State College of Arts and Science">Rivers State College of Arts and Science </option>
      	      <option value="Rivers State Polytechnic">Rivers State Polytechnic </option>
      	      <option value="Shaka Polytechnic">Shaka Polytechnic </option>
      	      <option value="The Polytechnic, Calabar">The Polytechnic, Calabar </option>
      	      <option value="The Polytechnic, Ibadan">The Polytechnic, Ibadan </option>
      	      <option value="The Polytechnic Ile-Ife"> The Polytechnic Ile-Ife</option>
      	      <option value="Wolex Polytechnic">Wolex Polytechnic </option>
      	      <option value="Yaba College of Technology">Yaba College of Technology </option>

   	        ';
}


function list_course()
{

  echo '    <option value="Accounting">Accounting</option>

   <option value="Actuarial Science">Actuarial Science</option>

   <option value="Adult and Community Education">Adult and Community Education</option>

   <option value="Adult Education">Adult Education</option>

   <option value="Anaesthesia">Anaesthesia</option>

   <option value="Anatomy">Anatomy</option>

   <option value="Applied Entomology &amp; Pest Management">Applied Entomology &amp; Pest Management</option>

   <option value="Applied Geophysics">Applied Geophysics</option>

   <option value="Applied Physics">Applied Physics</option>

   <option value="Architecture">Architecture</option>

   <option value="Arts &amp; Social Science Education">Arts &amp; Social Science Education</option>

   <option value="Biochemistry">Biochemistry</option>

   <option value="Biology Education">Biology Education</option>

   <option value="Botany">Botany</option>

   <option value="Building">Building</option>

   <option value="Business Administration">Business Administration</option>

   <option value="Business Education">Business Education</option>

   <option value="Cell Biology and Genetics">Cell Biology and Genetics</option>

   <option value="Chemical Engineering">Chemical Engineering</option>

   <option value="Chemistry">Chemistry</option>

   <option value="Civil Engineering">Civil Engineering</option>

   <option value="Clinical Pathology">Clinical Pathology</option>

   <option value="Computer Engineering">Computer Engineering</option>

   <option value="Computer Science">Computer Science</option>

   <option value="Construction Management">Construction Management</option>

   <option value="Creative Arts">Creative Arts</option>

   <option value="Dentistry / Dental Surgery">Dentistry / Dental Surgery</option>

   <option value="Economics">Economics</option>

   <option value="Economics Education">Economics Education</option>

   <option value="Education and Business Studies">Education and Business Studies</option>

   <option value="Education and Chemistry">Education and Chemistry</option>

   <option value="Education and Christian Religious Studies">Education and Christian Religious Studies</option>

   <option value="Education and English Language">Education and English Language</option>

   <option value="Education and French">Education and French</option>

   <option value="Education and Geography">Education and Geography</option>

   <option value="Education and History">Education and History</option>

   <option value="Education and Igbo">Education and Igbo</option>

   <option value="Education and Integrated Science">Education and Integrated Science</option>

   <option value="Education and Islamic Studies">Education and Islamic Studies</option>

   <option value="Education and Mathematics">Education and Mathematics</option>

   <option value="Education and Physics">Education and Physics</option>

   <option value="Education and Religious Studies">Education and Religious Studies</option>

   <option value="Education and Science">Education and Science</option>

   <option value="Education and Yoruba">Education and Yoruba</option>

   <option value="Educational Administration">Educational Administration</option>

   <option value="Educational Administration and Planning">Educational Administration and Planning</option>

   <option value="Educational Foundations">Educational Foundations</option>

   <option value="Electrical/Electronics Engineering">Electrical/Electronics Engineering</option>

   <option value="English Language">English Language</option>

   <option value="English Literature">English Literature</option>

   <option value="Environmental Design">Environmental Design</option>

   <option value="Environmental Management">Environmental Management</option>

   <option value="Environmental Toxicology and Pollution Management">Environmental Toxicology and Pollution Management</option>

   <option value="Estate Management">Estate Management</option>

   <option value="Finance">Finance</option>

   <option value="Fishery Production">Fishery Production</option>

   <option value="Food Science">Food Science</option>

   <option value="Food Technology">Food Technology</option>

   <option value="French">French</option>

   <option value="Geographic Information System">Geographic Information System</option>

   <option value="Geography">Geography</option>

   <option value="Guidiance and Counselling">Guidiance and Counselling</option>

   <option value="Haematology and Blood Transfusion">Haematology and Blood Transfusion</option>

   <option value="Health Education">Health Education</option>

   <option value="History">History</option>

   <option value="History and Strategic Studies">History and Strategic Studies</option>

   <option value="Home Economics Education">Home Economics Education</option>

   <option value="Human Kinetics">Human Kinetics</option>

   <option value="Human Kinetics and Health Education">Human Kinetics and Health Education</option>

   <option value="Igbo">Igbo</option>

   <option value="Igbo/Linguistics">Igbo/Linguistics</option>

   <option value="Industrial Relation/Personal Management">Industrial Relation/Personal Management</option>

   <option value="Industrial Relations &amp; Personnel Management">Industrial Relations &amp; Personnel Management</option>

   <option value="Insurance">Insurance</option>

   <option value="Languages and Linguistics">Languages and Linguistics</option>

   <option value="Law">Law</option>

   <option value="Linguistics">Linguistics</option>

   <option value="Linguistics and Urhobo">Linguistics and Urhobo</option>

   <option value="Linguistics/Yoruba">Linguistics/Yoruba</option>

   <option value="Management">Management</option>

   <option value="Marine Biology &amp; Fisheries">Marine Biology &amp; Fisheries</option>

   <option value="Marketing">Marketing</option>

   <option value="Mass Communication">Mass Communication</option>

   <option value="Mathematics">Mathematics</option>

   <option value="Mechanical Engineering">Mechanical Engineering</option>

   <option value="Medical Microbiology and Parasitology">Medical Microbiology and Parasitology</option>

   <option value="Medical Physics">Medical Physics</option>

   <option value="Medicine and Surgery">Medicine and Surgery</option>

   <option value="Metallurgical and Materials Engineering">Metallurgical and Materials Engineering</option>

   <option value="Microbiology">Microbiology</option>

   <option value="Music">Music</option>

   <option value="Natural Resources Conservation">Natural Resources Conservation</option>

   <option value="Office Management & Technology">Office Management & Technology</option>

   <option value="Operations Research">Operations Research</option>

   <option value="Parasitology &amp; Bioinformatics">Parasitology &amp; Bioinformatics</option>

   <option value="Petroleum and Gas Engineering">Petroleum and Gas Engineering</option>

   <option value="Pharmaceutics and Pharmaceutical Technology">Pharmaceutics and Pharmaceutical Technology</option>

   <option value="Pharmacognosy">Pharmacognosy</option>

   <option value="Pharmacology">Pharmacology</option>

   <option value="Pharmacy">Pharmacy</option>

   <option value="Philosophy">Philosophy</option>

   <option value="Physics">Physics</option>

   <option value="Physiology">Physiology</option>

   <option value="Physiotherapy">Physiotherapy</option>

   <option value="Political Science">Political Science</option>

   <option value="Psychology">Psychology</option>

   <option value="Public Administration">Public Administration</option>

   <option value="Public Health">Public Health</option>

   <option value="Radiography">Radiography</option>

   <option value="Russian">Russian</option>

   <option value="Secretarial Studies">Secretarial Studies</option>

   <option value="Social Work">Social Work</option>

   <option value="Sociology">Sociology</option>

   <option value="Statistics">Statistics</option>

   <option value="Surveying and Geoinformatics">Surveying and Geoinformatics</option>

   <option value="System Engineering">System Engineering</option>

   <option value="Technology Education">Technology Education</option>

   <option value="Urban and Regional Planning">Urban and Regional Planning</option>

   <option value="Yoruba">Yoruba</option>

   <option value="Zoology">Zoology</option>

  ';
}

function list_relationship()
{
  echo '<option value="Husband">Husband</option>
        <option value="Wife">Wife</option>
        <option value="Father">Father</option>
        <option value="Mother">Mother</option>
        <option value="Daughter">Daughter</option>
        <option value="Son">Son</option>
        <option value="Brother">Brother</option>
        <option value="Sister">Sister</option>
        <option value="Aunt">Aunt</option>
        <option value="Uncle">Uncle</option>
        <option value="Niece">Niece</option>
        <option value="Nephew">Nephew</option>
        <option value="Cousin(female)">Cousin(female)</option>
        <option value="Cousin(male)">Cousin(male)</option>
        <option value="Grandmother">Grandmother</option>
        <option value="Grandfather">Grandfather</option>
        <option value="Stepsister">Stepsister</option>
        <option value="Stepbrother">Stepbrother</option>
        <option value="Stepmother">Stepmother</option>
        <option value="Stepfather">Stepfather</option>';
}

function list_industry()

{
  return list_val('category', 'industry', 'industry');
}

function list_experience()

{

  echo '

	<option value="0">None</option>

	<option value="0-1yr">0-1yr</option>

	<option value="1-2yrs">1-2yrs</option>

	<option value="2-3yrs">2-3yrs</option>

	<option value="3-4yrs">3-4yrs</option>

	<option value="4-5yrs">4-5yrs</option>

	<option value="5 yrs and above">5 yrs and above</option>';
}

function list_cert()
{
  echo '<option value="ICAN - Accounting">ICAN - Accounting</option>
   <option value="ACCA - Accounting">ACCA - Accounting</option>
   <option value="ANAN - Accounting">ANAN - Accounting</option>
   <option value="CISA - Audit">CISA - Audit</option>
   <option value="CIA - Audit">CIA - Audit</option>
   <option value="CFA - Finance">CFA - Finance</option>
   <option value="CRE - Risk">CRE - Risk</option>
   <option value="CITN -Tax">CITN -Tax</option>
   <option value="CIS">CIS</option>
   <option value="ACIPM - HR">ACIPM - HR</option>
   <option value="ACIPD -HR">ACIPD -HR</option>
   <option value="SPHRi - HR">SPHRi - HR</option>
   <option value="GPHR - HR">GPHR - HR</option>
   <option value="PHRi - HR">PHRi - HR</option>
   <option value="PMP - Project Mgt">PMP - Project Mgt</option>
   <option value="Prince II - Project Mgt">Prince II - Project Mgt
   </option>
   <option value="NIM - Management">NIM - Management</option>
   <option value="COREN - Engineers">COREN - Engineers</option>
   <option value="CIPS - Supply Chain">CIPS - Supply Chain</option>
   <option value="NEBOSH: IOSH - EHSSQ">NEBOSH: IOSH - EHSSQ
   </option>
   <option value="NEBOSH: IOGC - EHSSQ">NEBOSH: IOGC - EHSSQ
   </option>
   <option value="NEBOSH: IGC - EHSSQ">NEBOSH: IGC - EHSSQ</option>
   <option value="ITIL - IT">ITIL - IT</option>
   <option value="CISCO - IT">CISSP - IT</option>
   <option value="VMware - IT">JAVA - IT</option>';
}


function list_comment_options()
{
  echo '<option>Not qualified</option>
   <option>Would do better in another role</option>
   <option>Not presentable</option>';
}

function get_stage_subject($stage)
{
  if ($stage == 'First Level Interview' || $stage == 'Second Level Interview') {
    return $stage;
  } elseif ($stage == 'Assessment') {

    return 'You have been scheduled for a Test';
  } else {
    return 'Update on your Job Application';
  }
}

function request_report($query, $col, $col_val)
{
  global $db;
  $query_run = "$query and $col = '$col_val'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
}

function request_client()
{
  global $db;
  $query_run = "select distinct client_id from job_post";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['client_id'] . '">' . get_client_name($row['client_id']) . '</option>';
  }
}


function export_to_recruiter($id)
{
  //if parameter is an array use it else make it an array
  if (is_array($id)) {
    $jobs_applied_id = $id;
  } else {
    $jobs_applied_id = explode(',', $id);
  }


  global $db;

  // Filter the excel data
  function filterData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // Excel file name for download
  $fileName = get_fullname($_SESSION['Klin_admin_user']) . "_Applicants" . ' ' . date('Y-m-d') . ' ' . ".xls";

  $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE', 'GENDER', 'AGE', 'STATE', 'JOB TITLE', 'QUALIFICATION', 'CLASS DEGREE', 'DATE APPLIED');

  // Display column names as first row
  $excelData = implode("\t", array_values($fields)) . "\n";

  for ($i = 0; $i < count($jobs_applied_id); $i++) {
    $id_list[] = " or id = '" . $jobs_applied_id[$i] . "'";
  }
  $clause = implode('', $id_list);
  $query = $db->query("SELECT * FROM jobs_applied where id = '" . $jobs_applied_id[0] . "' " . $clause);

  

  if ($query->num_rows > 0) {
    // Output each row of the data
    while ($row = $query->fetch_assoc()) {
      // $status = ($row['status'] == 1)?'Active':'Inactive';
      $lineData = array($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['gender'], $row['age'], $row['state'], $row['job_title'], $row['qualification'], $row['class_degree'], $row['date_applied']);
      array_walk($lineData, 'filterData');
      $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
  } else {
    $excelData .= 'No records found...' . "\n";
  }
  
  // Headers for download

  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=\"$fileName\"");
  //Save file
  $exported_file = 'uploads/export/' . $fileName;
  $myfile = fopen($exported_file, "w");
  fwrite($myfile, $excelData);
  fclose($myfile);  
  //Send mail to admin user
  $sub = 'Candidates Moved for Second Level Interview';
  $message = 'Attached is the list of candidates moved for second level interview';
  send_email(Klin_admin_email(), get_fullname(Klin_admin_email()), 'Outsoource Hr', $sub, $message, $exported_file);
}

function move_file_to_folder($candidate_id, $firstname, $lastname, $job_title, $folder)
{
  global $db;
  $query = "select * from credentials where candidate_id='$candidate_id' and document = 'CV'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);

  $file = 'document/' . $row['filepath'];

  if (file_exists($file)) {
    $newfile_location = $folder . '/' . strtoupper($firstname . ' ' . $lastname . ' ' . $job_title) . '_' . $row['filepath'];

    //copy credentials to new location
    copy($file, $newfile_location);

    return $newfile_location;
  }
}


function createZipArchive($files = array(), $destination = '', $overwrite = false)
{

  if (file_exists($destination) && !$overwrite) {
    return false;
  }

  $validFiles = array();
  if (is_array($files)) {
    foreach ($files as $file) {
      if (file_exists($file)) {
        $validFiles[] = $file;
      }
    }
  }

  if (count($validFiles)) {
    $zip = new ZipArchive();
    if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) == true) {
      foreach ($validFiles as $file) {
        $zip->addFile($file, $file);
      }
      $zip->close();
      return file_exists($destination);
    } else {
      return false;
    }
  } else {
    return false;
  }
}


//  function rq_company_name()

//  {

//    return 'U-Connect-Ng Limited';	

//  }


function rq_company_phone()

{

  return '083888388883';
}

function rq_company_email()

{

  return 'solution@KlinHR.com.ng';
}

function client_code()
{
  global $db;
  $query = "select * from clients";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['client_code'] . '">' . ($row['client_name']) . '</option>';
  }
}

function stafflogin_conflict($email, $client)
{
  global $db;

  $user_check = "select * from emp_self_login where email = '$email' and client_code = '$client'";

  $user_result =  mysqli_query($db, $user_check);
  $user_num = mysqli_num_rows($user_result);
  if ($user_num > 0) {
    return 'no';
  } else {
    return 'yes';
  }
}

function state()
{
  global $db;
  $query = "select distinct state from local_govt order by state";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['state'] . '">' . ($row['state']) . '</option>';
  }
}

function salary_band()
{
  global $db;
  $query = "select * from salary_band";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['band'] . ',' . $row['client'] . '">' . ($row['band']) . ' (' . $row['client'] . ')</option>';
  }
}
function staff()
{
  global $db;
  $query = "select * from employees where emp_status = 'active'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    $name = $row['firstname'] . ' ' . $row['lastname'];
    echo '<option value="' . $name . '">' . $name . '</option>';
  }
}


function rq_get_staff_company($user)
{
  global $db;
  $query = "select * from emp_self_login where user = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['client_code'];
}

function HrName($user)
{
  global $db;
  $query = "select * from login where client like '%" . ($user) . "%' ";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['firstname'] . ' ' . $row['lastname'];
}

function HrEmail($user)
{
  global $db;
  $query = "select * from login where client like '%" . ($user) . "%' ";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);

  return $row['email'];
}

function rq_get_hr_email($client_code)
{

  global $db;

  //  $client_code= $_SESSION['client_code'];

  $query_cl = "select * from clients where client_code LIKE '$client_code'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $client_email = $row_cl['email'];

  return $client_email;
}

function rq_get_no_of_days($outstanding_days)
{

  global $db;
  ob_start();
  session_start();
  $staff_id = $_SESSION['staff_id'];

  $query_cl = "select * from emp_leave_planner where staff_id = '$staff_id'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $outstanding_days = $row_cl['outstanding_days'];

  return $outstanding_days;
}


function rq_get_client_name($client_code)
{


  global $db;
  ob_start();
  session_start();
  //  $client_code= $_SESSION['client_code'];

  $query_cl = "select * from clients where client_code LIKE '$client_code'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $client_name = $row_cl['contact_person'];

  return $client_name;
}

function rq_get_name($staff_id)
{

  global $db;

  $query = "select * from emp_self_login where staff_id= '$staff_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $name = $row['names'];

  return ucwords($name);
}

// functions from uconnect
function status($status)
{
  if ($status == 'active') {

    return '<i class="fa fa-check-circle" style="font-size:30px;color:green;"></i>';
  } else {

    return '<i class="fa fa-pause" style="font-size:30px;color:red;"></i>';
  }
}
function fa_status($status)
{
  if ($status == 'done') {

    return '<i class="bi-check-circle" style="font-size:30px;color:green;"></i>';
  } elseif ($status == 'denied') {
    return '<i class="" style="font-size:15px;color:red;">Leave Denied</i>';
  } else {

    return '<i class="bi-pause" style="font-size:30px;color:red;"></i>';
  }
}

function search_leave_priviledge($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' and leave_type != 'Leave Resumption' or access_type like '%", $priviledge);
}
function user_privilege($privilege)
{
  $privilege = explode(',', $_SESSION['privilege']);
  return $clause = implode("%' or privilege like '%", $privilege);
}
function download_privilege($priviledge)
{
  $priviledge = explode(',', $_SESSION['client_code']);
  return $clause = implode("%' or access_type like '%", $priviledge);
}
function get_priviledge($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or access_type like '%", $priviledge);
}

function get_priviledge_2($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or company_code like '%", $priviledge);
}
function get_priviledge_3($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or client_code like '%", $priviledge);
}
function get_priviledge_4($client)
{
  $priviledge = explode(',', $client);
  return $clause = implode("%' or client_name like '%", $priviledge);
}
function get_priviledge_5($client_code)
{
  // $priviledge = explode(',',$client_code);
  $priviledge = "SELECT GROUP_CONCAT(clients) ";
  return $priviledge;
}

function staff_id($candidate_id, $id_format)
{
  // Ensure candidate_id is a string
  $candidate_id = strval($candidate_id);

  // Pad candidate_id with leading zeros to make it at least 3 characters long
  $candidate_id = str_pad($candidate_id, 3, '0', STR_PAD_LEFT);

  // Get the current year in two-digit format
  $year = date('y');

  // Replace {YY} with the current year and {ID} with the padded candidate_id in the id_format
  $return_val = str_replace(['{YY}', '{ID}'], [$year, $candidate_id], $id_format);

  return $return_val;
}


function get_staff_id($candidate_id)
{
  global $db;
  $query = "select * from emp_staff_details where id='$candidate_id'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['staff_id'];
}

function staff_id_email($email)
{
  global $db;
  $query = "select * from emp_staff_details where email_address='$email' order by id desc";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['staff_id'];
}


function push_for_nextstage($stage, $apply_id)
{
  global $db;

  $firstname = get_val('jobs_applied', 'id', $apply_id, 'firstname');
  $lastname =  get_val('jobs_applied', 'id', $apply_id, 'lastname');
  $email =  get_val('jobs_applied', 'id', $apply_id, 'email');
  $phone =  get_val('jobs_applied', 'id', $apply_id, 'phone');
  $candidate_id =  get_val('jobs_applied', 'id', $apply_id, 'candidate_id');
  $job_id =  get_val('jobs_applied', 'id', $apply_id, 'job_id');
  $job_title =  get_val('jobs_applied', 'id', $apply_id, 'job_title');

  $test_code = test_code($email, $candidate_id);

  $body_msg = get_val('message_template', 'template_name', $stage, 'message');
  $sms = get_val('message_template', 'template_name', $stage, 'sms_content');

  $interview_date = date('l, jS M, Y', strtotime(getNextInterview()));
  $interview_time = '9:00AM';


  $message1 = str_replace('{firstname}', $firstname, $body_msg);
  $message2 = str_replace('{lastname}', $lastname, $message1);
  $message3 = str_replace('{email}', $email, $message2);
  $message4 = str_replace('{test_url}', assessment_link(), $message3);
  $message5 = str_replace('{test_code}', $test_code, $message4);
  $message6 = str_replace('{interview_date}', $interview_date, $message5);
  $message7 = str_replace('{interview_time}', $interview_time, $message6);
  $message8 = str_replace('{job title}', $job_title, $message7);

  $sms1 = str_replace('{firstname}', $firstname, $sms);
  $sms2 = str_replace('{lastname}', $lastname, $sms1);
  $sms3 = str_replace('{email}', $email, $sms2);
  $sms4 = str_replace('{test_url}', assessment_link(), $sms3);
  $sms5 = str_replace('{test_code}', $test_code, $sms4);

  $mail_content = $message8;
  $sms_content = $sms5;

  if ($stage == 'Assessment' && check_assessment() == 'confirm') {
    $sql = "insert into participant set candidate_id = '$candidate_id',job_applied_id = '" . $apply_id . "',firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', job_id = '$job_id', job_title = '$job_title', exam_code = '$test_code', expire_date = '" . test_expiration() . "'";
    $result_sql = mysqli_query($db, $sql);
  }

  //update application to assessment
  mysqli_query($db, "update jobs_applied set status = '$stage' where id = '$apply_id'");


  $final_message = str_replace('{firstname}', $firstname, $mail_content);

  $email = get_val('jobs_applied', 'id', $apply_id, 'email');
  $phone = get_val('jobs_applied', 'id', $apply_id, 'phone');

  mail_candidate($email, get_stage_subject($stage), $final_message);

  //  send_sms($phone, $sms_content);

}


function fixed_score()

{
  global $db;
  $query = "select sum(weight) from fixed_q";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  $total = 100 - $row[0];



  return $total;
}
function table_row($tab)

{
  global $db;
  if ($tab == 'custom_q') {
    $query = "select * from $tab where role = '" . $_SESSION['role'] . "' and user = '" . $_SESSION['Klin_admin_user'] . "'";
    // $query = "select * from $tab where role = '$role' and user = '".$_SESSION['Klin_admin_user']."'";
  } else {
    $query = "select * from $tab";
  }

  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  return $num_result;
}


function search_priviledge($priviledge)

{
  $priviledge = explode(',', $_SESSION['privilege_user']);

  return $clause = implode("%' or access_type like '%", $priviledge);
}
function total_schedule($staff_id)

{
  global $db;
  $query = "select * from emp_leave_planner where staff_id='$staff_id' and current_year = '" . year() . "'";

  $result = mysqli_query($db, $query);


  $num_result = mysqli_num_rows($result);

  $row = mysqli_fetch_array($result);

  return $row['scheduled_days'];
}

function setup_staff($staff_id)
{
  
  //get staff details
  global $db;
  $query = "select * from emp_staff_details where staff_id='$staff_id'";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);

  //insert into emp_staff_details
  $names = $row['firstname'].' '.$row['surname'];
  $email = $row['email_address'];
  $mobile_phone_number = $row['mobile_phone_number'];
  $company_code = $row['company_code'];
  $leave_days = $row['leave_days'];

  //check of details is in the staff_login table and remove it to insert new records
  $query = "select * from emp_staff_details where email_address='$email'";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);

  if($num_result > 0)
  {
      $query2 = "delete from emp_self_login where email='$email' or user = '$staff_id'";
      $result2 = mysqli_query($db, $query2);
  }
   $query3 = "insert into emp_self_login set user = '$staff_id', pass = '$staff_id', staff_id = '$staff_id', names = '$names', email='$email', phone = '$mobile_phone_number', client_code = '$company_code', user_type = 'user', privilege = '$company_code'";

    $result3 = mysqli_query($db, $query3);

    //insert records into the leave planner table

    $query2 = "delete from emp_leave_planner where staff_id='$staff_id'";
    $result2 = mysqli_query($db, $query2);

   $query4 = "insert into emp_leave_planner set staff_id = '$staff_id', total_days = '$leave_days', scheduled_days = '0', last_year_days = '0', outstanding_days = '$leave_days', current_year = '".date('Y')."'";

    $result4 = mysqli_query($db, $query4);


  
}

function insert_leave($staff_id, $leave)

{

  global $db;
  $query = "insert into emp_leave_planner values ('', '" . $staff_id . "','" . $leave . "', '', '" . $leave . "', '" . year() . "')";

  mysqli_query($db, $query);


  //Remove column name

  // mysqli_query($db,"delete from self_leave_planner where staff_id = 'staff_id'");

}

function month_year($date)
{
  $date = str_replace('/', '-', $date);

  return date('F, Y', strtotime($date));
}

function get_leave_days($staff_id)

{
  global $db;

  $query = "select * from emp_leave_planner where staff_id='$staff_id' and current_year = '" . year() . "'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['total_days'];
}


function update_status($tab, $id, $status)

{
  global $db;
  $query = "update $tab set status = '$status' where id= '" . $id . "'";
  mysqli_query($db, $query);
}

function get_access_type($user)

{
  global $db;
  $query = "select * from emp_self_login where user='$user'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['priviledge'];
}

function delete_leave_details($staff_id, $start_date, $end_date)

{
  global $db;
  $diff = date_difference(strtotime($start_date), strtotime($end_date));



  //update schedule table

  $query2 = "update `emp_leave_planner` set scheduled_days= scheduled_days-$diff, outstanding_days=outstanding_days+$diff where staff_id='$staff_id'";

  mysqli_query($db, $query2);
}
function date_difference($start, $end)
{

  $datediff = $end - $start;
  return floor($datediff / (60 * 60 * 24));
}


function get_emails($staff_id)

{
  global $db;
  $query = "select * from emp_self_login where staff_id='$staff_id'";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);

  $row = mysqli_fetch_array($result);
  return $row['email'];
}

function mail_approval($approval_type, $staff_id, $names, $leave_type, $start_date, $end_date, $purpose, $manager_email, $reason, $user_priviledge)

{



  if (!$reason) {

    $reason = 'Not stated';
  }



  //get client details and assign email variables/

  $to = get_emails($staff_id);

  $subject = $names . ' <br>Leave application has been ' . $approval_type;

  $mailcontent  = '<br>Hello ' . $names . ',

				<br><br>Your Leave application has been <strong>' . $approval_type . '</strong>. See details below:<br><br>

				Start Date: ' . long_date($start_date) . "<br>"

    . 'End Date: ' . long_date($end_date) . "<br>"

    . 'Type of leave: ' . $leave_type . "<br>"

    . 'Purpose: ' . $purpose . "<br><br>"

    . 'Reason: ' . $reason . "<br><br>"

    . 'For any information or clarification, please send us an email: ' . hr_email($user_priviledge);

  send_email($to, $names, organisation(), $subject, $mailcontent);


  $mail_supervisor  = '<br><br>' . $names . ' leave has been <strong>' . $approval_type . '</strong>.<br> See details below:<br><br>

				Start Date: ' . long_date($start_date) . "<br>"

    . 'End Date: ' . long_date($end_date) . "<br>"

    . 'Type of leave: ' . $leave_type . "<br>"

    . 'Purpose: ' . $purpose . "<br><br>"

    . 'Reason: ' . $reason . "<br><br>"

    . 'For any information or clarification, please send us an email: ' . hr_email($user_priviledge);

  send_email($manager_email, 'Supervisor/Manager', organisation(), 'Leave Approval for ' . $names, $mail_supervisor);
}

function hr_email($user_type)

{
  global $db;
  $query = "select * from emp_self_login where user_type='staff' and priviledge like '%" . $user_type . "%'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['email'];
}

function get_names($staff_id)

{

  global $db;
  $query = "select * from emp_self_login where user='$staff_id'";

  $result = mysqli_query($db, $query);



  $row = mysqli_fetch_array($result);

  return $row['names'];
}

function smtp_detail($col)
{
  global $db;
  $select = mysqli_query($db, "SELECT * FROM smtp");
  $row = mysqli_fetch_array($select);
  return $row[$col];
}
function client_detail($col)
{
  global $db;
  $select = mysqli_query($db, "SELECT * FROM client_setting");
  $row = mysqli_fetch_array($select);
  return $row[$col];
}
function client_setting($col, $code)
{
  global $db;
  $select = mysqli_query($db, "SELECT * FROM clients WHERE client_code = '$code'");
  $row = mysqli_fetch_array($select);
  return $row[$col];
}
function clockin($col, $code)
{
  global $db;  
  $select = mysqli_query($db, "SELECT * FROM clockin_setting WHERE client_id = '$code'");
  $row = mysqli_fetch_array($select);
  return $row[$col];
}
function sms_detail($col)
{
  global $db;
  $select = mysqli_query($db, "SELECT * FROM sms_setting");
  $row = mysqli_fetch_array($select);
  return $row[$col];
}
function send_sms($to, $message)
{
  return null;
  if (sms_detail('sms_approval') == 'yes') {
    if ($_SESSION['testing_mode'] == 'yes') {
      $to = test_phone();
    }
    $msg = str_replace(' ', '+', $message);

    $url = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=" . sms_detail('sms_api') . "&from=" . org() . "&to=$to&body=$msg&dnd=2";

    // $url = "https://api.ebulksms.com/sendsms?username=lu@aledoy.com&apikey=".sms_detail('sms_api')."&sender=" . org() . "& messagetext=$msg&flash=0&recipients=$to";

    $f = @fopen($url, "r");
    $answer = fgets($f, 255);
  }
}
//https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=cKyxpSjGlJuRgpwRX4e7DOJwlReKyEuWfPo7F8zgKuABbfNllsZZ0Mqp8Oau&from=".org()."&to=07083051726,08023443581&body=testing sms&dnd=2

function send_job_approval($to, $job_post, $fromName, $subject, $message)
{



  // Mail Template
  $mailcontent  = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>

         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">

			<div>
			<div style="margin-bottom:15px;" id="username">


				<p>Hello Admin,</p>
				<p>' . $job_post . ' posted a new job.</p>
			</div>
			</div>

			<div style="font-size:16px;"> <p></p>' . $message . '

			</div>
			<br>
		   </div>
       	   </div><!-- White area ends here -->
    <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    	<div style="text-align:center; font-size:36px;"></div>
    </div>

    <div style="clear:both;"></div>

    <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>';

  // More headers
  //    $headers = "MIME-Version: 1.0" . "\r\n";
  //    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  //    // More headers
  //    $headers .= "From: $fromName <".sender_email().">";
  //mail($to, $subject, $mailcontent, $headers);



  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Port = 465;
  $mail->SMTPAuth = true;
  //sendgrid
  $mail->Username = 'domains@ecardnaija.com';
  $mail->Password = 'Aledoy@2024!';  //yahoo app password for noreply email 
  $mail->Host = 'mail.ecardnaija.com';
  $mail->SMTPSecure = 'ssl';
  $mail->From = sender_email();
  $mail->FromName = $fromName;

  if ($_SESSION['testing_mode'] == 'yes') {
    $mail->AddAddress(test_email());
  } else {
    $mail->AddAddress($to);
  }

  //  $mail->MsgHTML($sbody);
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->Body    = $mailcontent;
  $mail->Subject = $subject;
  $mail->IsHTML(true);
  $mail->Send();

  return $mailcontent;
}


///
function send_email($to, $name, $fromName, $subject, $message, $attach = 'nofile')
{

  // Mail Template
  $mailcontent = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>
         
         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">
			
			<div>
			<div style="margin-bottom:15px;" id="username">
            <input type="image" src="' . host() . '/uploads/JOB/' . client_detail('client_logo') . '" style="width:150px;" />
            
				<p>Dear ' . ucwords($name) . ',</p>

			</div>
			</div>
			
			<div style="font-size:16px;"> <p></p>' . $message . '
			  <p>Best Regards,<br>' . client_detail('client_name') . '<br><br>

			</p>
			</div>
			<br>
		   </div>
       	   </div><!-- White area ends here -->
    <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    	<div style="text-align:center; font-size:36px;"></div>
    </div>

    <div style="clear:both;"></div>
    
    <div id="copyright" style="font-size:13px; margin-top:5px;">Copyright &copy; - ' . date('Y') . '. ' . organisation() . '</div>
    <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>';

  // More headers
  //    $headers = "MIME-Version: 1.0" . "\r\n";
  //    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  //    // More headers
  //    $headers .= "From: $fromName <".sender_email().">";
  //mail($to, $subject, $mailcontent, $headers);



  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Port = smtp_detail('port');
  $mail->SMTPAuth = true;
  //sendgrid
  $mail->Username = smtp_detail('username');
  $mail->Password = smtp_detail('password');  //yahoo app password for noreply email 
  $mail->Host = smtp_detail('host');
  $mail->SMTPSecure = smtp_detail('secure');
  $mail->From = sender_email();
  // $mail->From = sender_email();
  $mail->FromName = $fromName;

  if ($_SESSION['testing_mode'] == 'yes') {
    $mail->AddAddress(test_email());
  } else {
    $mail->AddAddress($to);
  }

  if ($attach != 'nofile') {
    $mail->addAttachment($attach);
  }

  //  $mail->MsgHTML($body);
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->Body = $mailcontent;
  $mail->Subject = $subject;
  $mail->IsHTML(true);
  // if (!$mail->send()) {
  //   // Enable debugging before calling send() again:
  //   $mail->SMTPDebug = 2; // Set debugging level to 2 for detailed output
  //   $mail->send(); // Attempt to send again for debugging information
  //   echo 'Mailer Error: ' . $mail->ErrorInfo;
  //   exit;
  // }
  $mail->send();
  return $mailcontent;
}


function mail_candidate($to, $subject, $message)
{


  // Mail Template
  $mailcontent  = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>

         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">

			<div>
      <div style="margin-bottom:15px;" id="username">
      <input type="image" src="' . host() . '/uploads/JOB/' . client_detail('client_logo') . '" style="width:150px;" />
      </div>

			</div>

			<div style="font-size:16px;"> <p></p>' . $message . '

			</div>
			<br>
		   </div>
       	   </div><!-- White area ends here -->
    <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    	<div style="text-align:center; font-size:36px;"></div>
    </div>

    <div style="clear:both;"></div>


    <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>';

  // //    // More headers
  // //    $headers = "MIME-Version: 1.0" . "\r\n";
  // //    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  // //    // More headers
  // //    $headers .= "From: ".organisation()." <".sender_email().">";
  // //    //mail($to, $subject, $mailcontent, $headers);



  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Port = smtp_detail('port');
  $mail->SMTPAuth = true;
  //sendgrid
  $mail->Username = smtp_detail('username');
  $mail->Password = smtp_detail('password');  //yahoo app password for noreply email 
  $mail->Host = smtp_detail('host');
  $mail->SMTPSecure = smtp_detail('secure');
  $mail->From = sender_email();
  $mail->FromName = sender_name();

  if ($_SESSION['testing_mode'] == 'yes') {
    $mail->AddAddress(test_email());
  } else {
    $mail->AddAddress($to);
  }

  //  $mail->MsgHTML($body);
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->Body    = $mailcontent;
  $mail->Subject = $subject;
  $mail->IsHTML(true);
  // if (!$mail->send()) {
  //   // Enable debugging before calling send() again:
  //   // $mail->SMTPDebug = 2; // Set debugging level to 2 for detailed output
  //   $mail->send(); // Attempt to send again for debugging information
  //   echo 'Mailer Error: ' . $mail->ErrorInfo;
  //   exit;
  // }

  $mail->send();

  return $mailcontent;
}

function mail_client($to, $cc, $subject, $message, $file)
{


  // Mail Template
  $mailcontent  = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>
         
         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">
			
			<div>
			<div style="margin-bottom:15px;" id="username">
            <input type="image" src="' . root() . '/outsourcehr-admin/uploads/JOB' . client_detail('client_logo') . '" style="width:150px;" />
            
				

			</div>
			</div>
			
			<div style="font-size:16px;"> <p></p>' . $message . '
			  <p>Best Regards,<br>' . client_detail('client_name') . '<br><br>

			</p>
			</div>
			<br>
		   </div>
       	   </div><!-- White area ends here -->
    <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    	<div style="text-align:center; font-size:36px;"></div>
    </div>

    <div style="clear:both;"></div>
    
    <div id="copyright" style="font-size:13px; margin-top:5px;">Copyright &copy; - ' . date('Y') . '. ' . organisation() . '</div>
    <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>';


  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Port = smtp_detail('port');
  $mail->SMTPAuth = true;
  //sendgrid
  $mail->Username = smtp_detail('username');
  $mail->Password = smtp_detail('password');  //yahoo app password for noreply email 
  $mail->Host = smtp_detail('host');
  $mail->SMTPSecure = smtp_detail('secure');
  $mail->From = sender_email();
  $mail->FromName = sender_name();
  if ($file) {
    $mail->addAttachment($file);
  }
  $mail->FromName = organisation();

  if ($_SESSION['testing_mode'] == 'yes') {
    $mail->AddAddress(test_email());
  } else {
    $mail->AddAddress($to);
  }
  $mail->addCC($cc);

  //$mail->MsgHTML($sbody);
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->Body    = $mailcontent;
  $mail->Subject = $subject;
  $mail->IsHTML(true);
  // if (!$mail->send()) {
  //   // Enable debugging before calling send() again:
  //   $mail->SMTPDebug = 2; // Set debugging level to 2 for detailed output
  //   $mail->send(); // Attempt to send again for debugging information
  //   echo 'Mailer Error: ' . $mail->ErrorInfo;
  //   exit;
  // }
  $mail->send();

  return $mailcontent;
}