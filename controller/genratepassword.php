<?php

error_reporting(0);
require '../phpmailer/PHPMailerAutoload.php';
include '../db.php';

$email = $_GET['email'];
?>



<?php


$fetchpassword = $db->query("SELECT GenerateRandomPassword(10) AS passw")->fetch(PDO::FETCH_OBJ);
$hashpass = password_hash($fetchpassword->passw, PASSWORD_DEFAULT);

$db->query("UPDATE users SET password='$hashpass' WHERE email='$email'");


$mail = new PHPMailer;
//$mail->SMTPDebug = 2;
$mail->IsSMTP();   // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';   // Specify main and backup SMTP servers
$mail->SMTPAuth = true;  // Enable SMTP authentication
$mail->Username = 'ananthmukesh659@gmail.com'; // your email id
$mail->Password = 'levirbnzufvmwdka'; // your password                      
$mail->Port = 465;     //587 is used for Outgoing Mail (SMTP) Server.
$mail->SMTPSecure = 'ssl';                     
$mail->SetFrom('ananthmukesh659@gmail.com', 'Password Successfully Genrate');
$mail->addAddress($email);   // Add a recipient
//$mail->AddReplyTo($rowcompany->stn_email, 'PCNL '.$invnostn);
$mail->isHTML(true);  // Set email format to HTML


$bodyContent .= '<p style="color:black;">Hi '.$email.'</p>';
$bodyContent .= '<p style="color:black;">Your Genrated Password</p><br>';
$bodyContent .= '<p style="color:black;">Password:<b>'.$fetchpassword->passw.'</b></p><br>';
$bodyContent .= '<p style="color:black;"><strong>Kind Regards,</strong></p><p>Developer Team</p>';

$mail->Subject = 'get password to login your account';
// $mail->addStringAttachment($attachment_file,''.$rowinvoice->cust_code.'-'.$invno.'.pdf');

$mail->Body    = $bodyContent;
$mail_user    = $email;
if(!$mail->send()) {
     $message = 'error';
} else {
    $message = '<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0;">
    <div style="text-align: center;">
        <div style="background-color: #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); border-radius: 5px; padding: 20px; max-width: 500px;">
            <h2 style="font-size: 24px; margin-top: 0;color:green;">Success</h2>
            <p>Your Password Successfully Genrated and sent to registered email</p>
            <button style="background-color: #ff5733; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px; font-weight: bold;" class="close-btn"><a style="color:white;" href="http://localhost/interview_task/login.php">Login</a></button>
        </div>
    </div>
</body>';
}

echo $message;
?>