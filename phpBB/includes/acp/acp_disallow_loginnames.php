<?php
/**
*
* Separate Login and Username [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 Xceler8shun
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
class acp_disallow_loginnames
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

		$user->add_lang('acp/separate_login_username');

		// Set up general vars
		$this->tpl_name = 'acp_disallow_loginnames';
		$this->page_title = 'ACP_DISALLOW_LOGINNAMES';

		$form_key = 'acp_disallow_loginnames';
		add_form_key($form_key);

		$disallow = (isset($_POST['disallow'])) ? true : false;
		$allow = (isset($_POST['allow'])) ? true : false;

		if (($allow || $disallow) && !check_form_key($form_key))
		{
			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		if ($disallow)
		{
			$disallowed_login = str_replace('*', '%', utf8_normalize_nfc(request_var('disallowed_login', '', true)));

			if (!$disallowed_login)
			{
				trigger_error($user->lang['NO_LOGINNAME_SPECIFIED'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$sql = 'INSERT INTO ' . DISALLOW_LOGIN_TABLE . ' ' . $db->sql_build_array('INSERT', array('disallow_loginname' => $disallowed_login));
			$db->sql_query($sql);

			$cache->destroy('_disallowed_loginnames');

			$message = $user->lang['DISALLOW_LOGIN_SUCCESSFUL'];
			add_log('admin', 'LOG_DISALLOW_LOGIN_ADD', str_replace('%', '*', $disallowed_login));

			trigger_error($message . adm_back_link($this->u_action));
		}
		else if ($allow)
		{
			$disallowed_login_id = request_var('disallowed_login_id', 0);

			if (!$disallowed_login_id)
			{
				trigger_error($user->lang['NO_LOGINNAME_SPECIFIED'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$sql = 'DELETE FROM ' . DISALLOW_LOGIN_TABLE . '
				WHERE disallow_login_id = ' . $disallowed_login_id;
			$db->sql_query($sql);

			$cache->destroy('_disallowed_loginnames');

			add_log('admin', 'LOG_DISALLOW_LOGIN_DELETE');

			trigger_error($user->lang['DISALLOWED_LOGIN_DELETED'] . adm_back_link($this->u_action));
		}

		// Grab the current list of disallowed usernames...
		$sql = 'SELECT *
			FROM ' . DISALLOW_LOGIN_TABLE;
		$result = $db->sql_query($sql);

		$disallow_select = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$disallow_select .= '<option value="' . $row['disallow_login_id'] . '">' . str_replace('%', '*', $row['disallow_loginname']) . '</option>';
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'S_DISALLOWED_LOGIN_NAMES'	=> $disallow_select)
		);
	}
}

?>