<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $customerName = $_POST["customerName"];
    $customerNumber = $_POST["customerNumber"];
    $customerEmail = $_POST["customerEmail"];
    $serviceRequest = $_POST["serviceRequest"];

    // Khởi tạo PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'truonghuunam2002@gmail.com';
        $mail->Password   = 'rutgtheqaeamjgat';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Thiết lập các thông tin người gửi và người nhận
        $mail->setFrom('truonghuunam2002@gmail.com');
        $mail->addAddress('trinhanhtuan2k3@gmail.com');
        
        $encodedSubject = mb_encode_mimeheader('Yêu cầu dịch vụ từ ' . $customerName, 'UTF-8', 'Q');

        // Thiết lập tiêu đề và nội dung email
        $mail->isHTML(true);
        $mail->Subject = $encodedSubject;
        $mail->Body    = 'Họ và tên: ' . $customerName . '<br>Số điện thoại:' . $customerNumber . '<br>Email: ' . $customerEmail . '<br>Yêu cầu dịch vụ: ' . $serviceRequest;

        // Gửi email
        $mail->send();
        echo '<p>Message has been sent.</p>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "service.php";
                }, 2000);
              </script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>



