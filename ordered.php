<?php
include 'connect.php';
// Bắt đầu session
session_start();

// Kiểm tra xem booking_id đã được truyền qua URL hay chưa
if (isset($_SESSION['booking_id'])) {
    $booking_id = $_SESSION['booking_id'];
} else {
    // Nếu không có booking_id được truyền, chuyển hướng người dùng đến trang service
    header("Location: service.php");
    exit; // Đảm bảo dừng kịch bản thực thi sau khi chuyển hướng
}

// Khởi tạo biến $orders
$orders = [];

try {
    // Truy vấn dữ liệu từ bảng ordered với điều kiện id_booking
    $stmt = $conn->prepare("SELECT name, description, price, quantity, total, id_booking, booking_name, id FROM ordered WHERE id_booking = ? and status = 'Chưa thanh toán'");
    $stmt->execute([$booking_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Xử lý lỗi nếu có
    echo "Error: " . $e->getMessage();
}

    $totalSum = 0;
    foreach ($orders as $order) {
    $totalSum += $order['total'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordered Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./ordered.css">
    <link rel="stylesheet" href="./service.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'user_header.php'; ?>
    <div class="header">
        <ul class="header-list">
            <li id="booking-menu"><a href="service.php?booking_id=<?php echo $booking_id; ?>">BOOKING</a></li>
            <li id="ordered-menu" style="background-color: rgb(85, 85, 85, 0.6); border-radius: 5px;"><a href="ordered.php?booking_id=<?php echo $booking_id; ?>" class="ordered-menu">ORDERED</a></li>
        </ul>
    </div>
    <div class="container">
        
        <?php if (count($orders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>ID Booking</th>
                    <th>Booking Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr id="row-<?php echo $order['id']; ?>">
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                    <td><?php echo htmlspecialchars($order['description']); ?></td>
                    <td><?php echo htmlspecialchars($order['price']); ?></td>
                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($order['total']); ?></td>
                    <td><?php echo htmlspecialchars($order['id_booking']); ?></td>
                    <td><?php echo htmlspecialchars($order['booking_name']); ?></td>
                    <td><button class="delete-btn" data-id="<?php echo $order['id']; ?>"><i class="fas fa-times delete-icon"></i></button></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: center; font-size: 1.5rem;"><strong>Total:</strong></td>
                    <td colspan="3" style="text-align: center; font-size: 1.5rem;"><?php echo $totalSum; ?>đ</td>
                    <td></td> <!-- Không có nút xóa ở hàng tổng cộng -->
                </tr>   
            </tbody>
        </table>
        <!-- <div class="payment-container">
            <button id="pay-btn">Pay</button>
        </div> -->
        </form>
        <?php else: ?>
        <p style="color: black; text-align: center; font-size: 2rem; width: 100%; padding: 30px 0; font-weight: 500;">Không có dịch vụ nào được đặt cho phòng này.</p>
        <?php endif; ?>
    </div>
    

    <?php include 'footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
                    $.ajax({
                        url: 'delete-service.php',
                        type: 'POST',
                        data: {id: id},
                        success
                        : function(response) {
                            if ($.trim(response) == 'success') {
                                $('#row-' + id).remove();
                            } else {
                                alert('Xóa dịch vụ thất bại: ' + response);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Có lỗi xảy ra: ' + error);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
    // Xử lý sự kiện click nút "Thanh toán"
    $('#pay-btn').click(function() {
        
            $.ajax({
                url: 'update-status.php',
                type: 'POST',
                success: function(response) {
                    if ($.trim(response) == 'success') {
                        // Chuyển hướng đến trang web khác
                        window.location.href = './vnpay_php/index.php';
                    } else {
                        alert('Thanh toán không thành công: ' + response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra: ' + error);
                }
            });
        
    });

    // ... (code xử lý xóa dịch vụ như trước)
});
    </script>
</body>
</html>
