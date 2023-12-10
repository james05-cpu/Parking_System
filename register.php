<?php
include('conn.php');
include('auth.php');
session_start();
     $name=SQLite3::escapeString($_POST['name']);
     $email=SQLite3::escapeString($_POST['email']);
     $pass=hash('sha256', SQLite3::escapeString($_POST['password']));
$users = $conn->query("SELECT COUNT(*) as count FROM Users where email= '$email'");
$itusers = $users->fetchArray();
$num = $itusers['count'];
if($num>0){
echo ('exist');
exit;
}
    $_SESSION["email"]=$email;
    $stm=$conn->prepare("INSERT INTO `Users` (fname, email,password) VALUES(:1,:2,:3)");
    $stm->bindValue(':1',$name);
    $stm->bindValue(':2',$email);
    $stm->bindValue(':3',$pass);
    $stm->execute();
   echo "success";
   exit;
?>