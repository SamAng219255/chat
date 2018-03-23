<?php
session_start();
require 'db.php';
$oldusers=explode(json_decode('"\u001D"'),$_POST['userlist']);
$usersvisible=array();
$lstmsg="0";
if(isset($_POST['lstmsg'])) {
	$lstmsg=$_POST['lstmsg'];
}
$userquery="SELECT * FROM (SELECT `id`,`username`,`room` FROM `chat`.`privchatroom` WHERE room=".$_SESSION['room']." AND id>".$lstmsg." ORDER BY id DESC) AS `table` ORDER by id ASC;";
$userqueryresult=mysqli_query($conn,$userquery);
if($userqueryresult && $userqueryresult->num_rows>0) {
        for($i=0; $i<$userqueryresult->num_rows; $i++) {
                $row=mysqli_fetch_row($userqueryresult);
                if(!in_array(strtolower($row[1]),$usersvisible) && !in_array(strtolower($row[1]),$oldusers)) {
                        array_push($usersvisible,strtolower($row[1]));
                }
        }
}
$vuCount=count($usersvisible);
for($i=0; $i<$vuCount; $i++) {
        $query="SELECT `txtcolor`,`bckcolor` FROM `chat`.`users` WHERE `username`='".$usersvisible[$i]."'";
        $queryresult=mysqli_query($conn,$query);
        $row=mysqli_fetch_row($queryresult);
        echo "p[user=\"".$usersvisible[$i]."\"] {color:#$row[0];background-color:#$row[1];}\n";
}
if($vuCount>0) {
	echo json_decode('"\u001C"');
}
for($i=0; $i<$vuCount; $i++) {
	echo json_decode('"\u001D"');
	echo $usersvisible[$i];
}
?>
