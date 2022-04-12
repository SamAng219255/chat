<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=users">';};?>
<?php if(!isset($_SESSION['loggedin_chat']) || $_SESSION['loggedin_chat']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Users</title>

<style id="userlinestyles"><?php
require 'db.php';
$stylequeryone="SELECT `txtcolor`,`bckcolor`,`username` FROM `chat`.`users` WHERE `username`='".$_SESSION['username_chat']."';";
$styleone=mysqli_fetch_row(mysqli_query($conn,$stylequeryone));
$stylequerytwo="SELECT `txtcolor`,`bckcolor`,`username` FROM `chat`.`users` WHERE `username`='".$_GET['user']."';";
$styletwo=mysqli_fetch_row(mysqli_query($conn,$stylequerytwo));
echo 'p[user="'.strtolower($styleone[2]).'"] {color:#'.$styleone[0].';background-color:#'.$styleone[1].';}';
echo 'p[user="'.strtolower($styletwo[2]).'"] {color:#'.$styletwo[0].';background-color:#'.$styletwo[1].';}';
?></style>

<div id="chatpicker">
	<?php
		$query="SELECT DISTINCT * FROM (SELECT recipient AS user FROM `chat`.`userchatroom` WHERE `username`='".$_SESSION['username_chat']."' UNION SELECT username AS user FROM `chat`.`userchatroom` WHERE `recipient`='".$_SESSION['username_chat']."') AS `table`;";
		$queryresult=mysqli_query($conn,$query);
		if($queryresult) {for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			echo '<a href="./?p=users&user='.$row[0].'">'.$row[0].'</a>';
		}}
	?>
	<a onclick="document.getElementById('darken').style='visibility:visible;'; document.getElementById('adduserchat').style='visibility:visible;';">Chat With Another User</a>
</div>

<div id="room">
	<div id="textarea">
		<?php
			$query="SELECT DISTINCT * FROM ( SELECT * FROM `chat`.`userchatroom` WHERE `username`='".$_SESSION['username_chat']."' AND `recipient`='".$_GET['user']."' UNION SELECT * FROM `chat`.`userchatroom` WHERE `username`='".$_GET['user']."' AND `recipient`='".$_SESSION['username_chat']."' ORDER BY id DESC LIMIT 256 ) AS `table` ORDER by id ASC";
			$queryresult=mysqli_query($conn,$query);
			//var_dump($queryresult);
			//echo '<br>';
			$lastmsg=-1;
			$usersvisible=array();
			$titles=array();
			if($queryresult && $queryresult->num_rows>0) {
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
		?>
	</div>
	<div id="typearea">
		<div>
			<input id="typing" type="text" placeholder="Type here." name="text" onkeypress="return candleManu27s(event)" autocomplete="off" autofocus>
			<button id="subbut" type="submit" onclick="submittxt();">↑</button>
		</div>
	</div>
</div>

<?php
if(isset($_POST['text'])) {
	$text=$_POST['text'];
	$sql="INSERT INTO `chat`.`userchatroom` (`id`, `username`, `content`, `recipient`) VALUES (0,'".$_SESSION['username_chat']."','".addslashes($text)."','".addslashes($_GET['user'])."')";
	mysqli_query($conn,$sql);
	echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';
}
?>
<?php echo '<script>recipient="'.$_GET['user'].'"</script>' ?>
<script>
lstmsg=parseInt(document.getElementById("lastmsg").innerHTML);
function updatechatbox() {
	checkseen();
	$.post('kickbad.php',{},function(data) {
		if(data!="legal") {
			document.location="?p=login";
		}
	});
	$.post('userpageupdate.php', {last: lstmsg, recipient: recipient}, function(data) {
		console.log(data);
		var atbottom=element.scrollTop >= (element.scrollHeight - element.offsetHeight);
		//console.log(data);
		var foo=data.split(/\|(.+)/);
		if(lstmsg<0 && typeof foo[1] != "undefined") {
			$('div#textarea').text("");
		}
		if(!isNaN(foo[0])) {
			lstmsg=parseInt(foo[0]);
		}
		$('div#textarea').append(foo[1]);
		if(atbottom) {
			element.scrollTop = element.scrollHeight;
		}
	});
}
looping=true;
updateIntervalId=setInterval(updatechatbox,500);
function submittxt() {
	var txt = $('input#typing').val();
	$.post('usersend.php', {text: txt, recipient: recipient}, function(data) {
		console.log(data);
		document.getElementById('typing').value="";
	});
}
function candleManu27s(e) {
	if(e.which==13||e.keyCode==13) {
		submittxt();
	}
}
</script>

<div id="darken" class="grayout" onclick="hideadduserchat()"></div>
<div id="adduserchat" class="cntscr">
	<div class="closebutton" onclick="hideadduserchat()"></div>
	<form method="get" class="cntscrform" class="cntscrform">
		<div id="makeroomoptions">
		<input type="hidden" name="p" value="users">
		Other User's Name:
		<input type="text" max-length=16 required name="user"><br><br>
		</div>
		<input type="submit" value="Open Chat">
	</form>
</div>

<script>
function hideadduserchat() {
	document.getElementById('darken').style='visibility:hidden;';
	document.getElementById('adduserchat').style='visibility:hidden;';
}
</script>

<script>
element=document.getElementById("textarea");
element.scrollTop = element.scrollHeight;
</script>
