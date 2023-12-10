<?php
date_default_timezone_set('Africa/Nairobi');
function getEmptySlots($conn)
{
        $now=date("Y-m-d H:i:s");
        $schedulledA=getActiveSlots($conn);
        $stm = $conn->prepare("SELECT* FROM Slots where `status`='Empty'");
        $res = $stm->execute();
        $emptySlots = array();
        $emp=array();
        $sh_l=array();
        while ($row = $res->fetchArray()) {
                array_push($emptySlots, $row['slot_label']);
        }
        foreach ($schedulledA as $slot) {
                array_push($sh_l,$slot['slot']); 
        }
        if(count($emptySlots)>0){
                for ($i=0; $i <count($emptySlots) ; $i++) { 
                        if(!in_array($emptySlots[$i],$sh_l)){
                         array_push($emp,$emptySlots[$i]);
                        }
                 }
        }
       
        return $emp;
}
function getClassic($conn){
        $av=getEmptySlots($conn);
        $wa=getInwait($conn);
        for ($i=0; $i <count($av) ; $i++) { 
                foreach($wa as $inwait){
                        if($inwait["slot"]==$av[$i]);
                        unset($av[$i]);
                }
        }
        return $av;
}
function getActiveSlots($conn)
{  
        $now=date("Y-m-d H:i:s");
        $stm = $conn->prepare("SELECT* FROM Schedule");
        $res = $stm->execute();
        $activeSlots = array();
        while ($row = $res->fetchArray()) {
                if($row['time_in']<$now && $row['time_out']>$now ){
                        array_push($activeSlots, $row);
                }
        }
        return $activeSlots;
}
function getInwait($conn)
{  
        $now=date("Y-m-d H:i:s");
        $stm = $conn->prepare("SELECT* FROM Schedule");
        $res = $stm->execute();
        $inwaitSlots = array();
        while ($row = $res->fetchArray()) {
                if($row['time_in']>$now && $row['time_out']>$now ){
                        array_push($inwaitSlots, $row);
                }
        }
        return $inwaitSlots;
}

function getUsers($conn)
{
        $stm = $conn->prepare("SELECT* FROM USERS");
        $res = $stm->execute();
        $users = array();
        while ($row = $res->fetchArray()) {
                array_push($users, $row);
        }
        return $users;
}
function getName($conn, $email)
{
        $stm = $conn->prepare("SELECT* FROM USERS where email='$email'");
        $res = $stm->execute();
        $udata = array();
        while ($row = $res->fetchArray()) {
                $udata = $row;
        }
        return $udata['name'];
}
function getHistory($conn)
{
        $stm = $conn->prepare("SELECT* FROM 'History'");
        $res = $stm->execute();
        $history = array();
        while ($row = $res->fetchArray()) {

                array_push($history, $row);
        }
        return $history;
}
function getEnq($conn)
{
        $stm = $conn->prepare("SELECT* FROM 'Enquery'");
        $res = $stm->execute();
        $qs = array();
        while ($row = $res->fetchArray()) {
                array_push($qs, $row);
        }
        return $qs;
}
function getPricing($conn)
{
        $stm = $conn->prepare("SELECT* FROM 'Pricing'");
        $res = $stm->execute();
        $pricing = array();
        while ($row = $res->fetchArray()) {

                array_push($pricing, $row);
        }
        return $pricing;
}
function getCost($conn, $plan)
{
        $stm = $conn->prepare("SELECT* FROM 'Pricing' where plan='$plan'");
        $res = $stm->execute();
        $pricing = array();
        while ($row = $res->fetchArray()) {
                $pricing = $row;
        }
        return $pricing['cost'];
}
function getUserSlot($conn,$code)
{
        $stm = $conn->prepare("SELECT * FROM 'Slots' where code='$code'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                $info = $row;
        }
        return $info;
}
function getScheduledSlot($conn, $email, $code)
{
        $stm = $conn->prepare("SELECT * FROM 'Schedule' where email='$email' AND code='$code'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                $info = $row;
        }
        return $info;
}
function occupySlot($conn, $email, $code, $label)
{
        $stm = $conn->prepare("UPDATE 'Slots' set user=? ,code=? ,status=? ,gate=? where slot_label=?");
        $stm->bindValue(1, $email);
        $stm->bindValue(2, $code);
        $stm->bindValue(3, "Active");
        $stm->bindValue(4, "Open");
        $stm->bindValue(5, $label);
        $stm->execute();
}
function exitSlot($conn,$label)
{
        $stm = $conn->prepare("UPDATE 'Slots' set user=? ,code=? ,status=? ,gate=? where slot_label=?");
        $stm->bindValue(1, "");
        $stm->bindValue(2, "");
        $stm->bindValue(3, "Empty");
        $stm->bindValue(4, "Open");
        $stm->bindValue(5, $label);
        $stm->execute();
}
function openSlot($conn, $code)
{
        $stm = $conn->prepare("UPDATE 'Slots' set gate=? where code=?");
        $stm->bindValue(1, "Open");
        $stm->bindValue(2, $code);
        $stm->execute();
}
function openPark($conn)
{
        $stm = $conn->prepare("UPDATE 'Gate' set g_status=?");
        $stm->bindValue(1, "Open");
        $stm->execute();
}
function insert_parkinfo($conn, $main_gate, $slotA_gs, $slotB_gs)
{
        $stm = $conn->prepare("UPDATE 'Slots' set gate=? where slot_label='slotA'");
        $stm->bindValue(1, $slotA_gs);
        $stm->execute();
        $stm = $conn->prepare("UPDATE 'Slots' set gate=? where slot_label='slotB'");
        $stm->bindValue(1, $slotB_gs);
        $stm->execute();
        $stm = $conn->prepare("UPDATE Gate set g_status=? ");
        $stm->bindValue(1, $main_gate);
        $stm->execute();
}
function getGateStatus($conn)
{
        $stm = $conn->prepare("SELECT * FROM 'Gate'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                $info = $row;
        }
        return $info['g_status'];
}
function getSlotsInfo($conn)
{
        $stm = $conn->prepare("SELECT * FROM 'Slots'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                array_push($info, $row);
        }
        return $info;
}
function logHistory($conn, $date, $user, $slot, $time_in, $time_out)
{
        $stm = $conn->prepare("INSERT into `History` (date,slot,user_email,time_in,time_out) values(?,?,?,?,?)");
        $stm->bindValue(1, $date);
        $stm->bindValue(2, $slot);
        $stm->bindValue(3, $user);
        $stm->bindValue(4, $time_in);
        $stm->bindValue(5, $time_out);
        $stm->execute();
}
function logTransaction($slot_label, $user, $tx_id, $amount, $date, $plan, $status, $conn)
{
        $stm = $conn->prepare("INSERT INTO `Payments` (tx_id,amount,plan,email,date,status,slot_label) values(?,?,?,?,?,?,?)");
        $stm->bindValue(1, $tx_id);
        $stm->bindValue(2, $amount);
        $stm->bindValue(3, $plan);
        $stm->bindValue(4, $user);
        $stm->bindValue(5, $date);
        $stm->bindValue(6, $status);
        $stm->bindValue(7, $slot_label);
        $stm->execute();
}
function getTransactions($conn)
{
        $stm = $conn->prepare("SELECT* FROM 'Payments'");
        $res = $stm->execute();
        $payments = array();
        while ($row = $res->fetchArray()) {
                array_push($payments, $row);
        }
        return $payments;
}
function Schedule($conn, $slot,$plan, $email, $time_in, $time_out, $code)
{
        $stm = $conn->prepare("INSERT INTO `Schedule` (slot,email,time_in,time_out,code,plan) values(?,?,?,?,?,?)");
        $stm->bindValue(1, $slot);
        $stm->bindValue(2, $email);
        $stm->bindValue(3, $time_in);
        $stm->bindValue(4, $time_out);
        $stm->bindValue(5, $code);
        $stm->bindValue(6, $plan);

        $stm->execute();
}
function getScheduledSlotByEmail($conn, $email)
{
        $stm = $conn->prepare("SELECT * FROM 'Schedule' where email='$email'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                $info = $row;
        }
        return $info;
}
function getUserSlotByEmail($conn,$email)
{
        $stm = $conn->prepare("SELECT * FROM 'Schedule' where email='$email'");
        $res = $stm->execute();
        $info = array();
        while ($row = $res->fetchArray()) {
                $info = $row;
        }
        return $info;
}
function freePenalty($conn, $email,$time_out,$ocode)
{
        $stm = $conn->prepare("UPDATE 'Schedule' set time_out='$time_out' where email='$email' and code='$ocode'");
        $stm->execute();
}
?>