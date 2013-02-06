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
	// main title
	'SEPARATE_LOGIN_USERNAME_MOD'				=> 'Separate Login and Username modification',
	'SEPARATE_LOGIN_USERNAME_MOD_EXPLAIN'		=> 'The Separate Login and Username Modification allows Registered users to separate their username from their loginname. The modification can be enabled or disbaled via the ACP by the Board admin with permissions assignable via groups or per user.',

	// permission/login stuff	
	//'NO_ADMIN'								=> 'Access to the Installation Panel is not allowed as you do not have administrative permissions.',
	//'LOGIN_ADMIN_CONFIRM'						=> 'To access the Installation Panel you must re-authenticate yourself.',
	//'LOGIN_ADMIN_SUCCESS'						=> 'You have successfully authenticated and will now be redirected to the Installation Panel.',

	// installation stuff
	'SEPARATE_LOGIN_USERNAME_MOD_INSTALLED'		=> 'The Separate Login and Username modification has been installed successfully. Please remove the umil directory from your server.',
	'SEPARATE_LOGIN_USERNAME_MOD_UNSTALLED'		=> 'The Separate Login and Username modification has been unstalled successfully. Please remove the umil directory from your server.',
	'SEPARATE_LOGIN_USERNAME_MOD_UPDATED'		=> 'The Separate Login and Username modification has been updated to version %s successfully.',
	'ALREADY_INSTALLED'							=> 'The Separate Login and Username modification has already been installed.',
	'ALREADY_NOT_INSTALLED'						=> 'The Separate Login and Username modification hasn´t been installed yet or is up to date.',
	'NOTHING_TO_INSTALL'						=> 'There is nothing left for you to do except delete the install folder.',
	'CANNOT_DELETE'         					=> 'It´s not possible to delete the install folder, please delete it manually.',

	// return messages
	'DELETE_SELF'								=> '%sAttempt to delete the install folder%s',
	'RETURN_INSTALL'							=> '%sReturn to the Installation Panel%s',

));

?>