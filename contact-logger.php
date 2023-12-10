<?php
date_default_timezone_set('Africa/Nairobi');
include('auth.php');
include('util.php');
session_start();
include('conn.php');
     $email=SQLite3::escapeString($_SESSION['email']);
     $sub=SQLite3::escapeString($_POST['subject']);
     $message=SQLite3::escapeString($_POST['message']);
     $id=Auth::generateID(6);
     $current_time = date('Y-m-d H:i:s'); 
     $stm=$conn->prepare("INSERT INTO `Enquery` (quid,email,subject,message,time)VALUES(:1,:2,:3,:4,:5)");
     $stm->bindValue(':1',$id);
     $stm->bindValue(':2',$email);
     $stm->bindValue(':3',$sub);
     $stm->bindValue(':4',$message);
     $stm->bindValue(':5',$current_time);

     $stm->execute();
  echo "success";
?>