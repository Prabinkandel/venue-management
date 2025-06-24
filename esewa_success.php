<?php
session_start();
include("Database/connect.php");

$amt = $_POST['amount'];
$pid = $_POST['transaction_uuid'];
$rid = $_POST['reference_id'];

$fields = http_build_query([
  'amt' => $amt,
  'scd' => 'EPAYTEST',
  'pid' => $pid,
  'rid' => $rid
]);

$ch = curl_init("https://epay.esewa.com.np/epay/transrec");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if (strpos($response, "Success") !== false) {
  // Save booking
  $name = $_SESSION['nm'];
  $email = $_SESSION['email'];
  $mo = $_SESSION['mo'];
  $date = $_SESSION['date'];
  $theme = $_SESSION['theme'];
  $theme_name = $_SESSION['theme_name'];
  $price = $_SESSION['price'];

  $q = mysqli_query($conn, "INSERT INTO booking(nm, email, mo, theme, thm_nm, price, date)
    VALUES ('$name', '$email', '$mo', '$theme', '$theme_name', '$price', '$date')");

  echo "<script>alert('Your Event is Booked via eSewa!'); window.location.href='index.php';</script>";
} else {
  echo "Payment verification failed.";
}
?>
