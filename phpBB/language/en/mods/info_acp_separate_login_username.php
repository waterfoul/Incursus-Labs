<?php
/**
*
* info_acp_separate_login_username [English]
*
* @package language
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

$lang = array_merge($lang, array(
	//ACP
	'ACP_DISALLOW_LOGIN'					=> 'Disallow',
	'ACP_DISALLOW_LOGINNAMES'				=> 'Disallow login names',
	'LOG_USER_UPDATE_LOGINNAME'				=> '<strong>Changed login name</strong><br />» from "%1$s" to "%2$s"',
	'LOG_DISALLOW_LOGIN_ADD'				=> '<strong>Added disallowed login name</strong><br />>> %s',
	'LOG_DISALLOW_LOGIN_DELETE'				=> '<strong>Deleted disallowed login name</strong>',	
	
	//UCP
	'INVALID_CHARS_LOGINNAME'				=> 'The login name contains forbidden characters.',
	'USERNAME_IS_ALREADY_LOGINNAME'			=> 'The username you entered is already used as a login name, please select an alternative.',
	'LOGINNAME_IS_ALREADY_USERNAME'			=> 'The login name you entered is already used as a username, please select an alternative.',	
	'LOGINNAME_ALPHA_ONLY_EXPLAIN'			=> 'Login name must be between %1$d and %2$d chars long and use only alphanumeric characters.',
	'LOGINNAME_ALPHA_SPACERS_EXPLAIN'		=> 'Login name must be between %1$d and %2$d chars long and use alphanumeric, space or -+_[] characters.',
	'LOGINNAME_ASCII_EXPLAIN'				=> 'Login name must be between %1$d and %2$d chars long and use only ASCII characters, so no special symbols.',
	'LOGINNAME_LETTER_NUM_EXPLAIN'			=> 'Login name must be between %1$d and %2$d chars long and use only letter or number characters.',
	'LOGINNAME_LETTER_NUM_SPACERS_EXPLAIN'	=> 'Login name must be between %1$d and %2$d chars long and use letter, number, space or -+_[] characters.',
	'LOGINNAME_CHARS_ANY_EXPLAIN'			=> 'Length must be between %1$d and %2$d characters.',
	'LOGINNAME_TAKEN_LOGINNAME'				=> 'The login name you entered is already in use, please select an alternative.',
	'LOGINNAME_DISALLOWED_LOGINNAME'		=> 'The login name you entered has been disallowed or contains a disallowed word. Please choose a different name.',
));

?>