<?php
session_start();
require 'db.php';
require 'notify.php';
/*$_POST['text'],$_SESSION['username'],$_SESSION['room']*/

$command=explode(" ",$_POST['text']);

if($command[0]=="/invite") {
	if(count($command)>=2) {
		$roomquery="SELECT `id`,`users`,`owner`,`joinrestriction`,`name` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$row=mysqli_fetch_row($roomqueryresult);
		if($row[3]<3 || strtolower($row[2])==strtolower($_SESSION['username'])) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$row[1].json_decode('"\u001D"').strtolower(addslashes($command[1]))."' WHERE `id`=".$_SESSION['room'].";";
			notify($command[1],'You have been invited to '.$row[4].'.');
			if(mysqli_query($conn,$roomsql)) {
				echo '<p>'.htmlspecialchars($command[1]).' has been added to the chat room.</p>';
			}
			else {
				echo '<p>An unknown error has occured.</p>';
			}
		}
		else {
			echo '<p>This command can only be used by the owner.</p';
		}
	}
	else {
		echo '<p>Not enough arguments given.</p>';
		echo '<p>Syntax: /invite &lt;username&gt;</p>';
	}
}
elseif($command[0]=="/leave") {
	$roomquery="SELECT `id`,`users` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
	$roomqueryresult=mysqli_query($conn,$roomquery);
	$row=mysqli_fetch_row($roomqueryresult);
	$temp=explode(json_decode('"\u001D"'),$row[1]);
	array_splice($temp,array_search($_SESSION['username'],$temp),1);
	$newuser="";
	for($i=0; $i<count($temp); $i++) {
		if(i>0) {
			$newuser.=json_decode('"\u001D"');
		}
		$newuser.=$temp[i];
	}
	$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$newusers."' WHERE `id`=".$_SESSION['room'].";";
	mysqli_query($conn,$roomsql);
	echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';
}
elseif($command[0]=="/kick") {
	if(count($command)>=2) {
		$roomquery="SELECT `id`,`users`,`owner` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$row=mysqli_fetch_row($roomqueryresult);
		if(strtolower($row[2])==strtolower($_SESSION['username'])) {
			$temp=explode(json_decode('"\u001D"'),$row[1]);
			array_splice($temp,array_search($command[1],$temp),1);
			$newuser="";
			for($i=0; $i<count($temp); $i++) {
			        if(i>0) {
					$newuser.=json_decode('"\u001D"');
				}
				$newuser.=$temp[i];
			}
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$newusers."' WHERE `id`=".$_SESSION['room'].";";
			notify($command[1],'<script>window.location="./?p=general";</script>');
			if(mysqli_query($conn,$roomsql)) {
				echo '<p>'.htmlspecialchars($command[1]).' has been removed from the chat room.</p>';
			}
			else {
				echo '<p>An unknown error has occured.</p>';
			}
		}
		else {
			echo '<p>This command can only be used by the owner.</p>';
		}
	}
	else {
		echo '<p>Not enough arguments given.</p>';
		echo '<p>Syntax: /kick &lt;username&gt;</p>';
	}
}
elseif($command[0]=="/room") {
	if(count($command)>=2) {
		$roomquery="SELECT `id`,`owner` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$row=mysqli_fetch_row($roomqueryresult);
		if(strtolower($row[1])==strtolower($_SESSION['username'])) {
			if($command[1]=="delete") {
				echo '<p>Normally this command should delete the room but I\'m still working out the technical difficulties presented.</p>';
			}
			elseif($command[1]=="passcode") {
				if(count($command)>=3) {
					$roomsql="UPDATE `chat`.`chatrooms` SET `passcode`='".$command[2]."' WHERE `id`=".$_SESSION['room'].";";
					if(mysqli_query($conn,$roomsql)) {
						echo '<p>The passcode has been changed to '.htmlspecialchars($command[2]).'</p>';
					}
					else {
						echo '<p>An unknown error has occured.</p>';
					}
				}
				else {
					echo '<p>Not enough arguments given.</p>';
					echo '<p>Syntax: /room passcode &lt;new passcode&gt;</p>';
				}
			}
			else {
				echo '<p>Invalid Argument.</p>';
			}
		}
		else {
			echo '<p>This command can only be used by the owner.</p>';
		}
	}
	else {
		echo '<p>Not enough arguments given.</p>';
		echo '<p>Syntax: /room &lt;delete|passcode&gt; ...</p>';
	}
}
else {
	echo '<p>Invalid Command.</p>';
}

?>
