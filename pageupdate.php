<?php
session_start();
if(isset($_POST['last']) && !empty($_POST['last'])) {
	require 'db.php';
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` WHERE id>".$_POST['last']." ORDER BY id DESC) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	$lastmsg=0;
	$echos='';
	$titles=array();
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$temptime=explode(" ",$row[3]);
			$timesent=$temptime[0];
			if($temptime[0]==date('Y-m-d')) {
				$timesent=$temptime[1];
			}

			$title=""; $prefix=""; $suffix="";
			if(!array_key_exists(strtolower($row[1]),$titles)) {
				$titlequery="SELECT `prefix`,`suffix`,`username` FROM `chat`.`users` WHERE `username`='".$row[1]."';";
				$titlequeryresult=mysqli_query($conn,$titlequery);
                                $titlerow=mysqli_fetch_row($titlequeryresult);
                                $titles[strtolower($row[1])]['pre']=$titlerow[0];
                                $titles[strtolower($row[1])]['suf']=$titlerow[1];
                        }
                        $prefix=$titles[strtolower($row[1])]['pre'];
                        $suffix=$titles[strtolower($row[1])]['suf'];
			$echos.='<p user="'.strtolower($row[1]).'">['.$timesent.']'.$title.' '.$prefix.$row[1].$suffix.': '.htmlspecialchars($row[2]).'</p>';
			$lastmsg=$row[0];
		}
	}
	$pendingquery="SELECT `username`,`pending` FROM `chat`.`users` WHERE `username`='".$_SESSION['username_chat']."';";
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
	$pendingsql="UPDATE `chat`.`users` SET `pending`='".$newpending."' WHERE `username`='".$_SESSION['username_chat']."';";
	mysqli_query($conn,$pendingsql);
	echo $lastmsg.'|';
	echo $echos;
}
?>
