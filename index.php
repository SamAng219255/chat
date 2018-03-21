<?php
	session_start();
?>

<html>
	<head>
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
		</script>
		<script src="jquery.js"></script>
	</head>
	<body>
		<div id="topbar">
			<a href="./?p=home">Home</a>&nbsp;&nbsp&nbsp;
			<a href="./?p=general">General Chat</a>&nbsp;&nbsp&nbsp;
			<a href="./?p=browse">Chat Rooms</a>
			<div id="profileicon" onclick="toggleProfile();" onmouseleave="hideProfile();">
			<div id="profilemenu" class="noselect">
				<?php
					if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=='yes') {
						echo 'Signed in as: <br>'.$_SESSION['username'];
						echo '<a href="./?page=5">Log Out</a>';
						echo '<a href="./?page=7">Settings</a>';
					}
					else {
						echo 'Not signed in.';
						echo '<a href="./?p=login">Sign In</a>';
					}
				?>
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
					$page=$_GET['p'];
					if($page=='browse') {
						$get=10;
					}
					elseif($page=='chat') {
						$get=8;
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
	</body>
</html>
