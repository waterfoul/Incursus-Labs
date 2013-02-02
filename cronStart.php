<?php
	include("config.php");
	include("apiSync.APIkey.php");
	syncKeys($mysql_host, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password);
	//exec("cd yapeal && php yapeal.php");
	sync_all_permissions($mysql_host, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password);
?>