<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		require 'db.php';
		$query="SELECT `username`,`password` from `chat`.`users` where username='".addslashes($_POST['username'])."';";
		$queryresult=mysqli_query($conn,$query);
		if($queryresult->num_rows>0) {
			if(password_verify($_POST['password'],mysqli_fetch_row($queryresult)[1])) {
				require 'loginscript.php';
			}
			else {
				echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=3&username='.$_POST['username'].'">';
			}
		}
		else {
			echo '<meta http-equiv="refresh" content="0; URL=./?p=login&error=3&username='.$_POST['username'].'">';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?p=login">';
	}
?>
