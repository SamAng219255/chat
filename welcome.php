<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' && PHP_OS!='Darwin') {echo '<meta http-equiv="refresh" content="0; URL=./?page=0">';};?>
Welcome<br>
<title>Home</title>
<?php
echo 'Server is runing on: '.PHP_OS;
?>
