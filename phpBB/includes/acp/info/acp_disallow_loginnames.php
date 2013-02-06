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

if (!defined('IN_PHPBB'))
{
	exit;
}

class acp_disallow_loginnames_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_disallow_loginnames',
			'title'		=> 'ACP_DISALLOW_LOGINNAMES',
			'version'	=> '1.0.7',
			'modes'		=> array(
			'usernames'		=> array('title' => 'ACP_DISALLOW_LOGINNAMES', 'auth' => 'acl_a_loginnames', 'cat' => array('ACP_USER_SECURITY')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}


?>