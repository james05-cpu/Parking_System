<?php
date_default_timezone_set('Africa/Nairobi');
session_start();
include('conn.php');
include('util.php');
$email = $_SESSION["email"];
$step = 1;
if (isset($_SESSION['step'])) {
        $step = $_SESSION['step'];
}
$action = SQLite3::escapeString($_POST['action']);
$code = SQLite3::escapeString($_POST['code']);
$info = getScheduledSlot($conn, $email, $code);
if(count($info)>0){
        $time_in = strtotime($info['time_in']);
        $time_out = strtotime($info['time_out']);
        $now = strtotime(date('Y-m-d H:i:s'));
        $plan=$info['time_in'];
        if ($action == "enter") {
                if (count($info) == 0) {
                        echo ('none');
                        exit;
                }
        
                if (( $time_in-$now) > 0) {
                        echo ("wait");
                        exit;
                } else if (($now - $time_out) > 0) {
                        echo ("expired");
                        exit;
                } else {
                        if ($step == 1) {
                                openPark($conn);
                                $_SESSION['step'] = 2;
                                echo ("success");
                                exit;
                        } else {
                                occupySlot($conn, $email,$info['code'] ,$info['slot']);
                                openSlot($conn, $code);
                                unset($_SESSION['step']);
                                echo ("success");
                                exit;
                        }
                }
        } else if ($action == 'exit') {
                if ($step == 1) {
                        $infoS = getUserSlot($conn, $code);
                        if (count($infoS) == 0) {
                                echo ('none');
                                exit;
                        }
                } 
                
                $time_out = strtotime($info['time_out']);
                $now = strtotime(date('Y-m-d H:i:s'));
                if (($now - $time_out) > 0) {
                        echo ("locked");
                        exit;
                } else {
                        if ($step == 1) {
                                //change led status
                                exitSlot($conn,$info['slot']);
                                openSlot($conn, $code);
                                $_SESSION['step'] = 2;
                                echo ('success');
                                exit;
                        } else {
                                openPark($conn);
                                unset($_SESSION['step']);
                                echo ("success");
                                exit;
                        }
                }
        }
}
else if(count($info)==0){
        echo "not found";
}

