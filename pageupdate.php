<?php
if(isset($_POST['last']) && !empty($_POST['last'])) {
	require 'db.php';
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` WHERE id>".$_POST['last']." ORDER BY id DESC) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	$lastmsg=0;
	$echos='';
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$echos.='<p user="'.strtolower($row[1]).'">'.$row[1].': '.$row[2].'</p>';
			$lastmsg=$row[0];
		}
	}
	echo $lastmsg.'|';
	echo $echos;
}
?>
