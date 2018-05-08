<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function notify($who,$what,$conn) {
	$pendingquery="SELECT `username`,`pending` FROM `chat`.`users` WHERE `username`='".addslashes($who)."';";
	$pendingqueryresult=mysqli_query($conn,$pendingquery);
	$pendingrow=mysqli_fetch_row($pendingqueryresult);
	$pendingsql="UPDATE `chat`.`users` SET `pending`='".addslashes($what).json_decode('"\u001D"').$pendingrow[1]."' WHERE `username`='".addslashes($who)."';";
	return mysqli_query($conn,$pendingsql);
}

?>
