<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=4">';};?>

<?php
	echo PHP_OS;
	if($_POST['username']!='' && $_POST['password']!='' && $_POST['password2']!='') {
		if($_POST['password']==$_POST['password2']) {
			$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
			$servername="127.0.0.1";
			$username="chatter";
			$password="GeArᛈᚨᛊᚹᚱᛥ";
			$conn = mysqli_connect($servername, $username, $password);
			if(!mysqli_query($conn,"SELECT `username` from `chat`.`users` where username='".$_POST['username']."'")) {
				$sql="INSERT INTO `chat`.`users` (`id`, `username`, `password`, `quirks`) VALUES (0,'".$_POST['username']."','".$hashed."','E')";
				mysqli_query($conn,$sql);
				echo 'You have successfully created the account: '.$_POST['username'].'.<br>';
				//echo $sql;
			}
			else {
				echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=2">';
			}
		}
		else {
			echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=0">';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=1">';
	}
?>
