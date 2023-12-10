<?php
session_start();
include("util.php");
include("auth.php");
include("conn.php");
date_default_timezone_set('Africa/Nairobi');
$plan = $_SESSION['plan'];
$email = $_SESSION['email'];
$code = Auth::generateID(6);
$date = date('Y-m-d H:s:i');

// If transaction data is available in the URL 
if (
  !empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) &&
  !empty($_GET['cc']) && !empty($_GET['st'])
) {
  // Get transaction information from URL 
  $item_number = $_GET['item_number'];
  $txn_id = $_GET['tx'];
  $payment_gross = $_GET['amt'];
  $currency_code = $_GET['cc'];
  $payment_status = $_GET['st'];
  if ($plan == "classic") {
    $hours = $_SESSION['hours'];
    $entry_time = $_SESSION['entry_time'];
    $slot_label = $_SESSION['slot_label'];
    $time_out = strtotime($entry_time) + ($hours * 3600);
    Schedule($conn, $slot_label,$plan, $email, $entry_time, date("Y-m-d H:s:i", $time_out), $code);
    logHistory($conn, date('Y-m-d'), $email, $slot_label, date("H:i:s", $entry_time), date("H:i:s", $time_out));
    logTransaction($slot_label, $email, $txn_id, $payment_gross, $date, $plan, $payment_status, $conn);
    header("Location:profile.php");

  }
  if ($plan == "monthly") {
    $slot_label = $_SESSION['slot_label'];
    $time_out = strtotime(date("Y-m-d H:s:i")) + (24 * 3600);
    Schedule($conn, $slot_label,$plan, $email, date("Y-m-d H:s:i"), date("Y-m-d H:s:i", $time_out), $code);
    logHistory($conn,date('Y-m-d'), $email, $slot_label, date("H:i:s", $entry_time), date("H:i:s", $time_out));
    logTransaction($slot_label, $email, $txn_id, $payment_gross, $date, $plan, $payment_status, $conn);
    header("Location:profile.php");

  }
  if ($plan == "hourly") {
    $hours = $_SESSION['hours'];
    $slot_label = $_SESSION['slot_label'];
    $time_out = strtotime(date("Y-m-d H:s:i")) + ($hours * 3600);
    Schedule($conn, $slot_label,$plan, $email, date("Y-m-d H:s:i"), date("Y-m-d H:s:i", $time_out), $code);
    logHistory($conn, date('Y-m-d'), $email, $slot_label, date("H:i:s"), date("H:i:s", $time_out));
    logTransaction($slot_label, $email, $txn_id, $payment_gross, $date, $plan, $payment_status, $conn);
    header("Location:profile.php");

  }
  if ($plan == "penalty") {
    $info = getUserSlotByEmail($conn, $email);
    if(count($info)>0){
      $ocode=$info["code"];
      $time_out = strtotime(date("Y-m-d H:s:i"))+10*60;
      freePenalty($conn, $email, date('Y-m-d H:i:s',$time_out), $ocode);
      logTransaction($info['slot'], $email, $txn_id, $payment_gross, $date, $plan, $payment_status, $conn);
      header("Location:profile.php");
    }
    else{
      echo("<h1>Not valid</h1>");
    }
  }
}

