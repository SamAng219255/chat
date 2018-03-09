<?php
if(isset($_POST['last']) && !empty($_POST['last'])) {
	$servername="127.0.0.1";
	$username="chatter";
	$password="GeArᛈᚨᛊᚹᚱᛥ";
	$conn = mysqli_connect($servername, $username, $password);
	mysqli_query($conn,"SET NAMES 'utf8'");
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` WHERE id>".$_POST['last']." ORDER BY id DESC) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	$lastmsg=0;
	$echos='';
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			$echos.='<p>'.$row[1].': '.$row[2].'</p>';
			$lastmsg=$row[0];
		}
	}
	echo $lastmsg.'|';
	echo $echos;
}
?>
