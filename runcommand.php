<?php
session_start();
require 'db.php';
require 'notify.php';
/*$_POST['text'],$_SESSION['username_chat'],$_SESSION['room']*/

$command=explode(" ",$_POST['text']);

$adminquery="SELECT `permissions` FROM `chat`.`users` WHERE `username`='".$_SESSION["username"]."';";
$isadmin=mysqli_fetch_row(mysqli_query($conn,$adminquery))[0]==1;

if($command[0]=="/invite") {
	if(count($command)>=2) {
		$roomquery="SELECT `id`,`users`,`owner`,`joinrestriction`,`name` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$row=mysqli_fetch_row($roomqueryresult);
		if($row[3]<3 || strtolower($row[2])==strtolower($_SESSION['username_chat'])) {
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$row[1].json_decode('"\u001D"').strtolower(addslashes($command[1]))."' WHERE `id`=".$_SESSION['room'].";";
			notify($command[1],'You have been invited to '.$row[4].'.',$conn);
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
	array_splice($temp,array_search($_SESSION['username_chat'],$temp),1);
	$newuser="";
	for($i=0; $i<count($temp); $i++) {
		if($i>0) {
			$newuser.=json_decode('"\u001D"');
		}
		$newuser.=$temp[$i];
	}
	$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$newuser."' WHERE `id`=".$_SESSION['room'].";";
	mysqli_query($conn,$roomsql);
	echo '<script>window.location="./?p=general";</script>';
}
elseif($command[0]=="/kick") {
	if(count($command)>=2) {
		$roomquery="SELECT `id`,`users`,`owner` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$row=mysqli_fetch_row($roomqueryresult);
		if(strtolower($row[2])==strtolower($_SESSION['username_chat']) || $isadmin) {
			$temp=explode(json_decode('"\u001D"'),$row[1]);
			array_splice($temp,array_search($command[1],$temp),1);
			$newuser="";
			for($i=0; $i<count($temp); $i++) {
			        if($i>0) {
					$newuser.=json_decode('"\u001D"');
				}
				$newuser.=$temp[$i];
			}
			$roomsql="UPDATE `chat`.`chatrooms` SET `users`='".$newuser."' WHERE `id`=".$_SESSION['room'].";";
			notify($command[1],'<script>window.location="./?p=general";</script>',$conn);
			if(mysqli_query($conn,$roomsql)) {
				echo '<p>'.htmlspecialchars($command[1]).' has been removed from the chat room.</p>';
			}
			else {
				echo '<p>An unknown error has occured.</p>';
			}
		}
		else {
			echo '<p>This command can only be used by the room owner.</p>';
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
		if(strtolower($row[1])==strtolower($_SESSION['username_chat']) || $isadmin) {
			if($command[1]=="delete") {
				$roomsql="UPDATE `chat`.`users` SET `pending`=CONCAT('<script>window.location=\"./?p=general\"</script>".json_decode('"\u001D"')."',`pending`) WHERE `active`=".$_SESSION['room'].";";
				mysqli_query($conn,$roomsql);
				$deletesql="DELETE FROM `chat`.`chatrooms` WHERE `id`=".$_SESSION['room'].";";
				mysqli_query($conn,$deletesql);
				$deletesql="DELETE FROM `chat`.`privchatroom` WHERE `room`=".$_SESSION['room'].";";
				mysqli_query($conn,$deletesql);
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
			echo '<p>This command can only be used by the room owner.</p>';
		}
	}
	else {
		echo '<p>Not enough arguments given.</p>';
		echo '<p>Syntax: /room &lt;delete|passcode&gt; ...</p>';
	}
}
elseif($command[0]=="/bot") {
	if(count($command)>1) {
		if($command[1]=="add") {
			$roomquery="SELECT `id`,`owner` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
			$roomqueryresult=mysqli_query($conn,$roomquery);
			$row=mysqli_fetch_row($roomqueryresult);
			if(strtolower($row[1])==strtolower($_SESSION['username_chat']) || $isadmin) {
				if(count($command)>2) {
					$sql="INSERT INTO `chat`.`bots` (`id`,`type`,`room`,`data`) VALUES (0,'".$command[2]."','".$_SESSION['room']."','');";
					if(mysqli_query($conn,$sql)) {
						echo '<p>'.$command[2].' bot created and given id '.mysqli_insert_id($conn).'</p>';
					}
					else {
						echo '<p>Failed to create bot.</p>';
					}
				}
				else {
					echo '<p>Not enough arguments given.</p>';
					echo '<p>Syntax: /bot add &lt;type&gt;</p>';
				}
			}
			else {
				echo '<p>This command can only be used by the room owner.</p>';
			}
		}
		elseif($command[1]=="remove") {
			$roomquery="SELECT `id`,`owner` FROM `chat`.`chatrooms` WHERE `id`='".$_SESSION['room']."';";
			$roomqueryresult=mysqli_query($conn,$roomquery);
			$row=mysqli_fetch_row($roomqueryresult);
			if(strtolower($row[1])==strtolower($_SESSION['username_chat']) || $isadmin) {
				if(count($command)>2) {
					$sql="DELETE FROM `chat`.`bots` WHERE `id`='".$command[2]."' AND `room`='".$_SESSION['room']."';";
					if(mysqli_query($conn,$sql)) {
						echo '<p>Bot deleted.</p>';
					}
					else {
						echo '<p>Failed to delete bot.</p>';
					}
				}
				else {
					echo '<p>Not enough arguments given.</p>';
					echo '<p>Syntax: /bot remove &lt;bot id&gt;</p>';
				}
			}
			else {
				echo '<p>This command can only be used by the room owner.</p>';
			}
		}
		elseif($command[1]=="call") {
			if(count($command)>2) {
				$query="SELECT `type`,`room` FROM `chat`.`bots` WHERE `id`=".$command[2]." AND `room`='".$_SESSION['room']."';";
				$queryresult=mysqli_query($conn,$query);
				if($queryresult && $queryresult->num_rows>0) {
					$row=mysqli_fetch_row($queryresult);
					if($row[1]==$_SESSION['room']) {
						require 'bots.php';
						callbot($command[2],array_slice($command,3),$conn);
					}
					else {
						echo '<p>Bot not found.</p>';
					}
				}
				else {
					echo '<p>Bot not found.</p>';
				}
			}
			else {
				echo '<p>Not enough arguments given.</p>';
				echo '<p>Syntax: /bot call &lt;bot id&gt; &lt;bot arguments...&gt;</p>';
			}
		}
		elseif($command[1]=="list") {
			$query="SELECT `id`,`type`,`created` FROM `chat`.`bots` WHERE `room`=".$_SESSION['room'].";";
			$queryresult=mysqli_query($conn,$query);
			if($queryresult && $queryresult->num_rows>0) {
				echo '<dl>';
				for($i=0; $i<$queryresult->num_rows; $i++) {
					$row=mysqli_fetch_row($queryresult);
					echo '<dt> id: '.$row[0].'</dt>';
					echo '<dd> type: '.$row[1].'</dd>';
					echo '<dd> created: '.$row[2].'</dd>';
				}
				echo '</dl>';
			}
			else {
				echo '<p>There are no bots in this room.</p>';
			}
		}
		else {
			echo '<p>Invalid Argument.</p>';
		}
	}
	else {
		echo '<p>Not enough arguments given.</p>';
		echo '<p>Syntax: /bot &lt;add|remove|call|list&gt; ...</p>';
	}
}
elseif($command[0]=="/help") {
	echo '<dl>
		<dt>/invite</dt><dd>Syntax: /invite &lt;username&gt;</dd><dd>Adds a user to the chatroom.</dd>
		<dt>/leave</dt><dd>Syntax: /leave</dd><dd>Remove yourself from the chatroom.</dd>
		<dt>/kick</dt><dd>Syntax: /kick &lt;username&gt;</dd><dd>Remove another user from the chatroom.</dd>
		<dt>/room</dt><dd>Syntax: /room &lt;delete|passcode&gt; ...</dd><dd>Various room commands.</dd>
		<dt>/bot</dt><dd>Syntax: /bot &lt;add|remove|call|list&gt; ...</dd><dd>Add or Removes a bot from the chat as well as giving input to a bot or listing the current bots.</dd>
		</dl>';
}
else {
	echo '<p>Invalid Command.</p>';
}

?>
