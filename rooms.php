<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php' ) {echo '<meta http-equiv="refresh" content="0; URL=./?page=8">';};?>
<?php if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!='yes') { echo '<meta http-equiv="refresh" content="0; URL=./?page=1">'; };?>

<?php
require 'db.php';
$roomquery="SELECT `id`,`owner`,`users` FROM `chat`.`chatrooms` WHERE `id`='".addslashes($_GET['room'])."';";
$roomqueryresult=mysqli_query($conn,$roomquery);
?>
