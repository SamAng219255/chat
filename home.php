<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?page=1">'; };?>

<div id="room">
<div id="textarea">
<?php
	$servername="127.0.0.1";
	$username="chatter";
	$password="GeArᛈᚨᛊᚹᚱᛥ";
	$conn = mysqli_connect($servername, $username, $password);
	$query="SELECT * FROM (SELECT * FROM `chat`.`chatroom` ORDER BY id DESC LIMIT 64) AS `table` ORDER by id ASC";
	$queryresult=mysqli_query($conn,$query);
	//var_dump($queryresult);
	//echo '<br>';
	if($queryresult->num_rows>0) {
		for($i=0; $i<$queryresult->num_rows; $i++) {
			$row=mysqli_fetch_row($queryresult);
			echo '<p>'.$row[1].': '.$row[2].'</p>';
		}
	}
	else {
		echo 'There are no messages.';
	}
?>
</div>
<div id="typearea">
	<form action="./?page=6" method="post">
	<input id="typing" type="text" placeholder="Type here." name="text" autocomplete="off">
	<button id="subbut" type="submit">↑</button>
	</form>
</div>
</div>
<script>
var element=document.getElementById("textarea");
element.scrollTop = element.scrollHeight;
</script>
