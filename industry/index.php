<html>
	<head>
		<link type="text/css" href="../header.css" rel="stylesheet" />
	</head>
	<body>
		<div id="wrap">
			<?php
				define('IN_PHPBB', true);
				include("../header.php");
				if($user->data['loginname'] != "waterfoul" && $user->data['loginname'] != "MrWacko" && $user->data['loginname'] != "themastercheif92")
					exit();
			?>
		</div>
	</body>
</html>