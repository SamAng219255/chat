<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<form action="./?page=3" method="post">
	Username:<br>
	<input type="text" name="username"><br>
	Password:<br>
	<input type="password" name="password"><br>
	<input type="hidden" name="status" value="verification"><br>
	<input type="submit" value="Login"><br>
</form>
