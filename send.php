<meta charset="utf-8">
<?php //if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';};?>

<?php

session_start();

//var_dump($_POST);
//echo "<br>";

require 'db.php';
$text=$_POST['text'];
/*$query="SELECT `quirks` from `chat`.`users` where username='".$_SESSION['username']."'";
echo $query.'<br>';
$quirk=mysqli_fetch_row(mysqli_query($conn,$query))[0];
echo $text."<br>";
$text=shell_exec("./quirks \"".$text."\" \"".$quirk."\"");
echo "./quirks '".$text."' '".$quirk."'<br>";
echo $text.'<br>';*/
$text=addslashes($text);
$srnm=addslashes($_SESSION['username']);
if(trim($text)!="") {
	$sql="INSERT INTO `chat`.`chatroom` (`id`, `username`, `content`) VALUES (0,'".$srnm."','".trim($text)."')";
	//echo $sql;
	var_dump(mysqli_query($conn,$sql));
}

$ipsql="UPDATE `chat`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username']."';";
mysqli_query($conn,$ipsql);

?>

<!--<meta http-equiv="refresh" content="0; URL=./?p=general">-->
