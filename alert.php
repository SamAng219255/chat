<?php
	session_start();
	require 'db.php';
	if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
		if(mysqli_fetch_row(mysqli_query($conn,"SELECT `permissions`,`username` FROM `chat`.`users` WHERE `username`='".$_SESSION['username_chat']."'"))[0]>0) {
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