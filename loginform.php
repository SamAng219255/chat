<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<title>Login</title>

<?php
	if(isset($_GET['error'])) {
		echo '<div id="errorbox">';
		if($_GET['error']==0) {
			echo 'Passwords do not match.';
		}
		elseif($_GET['error']==1) {
			echo 'Username or Password missing.';
		}
		elseif($_GET['error']==2) {
			echo 'Username is taken.';
		}
		elseif($_GET['error']==3) {
			echo 'Username or Password incorrect.';
		}
		else {
			echo 'Unknown Error.';
		}
		echo '</div>';
	}
?>

<div id="cphold">
<div id="lcp" class="cp"><form class="loginform" action="./?page=3" method="post">
	Username:<br>
	<?php $srnm=''; if(isset($_GET['username'])) { $srnm=$_GET['username']; } echo '<input type="text" name="username" value="'.addslashes($srnm).'" required maxlength=16 autocomplete="username">'; ?><br>
	Password:<br>
	<input type="password" name="password" required maxlength=16 autocomplete="current-password"><br>
	<input type="submit" value="Login"><br>
</form></div>
<div id="rcp" class="cp"><form class="loginform" action="./?page=4" method="post">
        Username:<br>
        <?php $srnm=''; if(isset($_GET['username'])) { $srnm=$_GET['username']; } echo '<input type="text" name="username" value="'.addslashes($srnm).'" required maxlength=16 autocomplete="username" pattern="([A-Za-z0-9_\-*ᚠ-᛭<>@])+" title="Can only can letters, numbers, underscores, hyphens, asterisks, greater/less than signs, @ signs, and runes.">'; ?><br>
        Password:<br>
        <input type="password" name="password" required maxlength=16 autocomplete="new-password"><br>
        Retype Password:<br>
        <input type="password" name="password2" required maxlength=16 autocomplete="new-password"><br>
        <input type="submit" value="Register"><br>
</form></div>
</div>
