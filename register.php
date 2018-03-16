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
				$sql="INSERT INTO `chat`.`users` (`id`, `username`, `password`, `quirks`, `pending`) VALUES (0,'".addslashes($_POST['username'])."','".$hashed."','E','')";
				echo $sql;
				if(mysqli_query($conn,$sql)) {
					require 'loginscript.php';
				}
				else {
					//echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=3&username='.$_POST['username'].'">';
				}
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
