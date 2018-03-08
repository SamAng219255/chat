<meta charset="utf-8">
<?php if($_SERVER['PHP_SELF']!='/chat/index.php') {echo '<meta http-equiv="refresh" content="0; URL=./?page=2">';};?>

<?php

$servername="127.0.0.1";
$username="chatter";
$password="GeArᛈᚨᛊᚹᚱᛥ";
$conn = mysqli_connect($servername, $username, $password);
mysqli_query($conn,"SET NAMES 'utf8'");
$text=str_replace(array("\\","'"),array("\\\\","\\'"),$_POST['text']);
$query='SELECT `quirks` from `chat`.`users` where username=\''.$_SESSION['username'].'\';';
echo $query.'<br>';
$quirk=mysqli_fetch_row(mysqli_query($conn,$query))[0];
$text=shell_exec("./quirks '".$text."' '".str_replace(array("\\","'"),array("\\\\","\\'"),$quirk)."'");
echo "./quirks '".$text."' '".str_replace(array("\\","'"),array("\\\\","\\'"),$quirk)."'<br>";
echo $text.'<br>';
$sql="INSERT INTO `chat`.`chatroom` (`id`, `username`, `content`) VALUES (0,'".$_SESSION['username']."','".str_replace(array("'","\\"),array("\\'","\\\\"),$text)."')";
echo $sql;
var_dump(mysqli_query($conn,$sql));

?>

<meta http-equiv="refresh" content="0; URL=./?page=2">
