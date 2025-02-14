<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once("./config.php");
 
// Input data
$vnp_TxnRef = isset($_POST['order_id']) ? $_POST['order_id'] : null;
$vnp_OrderInfo = isset($_POST['order_desc']) ? $_POST['order_desc'] : null;
$vnp_OrderType = isset($_POST['order_type']) ? $_POST['order_type'] : null;
$vnp_Amount = isset($_POST['amount']) ? $_POST['amount'] * 100 : 0;
$vnp_Locale = isset($_POST['language']) ? $_POST['language'] : 'vn';
$vnp_BankCode = isset($_POST['bank_code']) ? $_POST['bank_code'] : null;
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
$vnp_ExpireDate = isset($_POST['txtexpire']) ? $_POST['txtexpire'] : null;

// Billing
$fullName = isset($_POST['txt_billing_fullname']) ? trim($_POST['txt_billing_fullname']) : '';
if (!empty($fullName)) {
    $name = explode(' ', $fullName);
    $vnp_Bill_FirstName = array_shift($name);
    $vnp_Bill_LastName = implode(' ', $name);
}

// Build data array
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $vnp_ExpireDate,
);

if (!empty($vnp_BankCode)) {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

// Sort and build query
ksort($inputData);
$query = "";
$hashdata = "";
foreach ($inputData as $key => $value) {
    $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
}
$query = rtrim($hashdata, '&');

// Generate secure hash
if (!empty($vnp_HashSecret)) {
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;
}

// Output or redirect
$returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
if (isset($_POST['redirect'])) {
    header('Location: ' . $vnp_Url);
    die();
} else {
    echo json_encode($returnData);
}