<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=9">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') {echo '<meta http-equiv="refresh" content="0; URL=./?p=login">';};?>

<?php
	require 'db.php';
	$sql="INSERT INTO `chat`.`chatrooms` (`id`, `owner`, `name`,`joinrestriction`,`passcode`,`users`) VALUES (0,'".$_SESSION['username']."','".addslashes($_POST['name'])."','".addslashes($_POST['joinrestriction'])."','".addslashes($_POST['passcode'])."','".$_SESSION['username']."')";
	echo $sql.'<br>';
	var_dump(mysqli_query($conn,$sql));
	$query="INSERT INTO `chat`.`privchatroom` (`id`,`username`,`content`,`room`) VALUES (0,'INFO','Chat Room created with id: ".mysqli_insert_id($conn).".','".mysqli_insert_id($conn)."')";
	var_dump(mysqli_query($conn,$query));
	echo '<meta http-equiv="refresh" content="0; URL=./?p=chat&room='.mysqli_insert_id($conn).'">';
?>
