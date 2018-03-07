<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=5">';};?>

<?php
$_SESSION['loggedin']='no';
$_SEESION['username']='Not Signed In';
?>
<meta http-equiv="refresh" content="0; URL=./?page=1">
