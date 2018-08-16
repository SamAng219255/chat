<?php
	require '../db.php';
	$sql="UPDATE `chat`.`users` SET `permissions`=0 WHERE `username`='".$_GET['target']."';";
	mysqli_query($conn,$sql);
	echo $_GET['target']." has been unbanned.";
?>
