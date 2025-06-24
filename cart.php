<?php
session_start();
include("Database/connect.php");
include("header.php");

// Fetch theme
$q = mysqli_query($conn, "SELECT * FROM temp LIMIT 1");
$row = mysqli_fetch_row($q);

// Form values
$_SESSION['nm'] = $_POST['nm'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['mo'] = $_POST['mo'];
$_SESSION['date'] = $_POST['date'];
$_SESSION['theme'] = $row[1];
$_SESSION['theme_name'] = $row[2];
$_SESSION['price'] = $row[3];

$amount = $row[3]; // Theme price
$tx_uuid = uniqid('TX'); // Unique transaction ID
$success = "http://localhost/milantra/esewa_success.php";
$failure = "http://localhost/milantra/esewa_failure.php";

// Create signature
$string = "total_amount={$amount},transaction_uuid={$tx_uuid},product_code=EPAYTEST";
$signature = base64_encode(hash_hmac('sha256', $string, '8gBm/:&EnhH.1/q', true));
?>

<form id="esewaForm" action="https://epay.esewa.com.np/epay/main" method="POST">
  <input type="hidden" name="amount" value="<?= $amount ?>">
  <input type="hidden" name="tax_amount" value="0">
  <input type="hidden" name="total_amount" value="<?= $amount ?>">
  <input type="hidden" name="transaction_uuid" value="<?= $tx_uuid ?>">
  <input type="hidden" name="product_code" value="EPAYTEST">
  <input type="hidden" name="product_service_charge" value="0">
  <input type="hidden" name="product_delivery_charge" value="0">
  <input type="hidden" name="success_url" value="<?= $success ?>">
  <input type="hidden" name="failure_url" value="<?= $failure ?>">
  <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
  <input type="hidden" name="signature" value="<?= $signature ?>">
</form>
<script>
  document.getElementById("esewaForm").submit();
</script>
