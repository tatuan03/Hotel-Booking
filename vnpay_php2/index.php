<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Tạo mới đơn hàng</title>
        <!-- Bootstrap core CSS -->
        <link href="../vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="../vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">  
        <script src="../vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>

    <body>
        <?php require_once("../vnpay_php/config.php"); ?>             
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY DEMO</h3>
            </div>
            <h3>Tạo mới đơn hàng</h3>
            <div class="table-responsive">
                <form action="./vnpay_create_payment.php" id="create_form" method="post">       

                    <div class="form-group">
                        <label for="language">Loại Phòng </label>
                        <select name="order_type" id="order_type" class="form-control">
                            <option value="topup">Single Bed Room</option>
                            <option value="billpayment">Delux Single Bed Room</option>
                            <option value="fashion">Double Bed Room</option>
                            <option value="other">Delux Double Bed Room</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_id">Mã hóa đơn</label>
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>"/>
                    </div>
                    <?php
                    // vnpay_php/index.php
                    $total_days = isset($_GET['total_days']) ? intval($_GET['total_days']) : 0;
                    $total_payment = isset($_GET['total_payment']) ? intval($_GET['total_payment']) : 0;

                    // Ensure the values are valid
                    if ($total_days > 0 && $total_payment > 0) {
                    // Proceed with payment processing
                    } else {
                    // Handle the error
                     //echo "Invalid booking details.";
                    }   
                    ?>
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input readonly class="form-control" id="amount"
                               name="amount" value="<?=$total_payment?>"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="order_desc">Nội dung thanh toán</label>
                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
                    </div>
                    <div class="form-group">
                        <label for="language">Ngôn ngữ</label>
                        <select name="language" id="language" class="form-control">
                            <option value="vn">Tiếng Việt</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Thời gian thanh toán</label>
                        <input class="form-control" id="txtexpire"
                               name="txtexpire" type="text" value="<?php echo $expire; ?>"/>
                    </div>
                    <button type="submit" name="redirect" id="redirect" class="btn btn-primary">Thanh toán</button>

                </form>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
       
         


    </body>
</html>
