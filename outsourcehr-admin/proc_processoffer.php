<?php 

ob_start();
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,  // If your site uses HTTPS
    'httponly' => true  // Set httponly flag
]);

session_start();


   
include('connection/connect.php');
require_once('inc/fns.php');
    require_once('PHPMailer/PHPMailerAutoload.php');  
    

    $rejectreason = mysqli_real_escape_string($db, $_POST['rejectreason']);

    $acceptanceletter = mysqli_real_escape_string($db, $_POST['acceptanceletter']);

  $type = mysqli_real_escape_string($db, $_POST['type']);
     $email = mysqli_real_escape_string($db, $_POST['email']);

    $encode_type = base64_encode($type);
    $encode_email = base64_encode($email);

    // Retriving hrbp email address 
    $query_select= "SELECT * FROM approve_message WHERE email='$email'";
    $result_select= mysqli_query($db, $query_select);
    $row_select= mysqli_fetch_array($result_select);
    $hrbp_email = $row_select['adminEmail'];

    if($type == 'reject'){
        
        if($rejectreason == '')
        {
            $error = base64_encode("Kindly type reason for rejecting the letter");
            header("location: processofferrequest.php?t=$encode_type&e=$encode_email&err=$error");
            exit;
        }

        $query= "UPDATE approve_message SET staffReject_reason = '$rejectreason', status = 'Staff Rejected' WHERE email = '$email'";
        
        $result= mysqli_query($db, $query);

        if($result){
            // Get details of staff
          $query_update= "SELECT * FROM emp_staff_details WHERE email_address='$email'";
          $result_update= mysqli_query($db, $query_update);
          $row_update= mysqli_fetch_array($result_update);

            // Sending mail to HRBP 
            $subject= "Offer Letter Declined";
            $body = "Dear HRBP, <br><br>
            A staff just declined their offer letter.<br>
            Details below:<br>
            Name: ". $row_update['firstname']." ".$row_update['surname']." <br>
            Client: ".$row_update['company_code']." <br>
            Reason for Rejection: ".$rejectreason." <br>
            ";
            $file="Null";
            mail_client($hrbp_email,$cc,$subject,$body,$file);

            // Success Message 
            $success = base64_encode("Reason for rejection sent successfully");
            header("location: processofferrequest.php?t=$encode_type&e=$encode_email&suc=$success");
            exit;
            
        }else{
            $error = base64_encode("An error occured while sending rejection");
            header("location: processofferrequest.php?t=$encode_type&e=$encode_email&err=$error");
            exit;
        }

    }
  
    if ($type === "accept") {
        if (empty($_FILES["acceptanceletter"]["name"])) {
            $error = base64_encode("Kindly upload acceptance letter");
        } else {

            // Uploading files
            $uploadDir = '../'.FILE_DIR.'upload_credentials/';
            $uploadDir2 = '/'.FILE_DIR.'upload_credentials/';


            $tempName = $_FILES["acceptanceletter"]["tmp_name"];
            $originalName = $_FILES["acceptanceletter"]["name"];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueFileName = $email . '_Acceptance_' . uniqid() . '.' . $fileExtension;

            $destination = $uploadDir . $uniqueFileName; //first destination
            $onboarding_destination = $uploadDir2 . $uniqueFileName; //onboarding destination
            
    
            // Check for file upload errors
            if ($_FILES["acceptanceletter"]["error"] === UPLOAD_ERR_OK) {
                // Move the uploaded file to the desired folder
                if (move_uploaded_file($tempName, $destination)) {

                    // Insert file information into the database
                    $credential = $onboarding_destination;
                    $credentialSize = filesize($destination);
    
                    // Perform database insert using your preferred database connection method
                    $query_upload = "INSERT INTO cp_credentials (user, document_type, credential, credential_size) VALUES ('$email', 'Acceptance Letter', '$uniqueFileName', '$credentialSize')";
    
                    $result_upload = mysqli_query($db, $query_upload);
    
                    if ($result_upload) {


                       $query= "UPDATE approve_message SET status = 'Staff Accepted', acceptance_date = '".mydatetime()."' WHERE email = '$email'";
                        $result= mysqli_query($db, $query);

                        // Sending mail to hrbp
                        $subject = "Acceptance Letter from ".$row_select['fullname'];
                        $body = "Dear HRBP, <br><br> Attached to this mail is the acceptance letter of " . $row_select['fullname'];
                        $file = $credential;
                        mail_client($hrbp_email, $cc, $subject, $body, $destination);


                        // Onboarding Message
                        $subject = "Staff Onboarding - Welcome to KlinHR";
                        $body = "You are welcome to KlinHR LLC. All information about your onboarding is attached.<br><br>To access Staff portal, follow the link below and use the credentials <a href='".host()."/staffportal'>".host()."/staffportal</a><br><br>Username: ".staff_id_email($email)."<br>Password: ".staff_id_email($email);

                        // set up staff in staff portal and leave portal

                
                setup_staff(staff_id_email($email));
                       
                send_email($email, $row_select['fullname'], organisation(), $subject, $body);
                        
    
                $success = base64_encode("Acceptance letter uploaded successfully. Check your email for your onboarding pacakge");
                        
                    } else {
                        $error = base64_encode("An error occurred while inserting into the database");
                    }
                } else {
                    $error = base64_encode("An error occurred while moving the uploaded file");
                }
            } else {
                $error = base64_encode("File upload error: " . $_FILES["acceptanceletter"]["error"]);
            }
        }
        if($success){
            header("location: processofferrequest.php?t=$encode_type&e=$encode_email&suc=$success");
            exit;
        }else{
            header("location: processofferrequest.php?t=$encode_type&e=$encode_email&err=$error");
            exit;
        }
        
    }

?>