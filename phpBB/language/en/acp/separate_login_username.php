<?php
/**
*
* acp_separate_login_username [English]
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

// separate Login and Username
$lang = array_merge($lang, array(
	'ALLOW_LOGINNAME_CHANGE'			=> 'Allow login name changes',
	
	'LOGINNAME_ALPHA_ONLY'				=> 'Alphanumeric only',
	'LOGINNAME_ALPHA_SPACERS'			=> 'Alphanumeric and spacers',
	'LOGINNAME_ASCII'					=> 'ASCII (no international unicode)',
	'LOGINNAME_LETTER_NUM'				=> 'Any letter and number',
	'LOGINNAME_LETTER_NUM_SPACERS'		=> 'Any letter, number, and spacer',
	'LOGINNAME_CHARS'					=> 'Limit login name chars',
	'LOGINNAME_CHARS_ANY'				=> 'Any character',
	'LOGINNAME_CHARS_EXPLAIN'			=> 'Restrict type of characters that may be used in login names, spacers are: space, -, +, _, [ and ].',
	'LOGINNAME_LENGTH'					=> 'Login name length',
	'LOGINNAME_LENGTH_EXPLAIN'			=> 'Minimum and maximum number of characters in login names.',

	'ACP_DISALLOW_LOGIN_EXPLAIN'		=> 'Here you can control login names which will not be allowed to be used. Disallowed login names are allowed to contain a wildcard character of *. Please note that you will not be allowed to specify any login name that has already been used, you must first delete that name then disallow it.',
	'ADD_DISALLOW_LOGIN_EXPLAIN'		=> 'You can disallow a login name using the wildcard character * to match any character.',
	'ADD_DISALLOW_LOGIN_TITLE'			=> 'Add a disallowed login name',

	'DELETE_DISALLOW_LOGIN_EXPLAIN'		=> 'You can remove a disallowed login name by selecting the login name from this list and clicking submit.',
	'DELETE_DISALLOW_LOGIN_TITLE'		=> 'Remove a disallowed login name',
	'DISALLOWED_LOGIN_ALREADY'			=> 'The login name you entered could not be disallowed. It either already exists in the list, exists in the word censor list, or a matching login name is present.',
	'DISALLOWED_LOGIN_DELETED'			=> 'The disallowed login name has been successfully removed.',
	'DISALLOW_LOGIN_SUCCESSFUL'			=> 'The disallowed login name has been successfully added.',

	'NO_DISALLOWED_LOGIN'				=> 'No disallowed login names',
	'NO_LOGINNAME_SPECIFIED'			=> 'You have not selected or entered a login name to operate with.',

));

?>