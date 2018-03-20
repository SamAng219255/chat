<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?page=1">'; };?>

<?php
require 'db.php';
$roomquery="SELECT `id`,`owner`,`users`,`joinrestriction`,`name`,`passcode` FROM `chat`.`chatrooms` WHERE `id`='".addslashes($_GET['room'])."';";
$roomqueryresult=mysqli_query($conn,$roomquery);
$row=mysqli_fetch_row($roomqueryresult);
if(Is_Numeric($_GET['room'])) {
	$_SESSION['room']=$_GET['room'];
}
if($roomqueryresult->num_rows<1) {
	echo '<meta http-equiv="refresh" content="0; URL=./?page=10">';
}
elseif(strtolower($_SESSION['username'])==strtolower($row[1]) || in_array(strtolower($_SESSION['username']),explode(json_decode('"\u001D"'),$row[2]))) {
	require 'room.php';
}
else {
	echo '<div class="cntscr" style="visibility:visible;">';
	echo '<h3>You are not a member of this chatroom.</h3>';
	echo '<p>This is the screen for "'.$row[4].'", id: '.$_GET['room'].'.</p>';
	echo '<p>The owner of this chatroom is '.$row[1].'.</p><br>';
	if($row[3]==0) {
		echo '<p>Would you like to join this room?</p><br>';
		echo '<form method="post"><input type="hidden" name="usersub" value="'.$_SESSION['username'].'"><input type="submit" value="Join"></form>';
		if(isset($_POST['usersub'])) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$row[2].json_decode('"\u001D"').strtolower($_SESSION['username'])."' WHERE `id`=".$_SESSION['room'].";";
			mysqli_query($conn,$roomsql);
			echo '<meta http-equiv="refresh" content="0; URL=./?page=8&room='.$_GET['room'].'">';
		}
		echo $row[2];
		echo "<br>";
		//var_dump(explode(json_decode('"\u001D"'),$row[2]));
	}
	elseif($row[3]==1) {
		echo '<p>This room is protected by a passcode.</p>';
		echo '<p>Please enter the passcode if you would like to join.</p>';
		echo '<form method="post"><input type="text" name="passcode" required><input type="hidden" name="usersub" value="'.$_SESSION['username'].'"><input type="submit" value="Join"></form>';
		if(isset($_POST['usersub']) && $_POST['passcode']==$row[5]) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$row[2].json_decode('"\u001D"').strtolower($_SESSION['username'])."' WHERE `id`=".$_SESSION['room'].";";
			mysqli_query($conn,$roomsql);
			echo '<meta http-equiv="refresh" content="0; URL=./?page=8&room='.$_GET['room'].'">';
		}
	}
	elseif($row[3]==2) {
		echo '<p>This room is invite only.</p>';
		echo '<p>You must be granted access from someone already in the room to join.</p>';
	}
	elseif($row[3]==3) {
		echo '<p>This room is invite only.</p>';
		echo '<p>You must be granted access from the owner to join.</p>';
	}
	echo '</div>';
}
?>
