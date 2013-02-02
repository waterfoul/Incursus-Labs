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
class mcp_blocklist_info
{
	function module()
	{
		return array(
			'filename'	=> 'mcp_blocklist',
			'title'		=> 'MCP_BLOCKLIST',
			'version'	=> '1.0.0',
			'modes'		=> array(
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