<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=users">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Users</title>

<div id="settingbox">
<h1>Users</h1>
<hr>
<ul class="large">
<?php

require 'db.php';
$foundrooms=0;
$query="SELECT DISTINCT * FROM (SELECT recipient AS user FROM `chat`.`userchatroom` WHERE `username`='".$_SESSION['username']."' UNION SELECT username AS user FROM `chat`.`userchatroom` WHERE `recipient`='".$_SESSION['username']."');";
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
</ul>
</div>

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
