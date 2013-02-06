<?php
/**
*
* @package phpBB3
* @version $Id$
* @copyright (c) 2010 xceler8shun
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Permissions
$lang = array_merge($lang, array(
	// Admin perms
	'acl_a_loginnames'		=> array('lang' => 'Can manage disallowed login names', 'cat' => 'user_group'),
	
	// User perms
	'acl_u_chgloginname'	=> array('lang' => 'Can change login name', 'cat' => 'profile'),
));

?>