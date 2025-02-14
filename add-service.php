<?php
require_once 'connect.php'; // Kết nối cơ sở dữ liệu


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceName = $_POST['serviceName'];
    $serviceDescription = $_POST['serviceDescription'];
    $servicePrice = $_POST['servicePrice'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $bookingId = $_POST['bookingId'];
    $bookingName = $_POST['bookingName'];

    // Trạng thái mặc định
    $status = 'Chưa thanh toán';

    $stmt = $connect->prepare("INSERT INTO ordered (name, description, price, quantity, total, id_booking, booking_name, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiisss", $serviceName, $serviceDescription, $servicePrice, $quantity, $total, $bookingId, $bookingName, $status);

    $stmt->execute();
        
 

    $stmt->close();
    $connect->close();
}
