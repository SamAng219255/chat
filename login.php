<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
		echo 'Username:<br>'.$_POST['username'].'<br>Password:<br>'.$_POST['password'].'<br>Hashed Password:<br>';
		echo $hashed;
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';
	}
?>
