<html>
	<head>
		<link rel="stylesheet" type="text/css" href="theme.css">
	</head>
	<body>
		<div id="topbar">
			<a href="./?page=0">Welcome</a>&nbsp;
			<a href="./?page=1">Login</a>&nbsp;
			<a href="./?page=2">Home</a>
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
				}
			?>
		</div>
	</body>
</html>
