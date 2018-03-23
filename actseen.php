<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=='yes') {
	if(isset($_SESSION['seen'])) {
		if($_SESSION['seen']!=$_POST['seen']) {
			echo 'wrong';
		}
	}
	$_SESSION['seen']=$_POST['seen'];
}
else {
	echo 'don\'t';
}

?>
