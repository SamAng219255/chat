<?php
	session_start();
	require 'db.php';
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=='yes') {
		if(mysqli_fetch_row(mysqli_query($conn,"SELECT `permissions`,`username` FROM `chat`.`users` WHERE `username`='".$_SESSION['username']."'"))[0]>0) {
			require 'notify.php';
			notify($_GET['usr'],$_GET['msg'],$conn);
			echo 'success';
		}
		else {
			echo 'You do not have permission to do that.';
		}
	}
	else {
		echo 'You are not logged in.';
	}
?>