<?php
include 'connect.php';

// Cập nhật trạng thái thanh toán của các dịch vụ
$stmt = $conn->prepare("UPDATE ordered SET status = 'Đã thanh toán' WHERE status = 'Chưa thanh toán'");
if ($stmt->execute()) {
    echo 'success';
} else {
    $errorInfo = $stmt->errorInfo();
    echo 'error: ' . $errorInfo[2];
}
?>