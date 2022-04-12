<?php
session_start();
require 'db.php';

$query="SELECT `username` FROM `chat`.`users` WHERE `username`='".$_SESSION['username_chat']."'";
$queryresult=mysqli_query($conn,$query);

if(!isset($_SESSION['loggedin_chat']) || $_SESSION['loggedin_chat']!='yes') {
	echo "illegal";
}
elseif($queryresult->num_rows==1)  {
	echo "legal";
}
else {
	echo "illegal";
}

?>
