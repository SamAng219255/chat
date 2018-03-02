<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		echo 'Username:<br>'.$_POST['username'].'<br>Password:<br>'.$_POST['password'].'<br>Hashed Password:<br>'.shell_exec('./passwordhash '.$_POST['password'].' '.strlen($_POST['password']));
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';
	}
?>
