<?php
	include("config.php");
	include("apiSync/APIkey.php");
	include("apiSync/syncPermissions.php");
	syncKeys($mysql_host, $mysql_yapeal_db, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password);
?>
