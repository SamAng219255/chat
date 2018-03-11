<?php
require 'db.php';
$usersvisible=explode(json_decode('"\u001D"'),$_POST['userlist']);
echo '<!-- '.json_decode('"\u001D"').' -->';
$vuCount=count($usersvisible);
for($i=0; $i<$vuCount; $i++) {
	$query="SELECT `txtcolor`,`bckcolor` FROM `chat`.`users` WHERE `username`='".$usersvisible[$i]."'";
	$queryresult=mysqli_query($conn,$query);
	$row=mysqli_fetch_row($queryresult);
	echo "p[user=\"".$usersvisible[$i]."\"] {color:#$row[0];background-color:#$row[1];}\n";
}
?>
