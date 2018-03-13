<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=8">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') {echo '<meta http-equiv="refresh" content="0; URL=./?page=1">';};?>

<div class="grayout"></div>

<div class="cntscr">
	<form>
		Chat Room Name:<br>
		<input type="text" max-length=32 required name="name"><br>
		Users in the room:<br>
		
	</form>
</div>
