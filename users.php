<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?p=users">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?p=login">'; };?>

<title>Users</title>

<?php
	require 'db.php';
?>

<div id="chatpicker">
	<a href="./?p=users">Home</a>
	<?php
		
	?>
</div>

<div id="room">
	<div id="textarea">
		
	</div>
	<div id="typearea">
		<div>
			<input id="typing" type="text" placeholder="Type here." name="text" onkeypress="return candleManu27s(event)" autocomplete="off" autofocus>
			<button id="subbut" type="submit" onclick="submittxt();">↑</button>
		</div>
	</div>
</div>
