<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$firsthalf=mb_substr($_POST['password'],0,8);
		if(strlen($_POST['password'])>8) {
			$seconhalf=mb_substr($_POST['password'],8,16);
		}
		else {
			$seconhalf=mb_substr($_POST['password'],0,8);
		}
		$hashed=mb_substr(shell_exec('openssl passwd '.$firsthalf),0,-1).shell_exec('openssl passwd '.$seconhalf);
		echo 'Username:<br>'.$_POST['username'].'<br>Password:<br>'.$_POST['password'].'<br>Hashed Password:<br>';
		echo $hashed;
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';
	}
?>
