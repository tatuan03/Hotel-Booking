<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  
 $vnp_TmnCode = "FG14U5C9"; //Website ID in VNPAY System
 $vnp_HashSecret = "DJX4GE29W944O49DEUCJM47HQTB0B9HE"; //Secret key
 $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
 $vnp_Returnurl = "http://localhost/Final_7Hotel/Hotel-Booking-Room/vnpay_php/vnpay_return.php";
 $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
