<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';};?>
<?php if(!isset($_SESSION['loggedin_chat']) || $_SESSION['loggedin_chat']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<?php
require 'db.php';
$roomquery="SELECT `id`,`owner`,`users`,`joinrestriction`,`name`,`passcode` FROM `chat`.`chatrooms` WHERE `id`='".addslashes($_GET['room'])."';";
$roomqueryresult=mysqli_query($conn,$roomquery);
$roomrow=mysqli_fetch_row($roomqueryresult);
if(Is_Numeric($_GET['room'])) {
	$_SESSION['room']=$_GET['room'];
}
if($roomqueryresult->num_rows<1) {
	echo '<meta http-equiv="refresh" content="0; URL=./?p=browse">';
}
elseif(strtolower($_SESSION['username_chat'])==strtolower($roomrow[1]) || in_array(strtolower($_SESSION['username_chat']),explode(json_decode('"\u001D"'),$roomrow[2]))) {
	require 'room.php';
}
else {
	echo '<div class="cntscr" style="visibility:visible;">';
	echo '<h3>You are not a member of this chatroom.</h3>';
	echo '<p>This is the screen for "'.$roomrow[4].'", id: '.$_GET['room'].'.</p>';
	echo '<p>The owner of this chatroom is '.$roomrow[1].'.</p><br>';
	if($roomrow[3]==0) {
		echo '<p>Would you like to join this room?</p><br>';
		echo '<form method="post"><input type="hidden" name="usersub" value="'.$_SESSION['username_chat'].'"><input type="submit" value="Join"></form>';
		if(isset($_POST['usersub'])) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$roomrow[2].json_decode('"\u001D"').strtolower($_SESSION['username_chat'])."' WHERE `id`=".$_SESSION['room'].";";
			mysqli_query($conn,$roomsql);
			echo '<meta http-equiv="refresh" content="0; URL=./?p=chat&room='.$_GET['room'].'">';
		}
	}
	elseif($roomrow[3]==1) {
		echo '<p>This room is protected by a passcode.</p>';
		echo '<p>Please enter the passcode if you would like to join.</p>';
		echo '<form method="post"><input type="text" name="passcode" required><input type="hidden" name="usersub" value="'.$_SESSION['username_chat'].'"><input type="submit" value="Join"></form>';
		if(isset($_POST['usersub']) && $_POST['passcode']==$roomrow[5]) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$roomrow[2].json_decode('"\u001D"').strtolower($_SESSION['username_chat'])."' WHERE `id`=".$_SESSION['room'].";";
			mysqli_query($conn,$roomsql);
			echo '<meta http-equiv="refresh" content="0; URL=./?p=chat&room='.$_GET['room'].'">';
		}
	}
	elseif($roomrow[3]==2) {
		echo '<p>This room is invite only.</p>';
		echo '<p>You must be granted access from someone already in the room to join.</p>';
	}
	elseif($roomrow[3]==3) {
		echo '<p>This room is invite only.</p>';
		echo '<p>You must be granted access from the owner to join.</p>';
	}
	echo '</div>';
}
?>
