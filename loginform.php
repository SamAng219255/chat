<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

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
		echo '</div>';
	}
?>

<div id="cphold">
<div id="lcp" class="cp"><form class="loginform" action="./?page=3" method="post">
	Username:<br>
	<?php $srnm=''; if(isset($_GET['username'])) { $srnm=$_GET['username']; } echo '<input type="text" name="username" value="'.$srnm.'" required maxlength=16>'; ?><br>
	Password:<br>
	<input type="password" name="password" required maxlength=16><br>
	<input type="submit" value="Login"><br>
</form></div>
<div id="rcp" class="cp"><form class="loginform" action="./?page=4" method="post">
        Username:<br>
        <?php $srnm=''; if(isset($_GET['username'])) { $srnm=$_GET['username']; } echo '<input type="text" name="username" value="'.$srnm.'" required maxlength=16>'; ?><br>
        Password:<br>
        <input type="password" name="password" required maxlength=16><br>
        Retype Password:<br>
        <input type="password" name="password2" required maxlength=16><br>
        <input type="submit" value="Register"><br>
</form></div>
</div>
