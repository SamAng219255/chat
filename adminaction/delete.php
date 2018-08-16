<?php
	require '../db.php';
	$sql="DELETE FROM `chat`.`users` WHERE `username`='".$_GET['target']."';";
	mysqli_query($conn,$sql);
	echo $_GET['target']." has been deleted.";
?>
