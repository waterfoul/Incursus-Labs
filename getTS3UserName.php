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
		
		$user->session_begin();
		$auth->acl($user->data);
		$auth->login($_POST["loginname"], $_POST["password"], false, 1, 0);

		$data = array(
		    'pf_tskey'     => $_POST["key"],
		);
		$sql = 'UPDATE ' . PROFILE_FIELDS_DATA_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data) . ' WHERE user_id = ' . (int) $user->data["user_id"];
		$db->sql_query($sql);
		print($user->data["username"]);	
		
	}
?>
