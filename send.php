<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';};?>

<?php

$servername="127.0.0.1";
$username="chatter";
$password="GeArᛈᚨᛊᚹᚱᛥ";
$conn = mysqli_connect($servername, $username, $password);
$sql="INSERT INTO `chat`.`chatroom` (`id`, `username`, `content`) VALUES ('','".$_SESSION['username']."','".str_replace(array("'","\\"),array("\\'","\\\\"),$_POST['text'])."')";
echo $sql;
mysqli_query($conn,$sql);

?>

<meta http-equiv="refresh" content="0; URL=./?page=2">
