<?php
session_start();
if(isset($_POST['last']) && !empty($_POST['last'])) {
	require 'db.php';
	$query="SELECT * FROM (SELECT * FROM `chat`.`privchatroom` WHERE room=".$_SESSION['room']." AND id>".$_POST['last']." ORDER BY id DESC) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	$lastmsg=0;
	$echos='';
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$temptime=explode(" ",$row[4]);
			$timesent=$temptime[0];
			if($temptime[0]==date('Y-m-d')) {
				$timesent=$temptime[1];
			}
			$echos.='<p user="'.strtolower($row[1]).'">['.$timesent.'] '.$row[1].': '.htmlspecialchars($row[2]).'</p>';
			$lastmsg=$row[0];
		}
	}
	echo $lastmsg.'|';
	echo $echos;
}
?>
