<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// if(isset($_REQUEST['to'])){
//  $to=$_REQUEST['to'];
//  $subject=$_REQUEST['subject'];
//  $content=$_REQUEST['message'];
//  send_mail($to,$subject,$content);
//  }




function send_otp($to,$subject,$content){

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'cloneutopia0@gmail.com';                     //SMTP username
    $mail->Password   = 'sawk expq thck nggh';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('example@gmail.com', 'OTP FOR CHECK-IN ONLINE - TEAM 7 HOTEL');
    $mail->addAddress($to, 'Verify Email');     //Add a recipient
  // $mail->addAttachment('./iics.txt');
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    ="<font size='4'>Mã OTP của bạn là: ".$content."<br>
    OTP này chỉ có giá trị sử dụng 1 lần.
    </font>";
   

    $mail->send();
    echo 'OTP đã gửi thành công!';
} catch (Exception $e) {
    echo "OTP đã gửi thất bại. Mailer Error: {$mail->ErrorInfo}";
}

}