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
* @package module_install
*/
class acp_blocklist_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_blocklist',
			'title'		=> 'ACP_BLOCKLIST',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'info'		=> array('title' => 'ACP_BLOCKLIST', 'auth' => 'acl_a_blocklist', 'cat' => array('')),
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