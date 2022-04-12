<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=browse">';};?>
<?php if(!isset($_SESSION['loggedin_chat']) || $_SESSION['loggedin_chat']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Browse Chat Rooms</title>

<div id="settingbox">
<h1>Browse Chat Rooms</h1>
<hr>
<ul class="large">
<?php

require 'db.php';
$foundrooms=0;
$query="SELECT * FROM `chat`.`chatrooms` WHERE NOT `owner`='".$_SESSION['username_chat']."';";
$queryresult=mysqli_query($conn,$query);
if($queryresult) {for($i=0; $i<$queryresult->num_rows; $i++) {
	$row=mysqli_fetch_row($queryresult);
	if(!in_array(strtolower($_SESSION['username_chat']),explode(json_decode('"\u001D"'),$row[2]))) {
		if($row[3]<2) {
			echo '<a href="./?p=chat&room='.$row[0].'"><li>';
			echo '<div class="h3">'.$row[4].'</div>';
			echo '<div class="p">Owned by: '.$row[1].'</div>';
			$lockmode="questionmark";
			if($row[3]==0) {
				$lockmode="unlocked";
			}
			elseif($row[3]==1) {
				$lockmode="locked";
			}
			echo '<div class="lockmode '.$lockmode.'"></div></li></a>';
			$foundrooms++;
		}
	}
}
if($foundrooms<1) {
	echo '<p>There are no public chatrooms that you aren\'t already in.</p>';
	echo '<p>You can see the chatrooms you are in from the general chat page or any chatroom page.</p>';
	echo '<p>You can create a new chatroom from the same place.</p>';
}}
else {
	echo '<p>There are no chatrooms.</p>';
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
