<?php
include("Database/connect.php");
session_start();

// Fetch theme from temp
$q = mysqli_query($conn, "SELECT * FROM temp LIMIT 1");
$res = mysqli_fetch_array($q);
$im = $res[1];
$nm = $res[2];
$pri = $res[3];

$pid = "EVT" . time(); // Unique ID for transaction
$_SESSION['pid'] = $pid;
$_SESSION['theme'] = $im;
$_SESSION['thm_nm'] = $nm;
$_SESSION['price'] = $pri;

$success_url = "http://localhost/Event-Management-System-master/esewa_success.php";
$fail_url = "http://localhost/Event-Management-System-master/esewa_failed.php";
$merchant_code = "EPAYTEST"; // For sandbox testing
?>

<form action="https://rc.esewa.com.np/epay/main" method="POST">
  <input type="hidden" name="tAmt" value="<?= $pri ?>">
  <input type="hidden" name="amt" value="<?= $pri ?>">
  <input type="hidden" name="txAmt" value="0">
  <input type="hidden" name="psc" value="0">
  <input type="hidden" name="pdc" value="0">
  <input type="hidden" name="scd" value="EPAYTEST">
  <input type="hidden" name="pid" value="<?= $pid ?>">
  <input type="hidden" name="su" value="<?= $success_url ?>">
  <input type="hidden" name="fu" value="<?= $fail_url ?>">
  <input type="submit" value="Pay with eSewa Sandbox">
</form>


