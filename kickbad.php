<?php
session_start();
require 'db.php';

$query="SELECT `username` FROM `chat`.`users` WHERE `username`='".$_SESSION['username']."'";
$queryresult=mysqli_query($conn,$query);

if($queryresult->num_rows==1)  {
	echo "legal";
}
else {
	echo "illegal";
}

?>
