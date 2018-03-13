<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?page=1">'; };?>

<style id="userlinestyles"></style>

<div id="chatpicker">
<a href="./?page=2">General</a>
</div>
<div id="username" style="visibility:hidden;"><?php echo $_SESSION['username']; ?></div>
<div id="room">
<div id="textarea">
<?php
	require 'db.php';
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` ORDER BY id DESC LIMIT 256) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	//var_dump($queryresult);
	//echo '<br>';
	$lastmsg=-1;
	$usersvisible=array();
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			echo '<p user="'.strtolower($row[1]).'">'.$row[1].': '.htmlspecialchars($row[2]).'</p>';
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
	$sql="INSERT INTO `chat`.`chatroom` (`id`, `username`, `content`) VALUES (0,'".$_SESSION['username']."','".addslashes($text)."')";
	mysqli_query($conn,$sql);
	echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';
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
	$.post('pageupdate.php', {last: lstmsg}, function(data) {
		var atbottom=element.scrollTop >= (element.scrollHeight - element.offsetHeight);
		//console.log(data);
		var foo=data.split(/\|(.+)/);
		if(lstmsg<0 && typeof foo[1] != "undefined") {
			$('div#textarea').text("");
		}
		$.post('getnewstyles.php', {userlist: document.getElementById("visibleusers").innerHTML, lstmsg: lstmsg}, function(data) {
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
	$.post('send.php', {text: txt, username: srnm}, function(data) {
		console.log(data);
		updatechatbox();
		document.getElementById('typing').value="";
	});
}
function candleManu27s(e) {
	if(e.which==13||e.keyCode==13) {
		submittxt();
	}
}
</script>
