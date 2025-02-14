<?php

session_start();
// Kiểm tra xem tên và booking_id đã được truyền qua URL hay chưa
if (isset($_GET['name']) && isset($_GET['booking_id'])) {
    $name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
    $booking_id = filter_var($_GET['booking_id'], FILTER_SANITIZE_STRING);
    // Cập nhật session với booking_id mới
    $_SESSION['booking_id'] = $booking_id;
    // Chuyển hướng người dùng đến trang ordered.php
    header("Location: service.php");
    exit; // Đảm bảo dừng kịch bản thực thi sau khi chuyển hướng
} else {
    // Xử lý khi không có dữ liệu được truyền
    // Ví dụ: chuyển hướng người dùng đến trang khác hoặc hiển thị thông báo lỗi
}


?>
<?php
include 'connect.php';

// Xử lý logic để lấy booking_id và booking_name từ session hoặc từ URL
if (isset($_SESSION['booking_id'])) {
    $booking_id = $_SESSION['booking_id'];

    // Thực hiện truy vấn SQL để lấy booking_name từ booking_id
    $stmt = $conn->prepare("SELECT name FROM bookings WHERE booking_id = ?");
    $stmt->execute([$booking_id]);
    $booking_info = $stmt->fetch(PDO::FETCH_ASSOC);
    $booking_name = isset($booking_info['name']) ? $booking_info['name'] : '';
    

} else {
    // Xử lý khi không có booking_id được truyền
    // Ví dụ: chuyển hướng người dùng đến trang khác hoặc hiển thị thông báo lỗi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Service</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="./style.css">
   <link rel="stylesheet" href="service.css">
</head>
<body>

<?php include 'user_header.php'; ?>
<div class="main">
        <div class="header">
            <ul class="header-list">
            <li id="booking-menu" style="background-color: rgb(85, 85, 85, 0.6); border-radius: 5px;"><a href="service.php?booking_id=<?php echo $booking_id; ?>" class="booking-menu">BOOKING</a></li>
            <li id="ordered-menu" ><a href="ordered.php?booking_id=<?php echo $booking_id; ?>" class="ordered-menu">ORDERED</a></li>
            </ul>
        </div>
        <div class="container">
            <!-- Bảng danh sách dịch vụ -->
            <div class="menu-list-all">
                <div class="card" style="color: black;">
                    <div class="card-header">
                        <h2>DANH SÁCH MENU</h2>
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody id="menuTable" >
                                <!-- PHP để lấy dữ liệu từ cơ sở dữ liệu -->
                                <?php
                                    require_once 'connect.php';
                                    $sql = "select * from services";
                                    $query = mysqli_query($connect, $sql);
                                    $i = 1;
                                    while($row = mysqli_fetch_assoc($query)){ ?>
                                        <!-- Mỗi hàng trong bảng danh sách dịch vụ -->
                                        <tr class="page<?php echo ceil($i/5); ?>" onclick="selectRow(this);">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td style="width: 10%">
                                                <img style="width: 100%;" src="./img/<?php echo $row['image']; ?>">
                                            </td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- Phân trang cho bảng danh sách dịch vụ -->
                        <div id="pagination"></div>
                    </div>
                </div>
            </div>

            <!-- Form thông tin dịch vụ -->
    <div class="form-container">
    <form id="serviceForm">
        <h2 style="text-align: center; font-size: 2rem; padding: 5px 0;">THÔNG TIN DỊCH VỤ</h2>
        <br>
        <div class="form-group">
        <p>Booking ID: <span id="bookingIdSpan"><?= isset($booking_id) ? htmlspecialchars($booking_id) : ''; ?></span></p>
        <input type="hidden" id="bookingId" name="bookingId" value="<?= isset($booking_id) ? htmlspecialchars($booking_id) : ''; ?>">
    </div>
    <div class="form-group">
        <p>Booking Name: <span id="bookingNameSpan"><?= isset($booking_name) ? htmlspecialchars($booking_name) : ''; ?></span></p>
        <input type="hidden" id="bookingName" name="bookingName" value="<?= isset($booking_name) ? htmlspecialchars($booking_name) : ''; ?>">
    </div>
        <div class="form-group">
            <label for="serviceName">Tên dịch vụ:</label>
            <input type="text" id="serviceName" name="serviceName" readonly required>
        </div>
        <div class="form-group">
            <label for="serviceDescription">Mô tả:</label>
            <textarea id="serviceDescription" name="serviceDescription" rows="4" readonly required></textarea>
        </div>
        <div class="form-group">
            <label for="servicePrice">Giá:</label>
            <input type="text" id="servicePrice" name="servicePrice" readonly required>
        </div>
        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <div class="quantity-controls" >
                <button type="button" onclick="decrementQuantity()">-</button>
                <input type="number" id="quantity" name="quantity" min="1" value="1" max="2" onchange="calculateTotal()">
                <button type="button" onclick="incrementQuantity()">+</button>
            </div>
        </div>
        <div class="form-group">
            <label for="total">Tổng tiền:</label>
            <input type="text" id="total" name="total" readonly>
        </div>
        <button type="button" onclick="if(validateServiceForm()) addService();" style="cursor: pointer;">Đặt Dịch Vụ</button>

    </form>
    </div>
    
<!-- Thêm mã HTML cho message box -->
<div id="messageBox"
class="message-box">
    <p id="messageTitle">Đặt dịch vụ thành công!</p>
    <div class="icon-container">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="button-container">
        <button class="message-button" onclick="closeMessageBox()">Ở lại</button>
        <button class="message-button" onclick="navigateToOrderedPage()">Tiếp tục thanh toán</button>
    </div>
</div>

</div>
</div>
<br><br>
<!-- Form yêu cầu dịch vụ -->
<div class="request-service-form">
    <form id="requestServiceForm" method="post" action="sendEmail.php">
        <h2 style="text-align: center; font-size: 2rem; padding: 10px 0;">YÊU CẦU DỊCH VỤ</h2>
        <div class="form-group">
            <label for="customerName">Họ và Tên:</label>
            <input type="text" id="customerName" name="customerName" required>
        </div>
        <div class="form-group">
            <label for="customerName">Số điện thoại:</label>
            <input type="text" id="customerNumber" name="customerNumber" required>
        </div>
        <div class="form-group">
            <label for="customerEmail">Email:</label>
            <input type="email" id="customerEmail" name="customerEmail" required>
        </div>
        <div class="form-group">
            <label for="serviceRequest">Yêu cầu dịch vụ:</label>
            <textarea id="serviceRequest" name="serviceRequest" rows="4" required></textarea>
        </div>
        <button type="submit">Gửi</button>
    </form>
</div>
<!-- MessageBox -->
<div id="customMessageBox" class="custom-message-box" style="display: none;">
    <p id="customMessageTitle">Thông tin đã được gửi!</p>
    <div class="custom-icon-container">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="custom-button-container">
        <button class="custom-message-button" onclick="closeCustomMessageBox()">OK</button>
    </div>
</div>
<?php include './footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="./js/script.js"></script>

<?php include 'message.php'; ?>

</body>
<script>
    var currentPage = 1;
    var rowsPerPage = 5;
    var totalRows = <?php echo mysqli_num_rows($query); ?>;
    var maxPage = Math.ceil(totalRows / rowsPerPage);

    // Hiển thị các hàng trên trang
    function showPage(page) {
        var startIndex = (page - 1) * rowsPerPage;
        var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

        var tableRows = document.querySelectorAll("#menuTable tr");
        tableRows.forEach(function(row) {
            row.style.display = "none";
        });

        var pageClass = ".page" + page;
        var currentPageRows = document.querySelectorAll(pageClass);
        currentPageRows.forEach(function(row) {
            row.style.display = "";
        });
    }

    // Chuyển đến trang được chọn
    function goToPage(page) {
        currentPage = page < 1 ? 1 : (page > maxPage ? maxPage : page);
        showPage(currentPage);
        updatePagination();
    }

    // Cập nhật phân trang
    function updatePagination() {
        var pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        var prevButton = document.createElement('button');
        prevButton.textContent = '<<';
        prevButton.addEventListener('click', function() {
            goToPage(currentPage - 1);
        });
        pagination.appendChild(prevButton);

        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(maxPage, startPage + 4);

        for (var i = startPage; i <= endPage; i++) {
            var pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.addEventListener('click', function() {
                goToPage(parseInt(this.textContent));
            });
            pagination.appendChild(pageButton);
        }

        var nextButton = document.createElement('button');
        nextButton.textContent = '>>';
        nextButton.addEventListener('click', function() {
            goToPage(currentPage + 1);
        });
        pagination.appendChild(nextButton);
    }

    // Chọn một dòng trong bảng dịch vụ
    function selectRow(row) {
        var selectedRow = document.querySelector('.selected-row');
        if (selectedRow) {
            selectedRow.classList.remove('selected-row');
        }
        row.classList.add('selected-row');

        var cells = row.getElementsByTagName("td");
        document.getElementById("serviceName").value = cells[1].innerText;
        document.getElementById("serviceDescription").value = cells[3].innerText;
        document.getElementById("servicePrice").value = cells[4].innerText;

        document.getElementById("quantity").value = 1;
        calculateTotal();
    }
    function validateServiceForm() {
    var serviceName = document.getElementById("serviceName").value;
    var serviceDescription = document.getElementById("serviceDescription").value;
    var servicePrice = document.getElementById("servicePrice").value;
    var quantity = document.getElementById("quantity").value;

    if (serviceName.trim() === '' || serviceDescription.trim() === '' || servicePrice.trim() === '' || quantity.trim() === '') {
        alert('Vui lòng điền đầy đủ thông tin trước khi đặt dịch vụ.');
        return false;
    }

    return true;
}


    function addService() {
    var elements = [
        'serviceName',
        'serviceDescription',
        'servicePrice',
        'quantity',
        'total',
        'bookingId',
        'bookingName'
    ];

    var missingElements = [];

    elements.forEach(function(id) {
        if (!document.getElementById(id)) {
            missingElements.push(id);
        }
    });

    if (missingElements.length > 0) {
        console.error("Missing elements: ", missingElements.join(', '));
        return false;
    }

    var serviceName = document.getElementById("serviceName").value;
    var serviceDescription = document.getElementById("serviceDescription").value;
    var servicePrice = document.getElementById("servicePrice").value;
    var quantity = document.getElementById("quantity").value;
    var total = document.getElementById("total").value;
    var bookingId = document.getElementById("bookingId").value;
    var bookingName = document.getElementById("bookingName").value;

    console.log("Data being sent: ", {
        serviceName: serviceName,
        serviceDescription: serviceDescription,
        servicePrice: servicePrice,
        quantity: quantity,
        total: total,
        bookingId: bookingId,
        bookingName: bookingName
    });

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add-service.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
           
            console.log("Response: ", xhr.responseText);
           
        }
    };
    xhr.send("serviceName=" + encodeURIComponent(serviceName) +
             "&serviceDescription=" + encodeURIComponent(serviceDescription) +
             "&servicePrice=" + encodeURIComponent(servicePrice) +
             "&quantity=" + encodeURIComponent(quantity) +
             "&total=" + encodeURIComponent(total) +
             "&bookingId=" + encodeURIComponent(bookingId) +
             "&bookingName=" + encodeURIComponent(bookingName));

    showMessageBox();

   
}

// Tính tổng tiền dựa trên số lượng và giá
function calculateTotal() {
    var quantity = parseInt(document.getElementById("quantity").value);
    var price = parseFloat(document.getElementById("servicePrice").value);
    var total = quantity * price;
    document.getElementById("total").value = total.toFixed(2);
}

// Tăng giảm số lượng
function incrementQuantity() {
    var quantityInput = document.getElementById("quantity");
    var currentValue = parseInt(quantityInput.value);
    if(currentValue < 2){
    quantityInput.value = currentValue + 1;
    }
    calculateTotal();
    
}

function decrementQuantity() {
    var quantityInput = document.getElementById("quantity");
    var currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        calculateTotal();
    }
}

function showMessageBox() {
    document.getElementById("messageBox").style.display = "block";
}

// Function để tắt message box
function closeMessageBox() {
    document.getElementById("messageBox").style.display = "none";
}

// Function để điều hướng đến trang ordered.php
function navigateToOrderedPage() {
    window.location.href = "ordered.php?booking_id=" + bookingId;
}

// Khởi tạo khi trang được tải
window.onload = function() {
    showPage(currentPage);
    updatePagination();
};

var bookingId = "<?php echo isset($booking_id) ? $booking_id : ''; ?>";

// JavaScript để xử lý sự kiện nhấn nút "Gửi" và hiển thị customMessageBox
document.getElementById("requestServiceForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn chặn việc submit form mặc định

    // Hiển thị message box
    showCustomMessageBox();

    // Gửi dữ liệu từ form thông qua Ajax request
    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "sendEmail.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText); // Kiểm tra phản hồi từ máy chủ
        }
    };
    xhr.send(formData);

    // Đặt hẹn giờ tự động tắt message box sau 5 giây
    setTimeout(function() {
        closeCustomMessageBox();
    }, 5000);
});

// JavaScript để hiển thị message box
function showCustomMessageBox() {
    document.getElementById("customMessageBox").style.display = "block";
}

// JavaScript để tắt message box
function closeCustomMessageBox() {
    document.getElementById("customMessageBox").style.display = "none";
}

</script>
</html>
