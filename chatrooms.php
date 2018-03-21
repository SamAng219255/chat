<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=browse">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Browse Chat Rooms</title>

<div id="settingbox">
<h1>Chat Rooms</h1>
<hr>
<ul class="large">
<?php

require 'db.php';
$query="SELECT * FROM `chat`.`chatrooms` WHERE NOT `owner`='".$_SESSION['username']."';";
$queryresult=mysqli_query($conn,$query);
for($i=0; $i<$queryresult->num_rows; $i++) {
	$row=mysqli_fetch_row($queryresult);
	if(!in_array(strtolower($_SESSION['username']),explode(json_decode('"\u001D"'),$row[2]))) {
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
		}
	}
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
