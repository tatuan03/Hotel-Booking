<?php
session_start();
include("dbconnect.php");



$email=$_SESSION['email'];
$otp=$_POST['user_otp'];
$hoten = mysqli_fetch_array(mysqli_query($con, "SELECT u.hoten FROM users u WHERE email='$email' and user_otp ='$otp'"));
$sql="Select * from users where email='$email' and user_otp='$otp'";
$rs=mysqli_query($con,$sql)or die(mysqli_error($con));
if(mysqli_num_rows($rs)>0){
    $sql="update users set user_otp='' where email='$email'";
    $rs=mysqli_query($con,$sql)or die(mysqli_error($con));
    header("location:formcheckin.php?msg=Chào mừng, khách hàng: ".$hoten['hoten']."!! Đăng nhập thành công!!");

}
else{
    header("location:verify.php?msg=OTP không chính xác!! Hãy thử lại!!");
}
?>