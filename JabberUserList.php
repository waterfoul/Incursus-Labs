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
		$sql_arr = array(
                    'SELECT'    => 'u.loginname, u.username',
                    'FROM'        => array(
                        USERS_TABLE        => 'u'
                    ),
                    'WHERE'        => 'u.loginname IN (' . str_replace("\\'", "'", $_POST['users']) . ')',
                );
		$result = $db->sql_query($db->sql_build_query('SELECT', $sql_arr));
		while($row = $db->sql_fetchrow($result))
			print("\n" . $row["loginname"] . "\n" . str_replace("&#01;", "", $row["username"]));
		
	}
?>
