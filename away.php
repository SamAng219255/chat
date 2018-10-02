<?php
session_start();
require 'db.php';
mysqli_query($conn,"UPDATE `chat`.`users` SET `away`=".$_POST['away']." WHERE `username`='".$_SESSION['username']."';")
?>