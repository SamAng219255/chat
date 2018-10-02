<?php
session_start();
require 'db.php';
$sql="UPDATE `chat`.`users` SET `away`=".$_POST['away']." WHERE `username`='".$_SESSION['username']."';";
mysqli_query($conn,$sql);
?>