<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=0">';};?>

<?php

/*$session=shell_exec('openssl rand -hex 8');//original code, assumed session variables behaved like cookies
$_SESSION['id']=$session;
$servername="127.0.0.1";
$username="chatter";
$password="GeArᛈᚨᛊᚹᚱᛥ";
$conn = mysqli_connect($servername, $username, $password);
$query="DELETE FROM `chat`.`sessions` WHERE username='".str_replace(array("'","\\"),array("\\'","\\\\"),$_POST['username'])."'";
mysqli_query($conn,$query);
$sql="INSERT INTO `chat`.`sessions` (`id`, `sessionID`, `userIP`, `username`) VALUES (0,'".$session."','".$_SERVER['REMOTE_ADDR']."','".str_replace(array("'","\\"),array("\\'","\\\\"),$_POST['username'])."')";
mysqli_query($conn,$sql);*/

$_SESSION['loggedin']='yes';
$_SESSION['username']=addslashes($_POST['username']);

$ipsql="UPDATE `chat`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username']."';";
mysqli_query($conn,$ipsql);

?>

<meta http-equiv="refresh" content="0; URL=./?page=2">
