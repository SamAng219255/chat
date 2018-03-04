<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<div id="cphold">
<div id="lcp" class="cp"><form class="loginform" action="./?page=3" method="post">
	Username:<br>
	<input type="text" name="username"><br>
	Password:<br>
	<input type="password" name="password"><br>
	<input type="hidden" name="status" value="verification"><br>
	<input type="submit" value="Login"><br>
</form></div>
<div id="rcp" class="cp"><form class="loginform" action="./?page=4" method="post">
        Username:<br>
        <input type="text" name="username"><br>
        Password:<br>
        <input type="password" name="password"><br>
        Retype Password:<br>
        <input type="password" name="password"><br>
        <input type="hidden" name="status" value="verification"><br>
        <input type="submit" value="Register"><br>
</form></div>
</div>
