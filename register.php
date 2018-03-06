<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=4">';};?>

<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
		$servername="locahost";
		$username="chatter";
		$password="GeArᛈᚨᛊᚹᚱᛥ";
		$conn = new PDO("mysql:host=localhost;dbname=chat",$username,$password);
		$sql="INSERT INTO users (id, username, password, quirks) VALUES (0,'".$_POST['username']."','".$hashed."','E')";
		$conn->exec($sql);
		echo 'You have successfully created the account: '.$_POST['username'].'.';
	}
	else {
		echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';
	}
?>
