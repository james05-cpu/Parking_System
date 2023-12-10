<?php
include("util.php");
include("conn.php");
session_start();
date_default_timezone_set('Africa/Nairobi');
$current_time = strtotime(date('Y-m-d H:i:s')); 
$emptySlots=getEmptySlots($conn);
$available_classic=getClassic($conn);
$booked_classic=getInwait($conn);

$plan=$_POST["plan"];
if($plan=="hourly"){
    $hours=$_POST["hours"];
    $i=0;
    $slot_label=null;
    for ($i=0; $i <count($booked_classic); $i++) { 
        $gap=strtotime($booked_classic[$i]['time_in'])-$current_time;
        if((($gap/3600)-($hours+1))>=0){
            $slot_label=$booked_classic[$i]["slot"];
            $_SESSION['slot_label']=$slot_label;
        }
    }
    if($slot_label==null){
        if(count($available_classic)>0){
            $slot_label=$available_classic[0];
            $_SESSION["plan"]=$plan;
            $_SESSION['hours']=$hours;
            $_SESSION['slot_label']=$slot_label;
            echo("success");
        }
        exit;
    } 
    if($slot_label==null){
        echo ("fail");
        exit;
    }
    else if($slot_label!=null){
        echo("success");
        exit;
    }
}
if($plan=="classic"){
    $entry_time=$_POST["entry"];
    $hours=$_POST["hours"];
    if(count($available_classic)==0){
        echo("fail");
    } 
    else{
        $slot_label=$available_classic[0];
        $_SESSION['plan']=$plan;
        $_SESSION['hours']=$hours;
        $_SESSION['entry_time']=$entry_time;
        $_SESSION['slot_label']=$slot_label;
        echo ("success");
    }
}
if($plan=="monthly"){
    if(count($available_classic)==0){
        echo ("fail");
    } 
    else{
        $slot_label=$available_classic[0];
        $_SESSION["plan"]=$plan;
        $_SESSION['slot_label']=$slot_label;
        echo ("success");
    }
}
?>