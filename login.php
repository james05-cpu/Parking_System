<?php
   session_start(); 
   include('conn.php');
           $email = SQLite3::escapeString($_POST['email']);
           $password =hash('sha256', SQLite3::escapeString($_POST['password']));
   if($email==null || $password==null){
   exit;
   }
   else{
      login($conn,$email,$password);
   }

  function login($conn,$email,$password)
       {
           $query=$conn->query("SELECT COUNT(*) as count FROM `Users` WHERE `email`='$email' AND `password`='$password'");
           $row=$query->fetchArray();
           $count=$row['count'];
    
           if($count > 0){
                   $_SESSION['email']=$email;
                   echo("success");
                   exit;
           }
           else{
               echo "fail";
               exit;
   
      }
    }