<?php
include("conn.php");
include("util.php");
date_default_timezone_set('Africa/Nairobi');
session_start();
$email=$_SESSION['email'];
if($_POST['type']=="mine"){
    $info=getUserSlotByEmail($conn,$email);
if(count($info)==0){
    echo "You don't have Any";
}
else{
    $now=strtotime(date("Y-m-d H:i:s"));
    $time_in = strtotime($info['time_in']);
$time_out = strtotime($info['time_out']);
if($time_in<$now){
    $durration=($time_out-$now)/3600;

}else{
    $durration=($time_out-$time_in)/3600;

}
$durration=round($durration,3);
if($durration<0){
    echo $info['slot'].":".$info['code'].":"."Expired";

}
else if($durration>0){
    echo $info['slot'].":".$info['code'].":".$durration." hrs";

}
}
}
else if($_POST['type']=="us"){
    $info=getPricing($conn);
echo $info[0]['cost'].":".$info[1]['cost'].":".$info[2]['cost'];
}
?>