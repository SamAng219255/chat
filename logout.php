<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=5">';};?>

<?php
$_SESSION['loggedin']='no';
$_SEESION['username']='Not Signed In';
?>
<meta http-equiv="refresh" content="0; URL=./?page=1">
