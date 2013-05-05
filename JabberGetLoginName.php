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
                    'WHERE'        => 'LOWER(u.username) IN (
					\'' . $_POST['user'] . '\',
					\'' . $_POST['user'] . '$#01;\', 
					\'' . str_replace("_"," ",$_POST['user']) . '\',
					\'' . str_replace("_"," ",$_POST['user']) . '$#01;\'
		    )',
                );
		$result = $db->sql_query($db->sql_build_query('SELECT', $sql_arr));
		if($row = $db->sql_fetchrow($result))
			print($row["loginname"]);
		else
			print("");
		
	}
?>
