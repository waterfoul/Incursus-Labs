<?php
/**
*
* @package acp
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class acp_blocklist
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		
		if ($mode != 'info')
		{
			trigger_error('NO_MODE', E_USER_ERROR);
		}
		$this->page_title = 'ACP_BLOCKLIST_TITLE';
		$this->tpl_name = 'acp_blocklist';
				
		$output = print_r($db["db_connect_id"],true);
		
		$template->assign_var('STUFF', $output);
	}
}

?>