<?php
session_start();
require 'db.php';
if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
	$sql="UPDATE `chat`.`users` SET `away`=".$_POST['away']." WHERE `username`='".$_SESSION['username_chat']."';";
	mysqli_query($conn,$sql);
}
?>