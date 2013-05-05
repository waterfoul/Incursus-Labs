<?php
	if(isset($_POST))
	{
		define('IN_PHPBB', true);
		define('ROOT_PATH', "phpBB");
		
		if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) {
		    exit();
		}
		
		$phpEx = "php";
		$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
		include($phpbb_root_path . 'common.' . $phpEx);
		
		print("BEGIN ROOMS\n");
		print("Public Chat~`~PublicChat");
	}
?>
