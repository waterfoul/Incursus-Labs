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
		
		if($_POST["group"] == "")
		{
		    print("true");
		    exit();
		}
		$sql_arr = array(
                    'SELECT'    => 'g.group_name',
                    'FROM'        => array(
                        USERS_TABLE        => 'u',
                        USER_GROUP_TABLE        => 'ug',
                        GROUPS_TABLE        => 'g',
                    ),
                    'WHERE'        => 'u.loginname = \'' . $_POST['user'] . '\'
					AND u.user_id = ug.user_id
					AND ug.group_id = g.group_id
					AND g.group_name IN (\'' . $_POST['group'] . '\',\'' . str_replace('_', ' ', $_POST['group']) . '\')',
                );
                $result = $db->sql_query($db->sql_build_query('SELECT', $sql_arr));

		if($db->sql_fetchrow($result))
			print("true");
		else
			print("false");
	}
?>
