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
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'SEPARATE_LOGIN_USERNAME_MOD';

/*
* The name of the config variable which will hold the currently installed version
* You do not need to set this yourself, UMIL will handle setting and updating the version itself.
*/

$version_config_name = 'separate_login_username_version';

/*
* The language file which will be included when installing
* Language entries that should exist in the language file for UMIL (replace $mod_name with the mod's name you set to $mod_name above)
*/
$language_file = 'mods/separate_login_username';

/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/

/**
* Define the basic structure
* The format:
*		array('{TABLE_NAME}' => {TABLE_DATA})
*		{TABLE_DATA}:
*			COLUMNS = array({column_name} = array({column_type}, {default}, {auto_increment}))
*			PRIMARY_KEY = {column_name(s)}
*			KEYS = array({key_name} = array({key_type}, {column_name(s)})),
*
*	Column Types:
*	INT:x		=> SIGNED int(x)
*	BINT		=> BIGINT
*	UINT		=> mediumint(8) UNSIGNED
*	UINT:x		=> int(x) UNSIGNED
*	TINT:x		=> tinyint(x)
*	USINT		=> smallint(4) UNSIGNED (for _order columns)
*	BOOL		=> tinyint(1) UNSIGNED
*	VCHAR		=> varchar(255)
*	CHAR:x		=> char(x)
*	XSTEXT_UNI	=> text for storing 100 characters (topic_title for example)
*	STEXT_UNI	=> text for storing 255 characters (normal input field with a max of 255 single-byte chars) - same as VCHAR_UNI
*	TEXT_UNI	=> text for storing 3000 characters (short text, descriptions, comments, etc.)
*	MTEXT_UNI	=> mediumtext (post text, large text)
*	VCHAR:x		=> varchar(x)
*	TIMESTAMP	=> int(11) UNSIGNED
*	DECIMAL		=> decimal number (5,2)
*	DECIMAL:		=> decimal number (x,2)
*	PDECIMAL		=> precision decimal number (6,3)
*	PDECIMAL:	=> precision decimal number (x,3)
*	VCHAR_UNI	=> varchar(255) BINARY
*	VCHAR_CI		=> varchar_ci for postgresql, others VCHAR
*/

$versions = array(
	// Version 1.0.0 - this is the first version using UMIL
	'1.0.0'	=> array(
		// Add fields in the users table
		'table_column_add' => array(
			array($table_prefix . 'users', 'loginname', array('VCHAR', '')),
			array($table_prefix . 'users', 'loginname_clean', array('VCHAR', '')),
		),

		// Now to add some permission settings
		'permission_add' => array(
			array('a_loginnames', true),
			array('u_chgloginname', true),
		),
   

		// Now to add the tables (this uses the layout from develop/create_schema_files.php and from phpbb_db_tools)
		'table_add' => array(

			array($table_prefix . 'disallow_login', array(
					'COLUMNS'						=> array(
						'disallow_login_id'			=> array('UINT', NULL, 'auto_increment'),
						'disallow_loginname'		=> array('VCHAR', NULL),
					),
					'PRIMARY_KEY'	=> 'disallow_login_id',
				),
			),

		),

		// Clear the general cache as well as the templates, imagesets and themes cache
		'cache_purge' => array(
			array(),
			array('imageset'),
			array('template'),
			array('theme'),
		),

		// Alright, now lets add some modules to the ACP
		'module_add' => array(

			// Now we will add the settings mode to the ACP_POINTS category
			array('acp', 'ACP_USER_SECURITY', array(
					'module_basename'	=> 'disallow_loginnames',
					'module_langname'	=> 'ACP_DISALLOW_LOGINNAMES',
					'module_mode'		=> 'acp_disallow_loginnames',
					'module_auth'		=> 'acl_a_loginnames',
				),
			),


		),

		/*
		* Now we need to insert some data.  The easiest way to do that is through a custom function
		* Enter 'custom' for the array key and the name of the function for the value.
		*/
		'custom'	=> 'first_fill_1_0_0',
	),
	


	// Version 1.0.8 only update Version
	'1.0.8'		=> array(),	
	
);

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

/*
* Here is our custom function that will be called for version 1.0.0
*
* @param string $action The action (install|update|uninstall) will be sent through this.
* @param string $version The version this is being run for will be sent through this.
*/
function first_fill_1_0_0($action, $version)
{
	global $db, $table_prefix, $umil;

	switch ($action)
	{
		case 'install' :    
			// Run this when installing the first time
			if ($umil->table_exists($table_prefix . 'config'))
			{
				$sql_ary = array();

				$sql_ary[] = array('config_name' => 'allow_loginnamechange',			'config_value' => '0',);
				$sql_ary[] = array('config_name' => 'max_loginname_chars',				'config_value' => '20',);
				$sql_ary[] = array('config_name' => 'min_loginname_chars',				'config_value' => '3',);
				$sql_ary[] = array('config_name' => 'allow_loginname_chars',			'config_value' => 'LOGINNAME_CHARS_ANY',);
				$sql_ary[] = array('config_name' => 'separate_login_username_version',	'config_value' => '1.0.8',);				
				$db->sql_multi_insert($table_prefix . 'config ', $sql_ary);
								
			}
			
			if ($umil->table_exists($table_prefix . 'users'))
			{		
				$sql = 'UPDATE ' . USERS_TABLE . ' 
					SET loginname = username ';
				$db->sql_query($sql);
		
				$sql = 'UPDATE ' . USERS_TABLE . ' 
					SET loginname_clean = username_clean ';
				$db->sql_query($sql);
			}


			// Send the message, that the command was successful
			return 'SEPARATE_LOGIN_USERNAME_MOD_INSTALLED';
		break;

		case 'update' :	
		break;

 		case 'uninstall' :
			// Run this additionally when uninstalling
			if ($umil->table_exists($table_prefix . 'config'))
			{
				$sql = 'DELETE FROM ' . $table_prefix . "config
					WHERE config_name = 'allow_loginnamechange'";
				$db->sql_query($sql);
				$sql = 'DELETE FROM ' . $table_prefix . "config
					WHERE config_name = 'max_loginname_chars'";
				$db->sql_query($sql);
				$sql = 'DELETE FROM ' . $table_prefix . "config
					WHERE config_name = 'min_loginname_chars'";
				$db->sql_query($sql);
				$sql = 'DELETE FROM ' . $table_prefix . "config
					WHERE config_name = 'allow_loginname_chars'";
				$db->sql_query($sql);
			}

			// Send the message, that the command was successful
			return 'SEPARATE_LOGIN_USERNAME_MOD_UNSTALLED';
		break;
	}
}


?>