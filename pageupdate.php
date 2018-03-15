<?php
session_start();
if(isset($_POST['last']) && !empty($_POST['last'])) {
	require 'db.php';
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` WHERE id>".$_POST['last']." ORDER BY id DESC) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	$lastmsg=0;
	$echos='';
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$temptime=explode(" ",$row[3]);
			$timesent=$temptime[0];
			if($temptime[0]==date('Y-m-d')) {
				$timesent=$temptime[1];
			}
			$echos.='<p user="'.strtolower($row[1]).'">['.$timesent.'] '.$row[1].': '.htmlspecialchars($row[2]).'</p>';
			$lastmsg=$row[0];
		}
	}
	$pendingquery="SELECT `username`,`pending` FROM `chat`.`users` WHERE `username`='".$_SESSION['username']."';";
	$pendingqueryresult=mysqli_query($conn,$pendingquery);
	$pendingrow=mysqli_fetch_row($pendingqueryresult);
	$temp=array();
	if($pendingrow[1]!="") {
		$temp=explode(json_decode('"\u001D"'),$pendingrow[1]);
		$echos.=array_splice($temp,0,1)[0];
	}
	$newpending="";
	for($i=0; $i<count($temp); $i++) {
		if(i>0) {
			$newpending.=json_decode('"\u001D"');
		}
		$newpending.=$temp[i];
	}
	$pendingsql="UPDATE `chat`.`users` SET `pending`='".$newpending."' WHERE `username`='".$_SESSION['username']."';";
	mysqli_query($conn,$pendingsql);
	echo $lastmsg.'|';
	echo $echos;
}
?>
