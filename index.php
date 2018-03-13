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
			<a href="./?page=0">Welcome</a>&nbsp;
			<!--<a href="./?page=1">Login</a>&nbsp;-->
			<a href="./?page=2">Home</a>
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
						echo '<a href="./?page=1">Sign In</a>';
					}
				?>
			</div>
			</div>
		</div>
		<div id="stuff">
			<?php
				if (isset($_GET['page'])) {
					$get = $_GET['page'];
				} else {
					$get = 0;
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
				}
			?>
		</div>
	</body>
</html>
