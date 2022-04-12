<?php $fooip=explode("/",$_SERVER['PHP_SELF']); if($fooip[count($fooip)-1]!='index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?p=home">';};?>

<?php

$_SESSION['loggedin_chat']='yes';
$_SESSION['username_chat']=addslashes($_POST['username']);

$ipsql="UPDATE `chat`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username_chat']."';";
mysqli_query($conn,$ipsql);

if(isset($_POST["target"])) {
  echo '<meta http-equiv="refresh" content="0; URL=./?p='.$_POST["target"].'">';
}
else {
    echo '<meta http-equiv="refresh" content="0; URL=./?p=general">';
}

?>
