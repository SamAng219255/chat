<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=3">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$servername="127.0.0.1";
		$username="chatter";
		$password="GeArᛈᚨᛊᚹᚱᛥ";
		$conn = mysqli_connect($servername, $username, $password);
		$query="SELECT `username`,`password` from `chat`.`users` where username='".str_replace(array("'","\\"),array("\\'","\\\\"),$_POST['username'])."';";
		$queryresult=mysqli_query($conn,$query);
		if($queryresult->num_rows>0) {
			if(password_verify($_POST['password'],mysqli_fetch_row($queryresult)[1])) {
				require 'loginscript.php';
			}
			else {
				echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=3&username='.$_POST['username'].'">';
			}
		}
		else {
			echo '<meta http-equiv="refresh" content="0; URL=./?page=1&error=3&username='.$_POST['username'].'">';
		}
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';
	}
?>
