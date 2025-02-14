<?php 
    require 'dbconnect.php';
    session_start();

    if(isset($_POST['checkin-btn'])){

        $loaigiayto = $_POST['loai-giay-to'];
        $masogiayto = $_POST['ma-so-giay-to'];
        $ngaycheckin = $_POST['ngay-checkin'];
        $hoten = $_POST['hoten'];
        $loaiphong = $_POST['loaiphong'];
        $soluong = $_POST['soluong'];

        if(!empty($loaigiayto) && !empty($masogiayto && !empty($ngaycheckin))){
            $sql = "INSERT INTO checkin (hoten, loaigiayto, masogiayto, ngaycheckin, loaiphong, soluong) VALUES('$hoten', '$loaigiayto', '$masogiayto', '$ngaycheckin', ' $loaiphong', '$soluong')";

            if(mysqli_query($con,$sql)){
                header("location:done.php?msg=Chúng tôi đã ghi nhận đơn Check-In của bạn");
            }
            else{
                header("location:index.php?msg=Đơn Check-In thực hiện thất bại!!! Vui lòng thử lại!!!");
            }
        }
        else{
            echo "Bạn cần nhập đủ dữ liệu";
        }

    }
    
?>

