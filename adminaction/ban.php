<?php
	require '../db.php';
	require '../notify.php';
	$sql="UPDATE `chat`.`users` SET `permissions`=-1 WHERE `username`='".$_GET['target']."';";
	mysqli_query($conn,$sql);
	notify($_GET['target'],'<script>location.reload()</script>',$conn);
	echo $_GET['target']." has been banned.";
?>
