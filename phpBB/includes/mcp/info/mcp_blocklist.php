<?php
/**
*
* @package mcp
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class mcp_ban_info
{
	function module()
	{
		return array(
			'filename'	=> 'mcp_blocklisen',
			'title'		=> 'MCP_BAN',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'user'		=> array('title' => 'MCP_BAN_USERNAMES', 'auth' => 'acl_m_ban', 'cat' => array('MCP_BAN'))
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