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
$quirkquery="SELECT `quirks`,`username` from `chat`.`users` where username='".$_SESSION['username_chat']."'";
$quirk=mysqli_fetch_row(mysqli_query($conn,$quirkquery))[0];
$text=replacechat($text,$quirk);
$text=addslashes($text);
$srnm=addslashes($_SESSION['username_chat']);
if(trim($text)!="") {
	$sql="INSERT INTO `chat`.`userchatroom` (`id`, `username`, `content`,`recipient`) VALUES (0,'".$srnm."','".trim($text)."','".$_POST["recipient"]."')";
	var_dump(mysqli_query($conn,$sql));
	$onlinequery="SELECT `active` FROM `chat`.`users` WHERE `username`='".$_POST["recipient"]."'";
	$onlinequeryresult=mysqli_fetch_row(mysqli_query($conn,$onlinequery))[0];
	if($onlinequeryresult<0) {
		$pendingquery="SELECT `username`,`pendingpms` FROM `chat`.`users` WHERE `username`='".$_POST["recipient"]."';";
		$pendingqueryresult=mysqli_query($conn,$pendingquery);
		$pendingrow=mysqli_fetch_row($pendingqueryresult);
		$pendingpms=$pendingrow[1];
		if(!in_array($_SESSION['username_chat'],explode(json_decode('"\u001D"'),$pendingpms))) {
			$pendingsql="UPDATE `chat`.`users` SET `pendingpms`='".$_SESSION['username_chat'].json_decode('"\u001D"').$pendingpms."' WHERE `username`='".$_POST["recipient"]."';";
			mysqli_query($conn,$pendingsql);
		}
	}
}

$ipsql="UPDATE `chat`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username_chat']."';";
mysqli_query($conn,$ipsql);

?>

<!--<meta http-equiv="refresh" content="0; URL=./?p=general">-->
