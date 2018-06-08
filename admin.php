<title>Admin</title>
<?php
require 'db.php';
$adminquery="SELECT `permissions` FROM `chat`.`users` WHERE `username`='".$_SESSION["username"]."';";
$isadmin=mysqli_fetch_row(mysqli_query($conn,$adminquery))[0]==1;
if(isset($_SESSION["loggedin"]) && $isadmin) {
if(!isset($_GET['place'])) {

echo '<div id="settingbox">
	<h1>Admin Controls</h1>
	<hr>
		<ul>
			<a href="./?p=admin&place=users"><li>Users</li></a>
		</ul>
</div>';

}
else {
if($_GET['place']=='users') {
	$foo=['ASC','ASC','ASC','ASC','ASC','ASC'];
	$bar=['id','username','permissions','active','laston','ip'];
	if(isset($_GET["sort"])) {
		$temp=explode(".",$_GET["sort"]);
		$usersquery="SELECT `id`,`username`,`ip`,`laston`,`active`,`permissions` FROM `chat`.`users` ORDER BY ".$temp[0]." ".$temp[1].";";
		$foo[array_search($temp[0],$bar)]='DESC';
	}
	else {
		$usersquery="SELECT `id`,`username`,`ip`,`laston`,`active`,`permissions` FROM `chat`.`users`;";
	}
	$usersqueryresult=mysqli_query($conn,$usersquery);
	$time=date("Y-m-d H:i:s");
	$timewas=date("Y-m-d H:i:s",time()-1);
		echo '<table class="admintable"><tr>
			<th onclick="window.location=\'./?p=admin&place=users&sort=id.'.$foo[0].'\'">Id</th>
			<th onclick="window.location=\'./?p=admin&place=users&sort=username.'.$foo[1].'\'">Username</th>
			<th onclick="window.location=\'./?p=admin&place=users&sort=permissions.'.$foo[2].'\'">Permission</th>
			<th onclick="window.location=\'./?p=admin&place=users&sort=active.'.$foo[3].'\'">Place</th>
			<th onclick="window.location=\'./?p=admin&place=users&sort=laston.'.$foo[4].'\'">Last On</th>
			<th onclick="window.location=\'./?p=admin&place=users&sort=ip.'.$foo[5].'\'">IP</th>
		</tr>';
	for($i=0; $i<$usersqueryresult->num_rows; $i++) {
		$row=mysqli_fetch_row($usersqueryresult);
		$place=$row[4];
		if($row[3]!=$time && $row[3]!=$timewas) {
			$place="-1";
		}
		echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[5].'</td><td>'.$place.'</td><td>'.$row[3].'</td><td>'.$row[2].'</td></tr>';
	}
	echo "</table>";
}
}}
else {
  echo '<meta http-equiv="refresh" content="0; URL=./?p=home">';
}
?>
