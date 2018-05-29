<?php
require 'db.php';
$adminquery="SELECT `permissions` FROM `chat`.`users` WHERE `username`='".$_SESSION["username"]."';";
$isadmin=mysqli_fetch_row(mysqli_query($conn,$adminquery))[0]==1;

if(isset($_SESSION["loggedin"]) && $isadmin) {



}
else {
  echo '<meta http-equiv="refresh" content="0; URL=./?p=home">';
}
?>
