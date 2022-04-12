<?php

session_start();
require 'db.php';
if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
	$place=0;
	if($_POST['page']==2) {
		$place=1;
	}
	elseif($_POST['page']==8) {
		$place=intval($_POST['room']);
	}
	$sql="UPDATE `chat`.`users` SET `laston`=CURRENT_TIMESTAMP, `active`=".$place." WHERE `username`='".$_SESSION['username_chat']."'";
	mysqli_query($conn,$sql);
	$_SESSION['last_active_chat']=time();
}
?>
