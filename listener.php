<?php
include("conn.php");
include("util.php");
$Gsdb=getGateStatus($conn);
$A_status=$_POST['A_S'];
$A_gate_status=$_POST['A_G'];
$B_status=$_POST['B_S'];
$B_gate_status=$_POST['B_G'];
$M_gate_status=$_POST['M_G'];
$slotsinfo=getSlotsInfo($conn);
$Gsdb=getGateStatus($conn);
$Asdb="";
$AGdb="";
$Bsdb="";
$BGdb="";
for ($i=0; $i <count($slotsinfo) ; $i++) { 
   if ($slotsinfo[$i]['slot_label']=="slotA") {
     $AGdb=$slotsinfo[$i]['gate'];
     $Asdb=$slotsinfo[$i]['status'];
   }
   if ($slotsinfo[$i]['slot_label']=="slotB") {
    $BGdb=$slotsinfo[$i]['gate'];
    $Bsdb=$slotsinfo[$i]['status'];
  }
}
$response=trim($Gsdb.",".$AGdb.",".$Asdb.",".$BGdb.",".$Bsdb);
insert_parkinfo($conn,$M_gate_status,$A_gate_status,$B_gate_status); 
echo $response;
exit;
?>