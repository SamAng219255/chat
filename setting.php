<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=7">';};?>

<?php

require 'db.php';

if(isset($_POST['txtcolor'])) {
	$sql="UPDATE `chat`.`users` SET txtcolor='".ltrim($_POST['txtcolor'],'#')."' WHERE username='".$_SESSION['username']."';";
	mysqli_query($conn,$sql);
}
elseif(isset($_POST['bckcolor'])) {
	$sql="UPDATE `chat`.`users` SET bckcolor='".ltrim($_POST['bckcolor'],'#')."' WHERE username='".$_SESSION['username']."';";
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
	echo '<ul>
		<li><form method="post">Foreground:
			<input type="color" name="txtcolor" value="#'.$queryresult[0].'">
			<input type="submit" value="change">
		</form></li>
		<li><form method="post">Background:
			<input type="color" name="bckcolor" value="#'.$queryresult[1].'">
			<input type="submit" value="change">
		</form></li>
	</ul>'; ?>
</div>
