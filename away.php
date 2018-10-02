<?php
session_start();
require 'db.php';
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=='yes') {
	$sql="UPDATE `chat`.`users` SET `away`=".$_POST['away']." WHERE `username`='".$_SESSION['username']."';";
	mysqli_query($conn,$sql);
}
?>