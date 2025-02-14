<?php
session_start();
include("dbconnect.php");
include("email.php");

$email=$_POST["email"];
$password=$_POST["password"];
$sql="Select * from users where email='$email' and password = '$password'";
$rs=mysqli_query($con,$sql)or die(mysqli_error($con));
if(mysqli_num_rows($rs)>0){
  $_SESSION['email']=$email;
  $otp=rand(11111,99999);
   send_otp($email,"OTP FOR CHECK-IN TEAM 7 HOTEL",$otp);
  $sql="update users set user_otp='$otp' where email='$email'";
$rs=mysqli_query($con,$sql)or die(mysqli_error($con));
header("location:verify.php?msg=Vui lòng kiểm tra Email và nhập OTP xác thực");

}
else{
    header("location:index.php?msg=Email không tồn tại!!! Vui lòng thử lại!!!");
}
?>