<?php
	session_set_cookie_params(['samesite' => 'Secure']);
	session_start();
	if ((isset($_SESSION['last_active_chat']) && (time() - $_SESSION['last_active_chat'] > 1800)) || (!isset($_SESSION['last_active_chat']) && isset($_SESSION['loggedin_chat']))) {
		unset($_SESSION['last_active_chat']);
		unset($_SESSION['loggedin_chat']);
		unset($_SESSION['username_chat']);
		unset($_SESSION['seen']);
		unset($_SESSION['room']);
	}
	$_SESSION['last_active_chat']=time();
?>

<html>
	<head>
		<?php
			$whoisit=$_SERVER['REMOTE_ADDR'];
			require 'db.php';
			if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
				$banquery="SELECT `permissions` FROM `chat`.`users` WHERE `username`='".$_SESSION["username_chat"]."';";
				$isbanned=mysqli_fetch_row(mysqli_query($conn,$banquery))[0]==-1;
				if($isbanned) {
					echo '<meta http-equiv="refresh" content="0; URL=https://youtu.be/dQw4w9WgXcQ">';
					$_SESSION['loggedin_chat']='no';
				}
			}
		?>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="theme.css">
		<script>
			profileShown=false;
			function showProfile() {
				document.getElementById("profilemenu").style="visibility:visible;";
				profileShown=true;
			}
                        function hideProfile() {
                                document.getElementById("profilemenu").style="visibility:hidden;";
                                profileShown=false;
                        }
			function toggleProfile() {
                        if(!profileShown) {
                                document.getElementById("profilemenu").style="visibility:visible;";
                                profileShown=true;
                        }
                        else {
                                document.getElementById("profilemenu").style="visibility:hidden;";
                                profileShown=false;
                        }
			}
			notesShown=false;
			function showNotes() {
				document.getElementById("noteslist").style="visibility:visible;";
				notesShown=true;
			}
			function hideNotes() {
				document.getElementById("noteslist").style="visibility:hidden;";
				notesShown=false;
			}
			function toggleNotes() {
				if(!notesShown) {
					document.getElementById("noteslist").style="visibility:visible;";
					notesShown=true;
				}
				else {
					document.getElementById("noteslist").style="visibility:hidden;";
					notesShown=false;
				}
			}
		</script>
		<script src="jquery.js"></script>
		<style id="colRot">/*body {filter: hue-rotate(120deg);} p[user] {filter: hue-rotate(-120deg);}*/</style>
	</head>
	<body>
		<!--<div id="body"></div>-->
		<script>looping=false;</script>
		<?php
			if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
				$pmsquery="SELECT `pendingpms` FROM `chat`.`users` WHERE `username`='".$_SESSION['username_chat']."';";
				$pmsqueryresult=mysqli_query($conn,$pmsquery);
				$pmsrow=mysqli_fetch_row($pmsqueryresult);
				$pmslist=explode(json_decode('"\u001D"'),$pmsrow[0]);
				if(count($pmslist)>1) {
					echo '<div id="banner">';
					$extras=" has";
					if(count($pmslist)>3) {
						$extras=", and ".(count($pmslist)-2)." other people, have";
					}
					elseif (count($pmslist)==3) {
						$extras=", and 1 other person, have";
					}
					echo $pmslist[0].$extras.' sent you a message';
					echo '</div>';
				}
				$pmssql="UPDATE `chat`.`users` SET `pendingpms`='' WHERE `username`='".$_SESSION["username_chat"]."';";
				mysqli_query($conn,$pmssql);
			}
		?>
		<div id="topbar">
			<a href="./?p=home">Home</a>&nbsp;&nbsp&nbsp;
			<?php
				if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
					$adminquery="SELECT `permissions` FROM `chat`.`users` WHERE `username`='".$_SESSION["username_chat"]."';";
					$isadmin=mysqli_fetch_row(mysqli_query($conn,$adminquery))[0]>=1;
					echo '<a href="./?p=general">Chat</a>&nbsp;&nbsp&nbsp;';
					echo '<a href="./?p=browse">Browse</a>&nbsp;&nbsp&nbsp;';
					echo '<a href="./?p=users">Users</a>';
					if($isadmin) {
						echo '&nbsp;&nbsp&nbsp;<a href="./?p=admin">Admin</a>';
					}
				}
				else {
					echo '<a href="./?p=login&target=general">Chat</a>&nbsp;&nbsp&nbsp;';
					echo '<a href="./?p=login&target=browse">Browse</a>&nbsp;&nbsp&nbsp;';
					echo '<a href="./?p=login&target=users">Users</a>';
				}
			?>
			<div id="profileicon" onclick="toggleProfile();" onmouseleave="hideProfile();">
			<div id="profilemenu" class="noselect">
				<?php
					if(isset($_SESSION['loggedin_chat']) && $_SESSION['loggedin_chat']=='yes') {
						echo 'Signed in as: <br>'.$_SESSION['username_chat'];
						echo '<a href="./?page=5">Log Out</a>';
						echo '<a href="./?p=settings">Settings</a>';
					}
					else {
						echo 'Not signed in.';
						echo '<a href="./?p=login">Sign In</a>';
					}
				?>
			</div>
			</div>
			<div id="noteicon" onclick="toggleNotes();" onmouseleave="hideNotes();" style="visibility:hidden">
				<div id="noteslist" class="noselect">
					Nothing here yet.
				</div>
			</div>
		</div>
		<div id="stuff">
			<?php
				$get=-1;
				if (isset($_GET['page'])) {
					$get = $_GET['page'];
				}
				else {
					$page='';
					if(isset($_GET['p'])) {
						$page=$_GET['p'];
					}
					if($page=='admin') {
						$get=14;
					}
					elseif($page=='users' && isset($_GET['user'])) {
						$get=13;
					}
					elseif($page=='users') {
						$get=12;
					}
					elseif($page=='setting') {
						$get=11;
					}
					elseif($page=='settings' && isset($_GET['place']) && $_GET['place']=='replace') {
						$get=11;
					}
					elseif($page=='browse') {
						$get=10;
					}
					elseif($page=='chat') {
						$get=8;
					}
					elseif($page=='settings') {
						$get=7;
					}
					elseif($page=='general') {
						$get=2;
					}
					elseif($page=='login') {
						$get=1;
					}
					elseif($page=='home') {
						$get=0;
					}
					else {
						$get=0;
					}
				}
				switch($get) {
					case 0:
					require 'welcome.php';
					break;
					case 1:
					require 'loginform.php';
					break;
					case 2:
					require 'home.php';
					break;
					case 3:
					require 'login.php';
					break;
					case 4:
					require 'register.php';
					break;
					case 5:
					require 'logout.php';
					break;
					case 6:
					require 'send.php';
					break;
					case 7:
					require 'setting.php';
					break;
					case 8:
					require 'rooms.php';
					break;
					case 9:
					require 'createroom.php';
					break;
					case 10:
					require 'chatrooms.php';
					break;
					case 11:
					require 'quirks.php';
					break;
					case 12:
					require 'users.php';
					break;
					case 13:
					require 'userchat.php';
					break;
					case 14:
					require 'admin.php';
					break;
				}
				$getroom=0;
				if(isset($_GET['room'])) {
					$getroom=$_GET['room'];
				}
			?>
		</div>
		<script>
			function stillhere() {
				$.post('stillalive.php', {page:<?php echo $get ?>,room:<?php echo addslashes($getroom) ?>}, function(data){if(data!="") {console.log(data)}});
			}
			setInterval(stillhere,500);
		</script>
		<?php echo "<script>crntpg='".$_GET["p"]."';</script>"; ?>
		<script>
			if(document.hasFocus()) {
				seen=true;
				$.post('away.php',{away:0},function(){});
			}
			wrongs=0;
			$(function () {
				$(window).blur(function() {
					seen=false;
					console.log("no");
					$.post('away.php',{away:1},function(){});
				});
				$(window).focus(function() {
					seen=true;
					console.log("yes");
					$.post('away.php',{away:0},function(){});
				});
			});
			function checkseen() {
				$.post('actseen.php',{seen:seen},function (data) {if(data!='don\'t') {if(data=='wrong'){wrongs+=2} if(wrongs>0){wrongs--} if(wrongs>2) {$.post('actseen.php',{seen:!seen}),function(){}; window.location='./?page=5&target='+crntpg;}}});
			}
			if(!looping) {
				setInterval(checkseen,500);
			}
		</script>
	</body>
</html>
