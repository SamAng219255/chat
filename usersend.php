<meta charset="utf-8">
<?php //if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';};?>

<?php

if(session_status() == PHP_SESSION_NONE) {
	session_start();
}

require 'replace.php';
require 'notify.php';

//var_dump($_POST);
//echo "<br>";



require 'db.php';
$text=$_POST['text'];
$quirkquery="SELECT `quirks`,`username` from `chat`.`users` where username='".$_SESSION['username']."'";
$quirk=mysqli_fetch_row(mysqli_query($conn,$quirkquery))[0];
$text=replacechat($text,$quirk);
$text=addslashes($text);
$srnm=addslashes($_SESSION['username']);
if(trim($text)!="") {
	$sql="INSERT INTO `chat`.`userchatroom` (`id`, `username`, `content`,`recipient`) VALUES (0,'".$srnm."','".trim($text)."','".$_POST["recipient"]."')";
	//echo $sql;
	var_dump(mysqli_query($conn,$sql));
}

$ipsql="UPDATE `chat`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username']."';";
mysqli_query($conn,$ipsql);

?>

<!--<meta http-equiv="refresh" content="0; URL=./?p=general">-->
