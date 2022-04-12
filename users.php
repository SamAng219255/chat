<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=users">';};?>
<?php if(!isset($_SESSION['loggedin_chat']) || $_SESSION['loggedin_chat']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Users</title>

<div id="settingbox">
<h1>Users</h1>
<hr>
<ul class="large">
<?php

require 'db.php';
$foundusers=0;
$query="SELECT DISTINCT * FROM (SELECT recipient AS user FROM `chat`.`userchatroom` WHERE `username`='".$_SESSION['username_chat']."' UNION SELECT username AS user FROM `chat`.`userchatroom` WHERE `recipient`='".$_SESSION['username_chat']."') AS `table`;";
$queryresult=mysqli_query($conn,$query);
if($queryresult) {for($i=0; $i<$queryresult->num_rows; $i++) {
	$row=mysqli_fetch_row($queryresult);
	echo '<a href="./?p=users&user='.$row[0].'"><li>';
	echo '<div class="h3">'.$row[0].'</div>';
	echo '</li></a>';
	$foundusers++;
}
if($foundusers<1) {
	echo '<p>You are not talking with any users.</p>';
}}
else {
	echo '<p>You are not talking with any users.</p>';
}

?>
	<li>
		<div class="h3">Start New Conversation</div>
		<div class="p">Enter Their Username:<input type="text" id="newchat" onkeypress="return candleManu27s(event)"><input type="submit" value="Start!" onclick="if($('#newchat').val()!='') {window.location='./?p=users&user='+$('#newchat').val()}"></div>
	</li>
</ul>
</div>
<script>
function candleManu27s(e) {
	if(e.which==13||e.keyCode==13) {
		if($('#newchat').val()!='') {window.location='./?p=users&user='+$('#newchat').val()}
	}
}
</script>
<script>
	offset=parseInt($(settingbox).css('padding-top').split('px')[0])+parseInt($(settingbox).css('padding-bottom').split('px')[0])+30;
	document.getElementById("stuff").style="height: "+(window.innerHeight-stuff.offsetTop-offset);
	document.getElementById("settingbox").style="height: "+(window.innerHeight-settingbox.offsetTop-offset);
	setInterval( function() {
	document.getElementById("stuff").style="height: "+(window.innerHeight-stuff.offsetTop-offset);
	document.getElementById("settingbox").style="height: "+(window.innerHeight-settingbox.offsetTop-offset);
	}, 500);
</script>
<style></style>
