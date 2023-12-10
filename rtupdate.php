<?php
include ("util.php");
include("conn.php");
$type=$_POST["type"];
if($type=="admin"){
 $empty_slots = count(getEmptySlots($conn));
$active_slots = count(getActiveSlots($conn));
$all_slots = $empty_slots + $active_slots;
echo $empty_slots.":".$active_slots.":".$all_slots;
}
if($type=="user"){
    $empty_slots = count(getEmptySlots($conn));
echo $empty_slots;
   }
?>