<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=5">';};?>

<?php
unset($_SESSION['last_active_chat']);
unset($_SESSION['loggedin_chat']);
unset($_SESSION['username_chat']);
unset($_SESSION['seen']);
unset($_SESSION['room']);
echo '<meta http-equiv="refresh" content="0; URL=./?p=login&target='.$_GET["target"].'">';
?>
