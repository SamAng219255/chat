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
elseif($_GET['place']=='users') {
	$foo=['ASC','ASC','ASC','ASC','ASC','ASC'];
	$fooArrow=['','','','','',''];
	$bar=['id','username','permissions','active','laston','ip'];
	if(isset($_GET["sort"])) {
		$temp=explode(".",$_GET["sort"]);
		$usersquery="SELECT `id`,`username`,`ip`,`laston`,`active`,`permissions` FROM `chat`.`users` ORDER BY ".$temp[0]." ".$temp[1].";";
		$sortDirec='DESC';
		if($temp[1]=='DESC') {
			$sortDirec='ASC';
		}
		$foo[array_search($temp[0],$bar)]=$sortDirec;
		if($sortDirec=='DESC') {
			$fooArrow[array_search($temp[0],$bar)]=' ↓';
		}
		else {
			$fooArrow[array_search($temp[0],$bar)]=' ↑';
		}
	}
	else {
		$usersquery="SELECT `id`,`username`,`ip`,`laston`,`active`,`permissions` FROM `chat`.`users`;";
	}
	$usersqueryresult=mysqli_query($conn,$usersquery);
	$time=date("Y-m-d H:i:s");
	$timewas=date("Y-m-d H:i:s",time()-1);
		echo '<table class="admintable"><tr>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=id.'.$foo[0].'\'">Id'.$fooArrow[0].'</th>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=username.'.$foo[1].'\'">Username'.$fooArrow[1].'</th>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=permissions.'.$foo[2].'\'">Permission'.$fooArrow[2].'</th>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=active.'.$foo[3].'\'">Place'.$fooArrow[3].'</th>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=laston.'.$foo[4].'\'">Last On'.$fooArrow[4].'</th>
			<th class="sortable" onclick="window.location=\'./?p=admin&place=users&sort=ip.'.$foo[5].'\'">IP'.$fooArrow[5].'</th>
			<th>Delete</th>
			<th>Ban</th>
			<th>Reset Password</th>
			<th>Alert</th>
		</tr>';
	for($i=0; $i<$usersqueryresult->num_rows; $i++) {
		$row=mysqli_fetch_row($usersqueryresult);
		$place=$row[4];
		if($row[3]!=$time && $row[3]!=$timewas) {
			$place="-1";
		}
		echo '
		<tr>
			<td>'.$row[0].'</td>
			<td>'.$row[1].'</td>
			<td>'.$row[5].'</td>
			<td>'.$place.'</td>
			<td>'.$row[3].'</td>
			<td>'.$row[2].'</td>
			<td><div class="button" onclick="sure(\''.$row[1].'\',\'delete\')">Delete</div></td>
			<td><div class="button" onclick="sure(\''.$row[1].'\',\'ban\')">Ban</div></td>
			<td><div class="button" onclick="sure(\''.$row[1].'\',\'reset the password of\')">Reset Password</div></td>
			<td><input onkeypress="if(event.which==13||event.keyCode==13) {  }" type="text"></td>
		</tr>';
	}
	echo '
	</table>
	<script>
		function sure(user,action) {
			randText=Math.ceil(Math.random()*Math.pow(36,11)).toString(36).toUpperCase();
			sureTest=prompt("Are you sure you want to "+action+" "+user+"?\nIf so type the username")
			if(sureTest==user) {
				if(action=="delete") {
					//delete
					alert(user+" has been deleted.");
				}
				else if(action=="ban") {
					//ban
					alert(user+" has been banned.");
				}
				else if(action=="reset the password of") {
					//set password to randText
					alert(user+"\'s new password is "+randText);
				}
				location.reload();
			}
			else if(sureTest!=null) {
				alert("Incorrect Name")
			}
		}
	</script>
';
}
}
else {
  echo '<meta http-equiv="refresh" content="0; URL=./?p=home">';
}
?>
