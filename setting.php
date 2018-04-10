<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?p=settings">';};?>

<title>Settings</title>

<?php

require 'db.php';

if(isset($_POST['txtcolor'])) {
	if(isset($_POST['reset'])) {
		$sql="UPDATE `chat`.`users` SET txtcolor='ABA319', bckcolor='1C1E06' WHERE username='".$_SESSION['username']."';";
	}
	else {
		$seemove='0';
		if(isset($_POST['leftjoinvisible']) && $_POST['leftjoinvisible']=='on') {
			$seemove='1';
		}
		$sql="UPDATE `chat`.`users` SET txtcolor='".ltrim($_POST['txtcolor'],'#')."', bckcolor='".ltrim($_POST['bckcolor'],'#')."', seemove='".$seemove."' WHERE username='".$_SESSION['username']."';";
	}
	mysqli_query($conn,$sql);
}

?>

<div id="settingbox">
	<form method="post">
	<h1>Settings</h1>
	<hr>
	<?php
	$query="SELECT `txtcolor`,`bckcolor`,`seemove` from `chat`.`users` where username='".$_SESSION['username']."';";
	$queryresult=mysqli_fetch_row(mysqli_query($conn,$query));
	$seemove='';
	if($queryresult[2]==1) {
		$seemove='checked';
	}
	echo '
		<div>
			Text color:<br>
			Foreground:<input type="color" name="txtcolor" value="#'.$queryresult[0].'" id="txtcolor">
			Background:<input type="color" name="bckcolor" value="#'.$queryresult[1].'" is="bckcolor"><br><br>
			<!--Left/Joined messages visible: <input type="checkbox" name="leftjoinvisible" '.$seemove.'><br><br>--><br><br>
		</div>
	'; ?>
	<input type="submit" value="Save" style="float:right; width:50px; height: 37px; border-radius:0px;">
	</form>
	<form><input type="hidden" value="settings" name="p"><input type="hidden" value="replace" name="place"><input type="submit" value="Text Replace Settings"></form>
</div>
