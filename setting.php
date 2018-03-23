<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=7">';};?>

<?php

require 'db.php';

if(isset($_POST['txtcolor'])) {
	if(isset($_POST['reset'])) {
		$sql="UPDATE `chat`.`users` SET txtcolor='ABA319', bckcolor='1C1E06' WHERE username='".$_SESSION['username']."';";
	}
	else {
		$sql="UPDATE `chat`.`users` SET txtcolor='".ltrim($_POST['txtcolor'],'#')."', bckcolor='".ltrim($_POST['bckcolor'],'#')."' WHERE username='".$_SESSION['username']."';";
	}
	mysqli_query($conn,$sql);
}

?>

<div id="settingbox">
	<h1>Settings</h1>
	<hr>
	<p>Text color:</p>
	<?php
	$query="SELECT `txtcolor`,`bckcolor` from `chat`.`users` where username='".$_SESSION['username']."';";
	$queryresult=mysqli_fetch_row(mysqli_query($conn,$query));
	echo '	<form method="post">
			<ul style="list-style-type: none;"><li>Foreground:
				<input type="color" name="txtcolor" value="#'.$queryresult[0].'">
			</li><br><li>Background:
				<input type="color" name="bckcolor" value="#'.$queryresult[1].'">
			</li><br><li>
				<input type="submit" value="change">
				<input type="submit" name="reset" value="reset">
			</li></li>
		</form>
	'; ?>
</div>
