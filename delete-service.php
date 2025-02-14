<?php
include 'connect.php';

// Kiểm tra xem yêu cầu POST có chứa id hay không
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Chuẩn bị câu truy vấn SQL để xóa hàng
    $stmt = $conn->prepare("DELETE FROM ordered WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo 'success';
    } else {
        $errorInfo = $stmt->errorInfo();
        echo 'error: ' . $errorInfo[2];
    }
} else {
    echo 'error: No ID provided';
}
?>
