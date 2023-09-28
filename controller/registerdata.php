<?php
session_start();
require '../phpmailer/PHPMailerAutoload.php';
include '../db.php';
if(isset($_POST['action']) && $_POST['action']=='Register'){
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];


    try {

        $mail = new PHPMailer;
        //$mail->SMTPDebug = 2;
        $mail->IsSMTP();   // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';   // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'ananthmukesh659@gmail.com'; // your email id
        $mail->Password = 'levirbnzufvmwdka'; // your password                      
        $mail->Port = 465;     //587 is used for Outgoing Mail (SMTP) Server.
        $mail->SMTPSecure = 'ssl';                     
        $mail->SetFrom('ananthmukesh659@gmail.com', 'Password Genrate');
        $mail->addAddress($email);   // Add a recipient
        //$mail->AddReplyTo($rowcompany->stn_email, 'PCNL '.$invnostn);
        $mail->isHTML(true);  // Set email format to HTML
        
        
        $bodyContent .= '<p style="color:black;">Hi '.$email.'</p>';
        $bodyContent .= '<p style="color:black;">Click Link to send genrate Password to your Registered Email</p><br>';
        $bodyContent .= ' <button style="border-radius:5px;padding:10px;background-color:#5203fc;color:white;"><a style="color:white;" href="http://localhost/interview_task/controller/genratepassword.php?email='.$email.'">Click to Genrate</a></button>';
        $bodyContent .= '<p style="color:black;"><strong>Kind Regards,</strong></p><p>Developer Team</p>';
       
        $mail->Subject = 'Password Verify';
       // $mail->addStringAttachment($attachment_file,''.$rowinvoice->cust_code.'-'.$invno.'.pdf');
        
        $mail->Body    = $bodyContent;
        $mail_user    = $email;
        if(!$mail->send()) {
             $message = 'error';
        } else {
            $message = 'success';
        }


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://ip-api.io/api/json',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/vnd.api+json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $city = json_decode($response,true)['city'];
        $region = json_decode($response,true)['region_name'];
        
       $geoloaction = $city.",".$region;



        $db->query("CALL Insert_users('$name', '$mobile', '$email', '$dob','$geoloaction')");
        echo json_encode([
            $message => 1
        ]); 


        
    } catch (\Throwable $th) {
        echo json_encode([
            $message => $th->getMessage(),
            'msg'=>$th->getMessage()
        ]); 
    }
   
    exit();
}


if(isset($_POST['action']) && $_POST['action']=='validate_email'){
    $email = $_POST['email'];
    $fetch_email = $db->query("SELECT count(email) as cemail FROM users WHERE email='$email'")->fetch(PDO::FETCH_OBJ);
    
   echo json_encode($fetch_email->cemail);
   exit();
}

if(isset($_POST['action']) && $_POST['action']=='login'){
    $email = $_POST['email'];
    $password = $_POST['password'];


$fetch_hashpassword = $db->query("SELECT * FROM users Where email='$email'")->fetch(PDO::FETCH_OBJ);

$hashedPasswordFromDatabase = "hashed_password_from_database";
if (password_verify($password, $fetch_hashpassword->password)) {
    echo "Password is correct!";
    $_SESSION['username'] = $fetch_hashpassword->name;
} else {
    echo "Password is incorrect!";
}
    exit();
}

if(isset($_POST['action']) && $_POST['action']=='fetch_edit_data'){
    $id = $_POST['id'];
  


$fetch_hashpassword = $db->query("SELECT * FROM users Where id='$id'")->fetch(PDO::FETCH_OBJ);
echo json_encode($fetch_hashpassword);
    exit();
}

if(isset($_POST['action']) && $_POST['action']=='updateuser'){
  $e_name = $_POST['e_name'];
  $e_email = $_POST['e_email'];
  $e_mobile = $_POST['e_mobile'];
  $e_id = $_POST['e_id'];
  try {
    $db->query("UPDATE users SET name='$e_name',email='$e_email',mobile='$e_mobile' WHERE id='$e_id'");
    echo json_encode("User Updates successfully...!");
  } catch (\Throwable $th) {
    echo json_encode("User Not Updated!");
  }
    exit();
}


if(isset($_POST['action']) && $_POST['action']=='deleteuser'){

    $id = $_POST['id'];
    try {
      $db->query("DELETE FROM users WHERE id='$id'");
      echo json_encode("Success");
    } catch (\Throwable $th) {
    echo json_encode("Error");
    }
      exit();
  }
?>