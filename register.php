<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=4">';};?>

<?php
	if($_POST['username']!='' && $_POST['password']!='' && $_POST['password2']!='') {
		if($_POST['password']==$_POST['password2']) {
			$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
			$servername="127.0.0.1";
			$username="chatter";
			$password="GeArᛈᚨᛊᚹᚱᛥ";
			$conn = mysqli_connect($servername, $username, $password);
			$query="SELECT `username` from `chat`.`users` where username='".$_POST['username']."';";
			//echo $query.'<br>';
			var_dump(mysqli_query($conn,$query));
			if(mysqli_query($conn,$query)->num_rows<1) {
				$sql="INSERT INTO `chat`.`users` (`id`, `username`, `password`, `quirks`) VALUES (0,'".$_POST['username']."','".$hashed."','E')";
				mysqli_query($conn,$sql);
				require 'loginscript.php';
				//echo 'You have successfully created the account: '.$_POST['username'].'.<br>';
				//echo $sql;
			}
			else {
				echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=2&username='.$_POST['username'].'">';
			}
		}
		else {
			echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=0&username='.$_POST['username'].'">';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=1&username='.$_POST['username'].'">';
	}
?>