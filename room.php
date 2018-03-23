<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<?php
require 'db.php';

$roomnamequery="SELECT `id`,`name` FROM `chat`.`chatrooms` WHERE `id`='".addslashes($_GET['room'])."';";
$roomnamequeryresult=mysqli_query($conn,$roomnamequery);
$roomnamerow=mysqli_fetch_row($roomnamequeryresult);
echo '<title>'.$roomnamerow[1].'</title>';
?>

<style id="userlinestyles"></style>

<div id="chatpicker">
<a href="./?p=general">General</a>
<?php
	$roomid=intval($_GET['room']);
	$_SESSION['room']=$roomid;
	$query="SELECT `id`,`owner`,`name` FROM `chat`.`chatrooms` WHERE `owner`='".$_SESSION['username']."';";
	$queryresult=mysqli_query($conn,$query);
	for($i=0; $i<$queryresult->num_rows; $i++) {
		$row=mysqli_fetch_row($queryresult);
		echo '<a href="./?p=chat&room='.$row[0].'">'.$row[2].'</a>';
	}
	$query="SELECT * FROM `chat`.`chatrooms` WHERE NOT `owner`='".$_SESSION['username']."';";
	$queryresult=mysqli_query($conn,$query);
	for($i=0; $i<$queryresult->num_rows; $i++) {
		$row=mysqli_fetch_row($queryresult);
		if(in_array(strtolower($_SESSION['username']),explode(json_decode('"\u001D"'),$row[2]))) {
			echo '<a href="./?p=chat&room='.$row[0].'">'.$row[4].'</a>';
		}
	}
?>
<a onclick="document.getElementById('darken').style='visibility:visible;'; document.getElementById('createroom').style='visibility:visible;';">Create a Private Chat Room</a>
</div>
<div id="username" style="visibility:hidden;"><?php echo $_SESSION['username']; ?></div>
<div id="room">
<div id="textarea">
<?php
	$query="SELECT * FROM (SELECT * FROM `chat`.`privchatroom` WHERE `room`=".$_SESSION['room']." ORDER BY id DESC LIMIT 256) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	//var_dump($queryresult);
	//echo '<br>';
	$lastmsg=-1;
	$usersvisible=array();
	$titles=array();
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$temptime=explode(" ",$row[4]);
			$timesent=$temptime[0];
			if($temptime[0]==date('Y-m-d')) {
				$timesent=$temptime[1];
			}
			$title="";
			$prefix="";
                        $suffix="";
                        if(!array_key_exists(strtolower($row[1]),$titles)) {
                                $titlequery="SELECT `prefix`,`suffix`,`username` FROM `chat`.`users` WHERE `username`='".$row[1]."';";
                                $titlequeryresult=mysqli_query($conn,$titlequery);
                                $titlerow=mysqli_fetch_row($titlequeryresult);
                                $titles[strtolower($row[1])]['pre']=$titlerow[0];
                                $titles[strtolower($row[1])]['suf']=$titlerow[1];
                        }
                        $prefix=$titles[strtolower($row[1])]['pre'];
                        $suffix=$titles[strtolower($row[1])]['suf'];
			if(strtolower($row[1])==strtolower($roomrow[1])) {
				$title="[room owner]";
			}
			echo '<p user="'.strtolower($row[1]).'">['.$timesent.']'.$title.' '.$prefix.$row[1].$suffix.': '.htmlspecialchars($row[2]).'</p>';
			$lastmsg=$row[0];
			if(!in_array(strtolower($row[1]),$usersvisible)) {
				array_push($usersvisible,strtolower($row[1]));
			}
		}
	}
	else {
		echo 'There are no messages.';
	}
	echo '</div>';
	echo '<div id="lastmsg" style="visibility:hidden;">'.$lastmsg.'</div>';
	echo '<div id="visibleusers" style="visibility:hidden;">';
	$vuCount=count($usersvisible);
	for($i=0; $i<$vuCount; $i++) {
		if($i>0) {
			echo json_decode('"\u001D"');
		}
		echo $usersvisible[$i];
	}
	echo '</div>';
?>
<div id="typearea">
	<div>
		<input id="typing" type="text" placeholder="Type here." name="text" onkeypress="return candleManu27s(event)" autocomplete="off" autofocus>
		<button id="subbut" type="submit" onclick="submittxt();">↑</button>
	</div>
</div>
</div>
<script>
element=document.getElementById("textarea");
element.scrollTop = element.scrollHeight;
</script>

<?php
if(isset($_POST['text'])) {
	$text=$_POST['text'];
	$sql="INSERT INTO `chat`.`privchatroom` (`id`, `username`, `content`,`room`) VALUES (0,'".$_SESSION['username']."','".addslashes($text)."',".$_SESSION['room'].")";
	mysqli_query($conn,$sql);
	echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';
}
?>

<script>
$.post('getuserstyles.php', {userlist: document.getElementById("visibleusers").innerHTML}, function(data) {
	$('style#userlinestyles').append(data);
});
</script>

<script>
lstmsg=parseInt(document.getElementById("lastmsg").innerHTML);
srnm=document.getElementById("username").innerHTML;
function updatechatbox() {
	$.post('roompageupdate.php', {last: lstmsg}, function(data) {
		var atbottom=element.scrollTop >= (element.scrollHeight - element.offsetHeight);
		//console.log(data);
		var foo=data.split(/\|(.+)/);
		if(lstmsg<0 && typeof foo[1] != "undefined") {
			$('div#textarea').text("");
		}
		$.post('getroomnewstyles.php', {userlist: document.getElementById("visibleusers").innerHTML, lstmsg: lstmsg}, function(data) {
			var bar=data.split(/\u001C(.+)/);
			$('style#userlinestyles').append(bar[0]);
			$('div#visibleusers').append(bar[1]);
		});
		if(!isNaN(foo[0])) {
			lstmsg=parseInt(foo[0]);
		}
		$('div#textarea').append(foo[1]);
		if(atbottom) {
			element.scrollTop = element.scrollHeight;
		}
	});
}
updateIntervalId=setInterval(updatechatbox,500);
function submittxt() {
	var txt = $('input#typing').val();
	if(txt[0]=="/") {
		$.post('runcommand.php', {text: txt, username: srnm}, function(data) {
	        console.log(data);
			var atbottom=element.scrollTop >= (element.scrollHeight - element.offsetHeight);
			$('div#textarea').append(data);
			document.getElementById('typing').value="";
			if(atbottom) {
				element.scrollTop = element.scrollHeight;
			}
		});
	}
	else {
		$.post('sendroom.php', {text: txt, username: srnm}, function(data) {
			console.log(data);
			document.getElementById('typing').value="";
		});
	}
}
function candleManu27s(e) {
	if(e.which==13||e.keyCode==13) {
		submittxt();
	}
}
</script>

<div id="darken" class="grayout" onclick="hideCreateRoom()"></div>
<div id="createroom" class="cntscr">
	<div class="closebutton" onclick="hideCreateRoom()"></div>
	<form action="./?page=9" method="post" class="cntscrform">
		<div id="makeroomoptions">
		Chat Room Name:
		<input type="text" max-length=32 required name="name"><br><br>
		Join Restriction Level:
		<select name="joinrestriction" onchange="togglepasscode(this.value)" id="joinrestriction">
			<option value="0">Anyone Can Join.</option>
			<option value="1">Anyone Can Join with Passcode.</option>
			<option value="2">User Invitation Required.</option>
			<option value="3">Owner Invitation Required.</option>
		</select><br><br>
		</div>
		<input type="submit" value="Create">
	</form>
	<script>
	function togglepasscode(val) {
		if(document.getElementById("passcodefield")!=null) {
			if(val!=1) {
				document.getElementById("makeroomoptions").removeChild(document.getElementById("passcodefield"));
			}
		}
		else {
			if(val==1) {
				$('div#makeroomoptions').append('<div id="passcodefield">Passcode:<input type="text" name="passcode" max-length=16 required><br><br></div>');
			}
		}
	}
	</script>
</div>

<script>
function hideCreateRoom() {
	document.getElementById('darken').style='visibility:hidden;';
	document.getElementById('createroom').style='visibility:hidden;';
}
</script>
