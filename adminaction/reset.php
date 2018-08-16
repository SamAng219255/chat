<?php
	$psswrd='';
	if(isset($_POST['nwpsswrd'])) {
		$psswrd = $_POST['nwpsswrd'];
	}
	else {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRXTUVWXYZ0123456789_!';
		$max = strlen($characters) - 1;
		for ($i = 0; $i < 8; $i++) {
			$psswrd .= $characters[mt_rand(0, $max)];
		}
	}
	require "../db.php";
	$sql="UPDATE `chat`.`users` SET `password`='".password_hash($psswrd,PASSWORD_DEFAULT)."' WHERE `username`='".addslashes($_GET["target"])."';";
	mysqli_query($conn,$sql);
	echo "The password of ".$_GET["target"]." is now:\n".$psswrd;
?>
<form method="post">
	<p>You can also manually set their new password.</p>
	<input type="text" name="nwpsswrd">
	<input type="submit" value="set">
</form>
