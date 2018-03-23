<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=4">';};?>

<?php
	if($_POST['username']!='' && $_POST['password']!='' && $_POST['password2']!='') {
		if($_POST['password']==$_POST['password2']) {
			$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
			require 'db.php';
			$query="SELECT `username` from `chat`.`users` where username='".addslashes($_POST['username'])."';";
			//echo $query.'<br>';
			var_dump(mysqli_query($conn,$query));
			if(mysqli_query($conn,$query)->num_rows<1) {
				$sql="INSERT INTO `chat`.`users` (`id`, `username`, `password`, `quirks`, `pending`,`ip`) VALUES (0,'".addslashes($_POST['username'])."','".$hashed."','E','','".$_SERVER['REMOTE_ADDR']."')";
				echo $sql;
				if(mysqli_query($conn,$sql)) {
					require 'loginscript.php';
				}
				else {
					echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=4&username='.$_POST['username'].'">';
				}
			}
			else {
				echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=2&username='.$_POST['username'].'">';
			}
		}
		else {
			echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=0&username='.$_POST['username'].'">';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=1&username='.$_POST['username'].'">';
	}
?>
