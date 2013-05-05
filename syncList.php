<?php
	include("config.php");
	include("apiSync/APIkey.php");
	include("apiSync/syncPermissions.php");
	if (!defined('DS')) {
  define('DS', '/');
}

// Get the base dir of Yapeal.
$dir = str_replace('\\', DS, dirname(__FILE__)) . DS . 'yapeal' . DS;

// Load basic files for utils to run.
require_once $dir . 'inc' . DS . 'common_paths.php';
// Only needed if your existing custom autoload doesn't work for Yapeal.
// See note below.
require_once YAPEAL_CLASS . 'YapealAutoLoad.php';
require_once YAPEAL_INC   . 'getSettingsFromIniFile.php';

// Activate Yapeal auto loader to load classes automatic.
// Note this is optional if you have an existing autoloader that will
// also handle the classes and interfaces for Yapeal.
YapealAutoLoad::activateAutoLoad();

// Get settings from yapeal.ini
$iniVars = getSettingsFromIniFile();

// Define from Yapeal settings if Yapeal trace is enabled.
if (!defined('YAPEAL_TRACE_ENABLED')){
  define('YAPEAL_TRACE_ENABLED', $iniVars['Logging']['trace_enabled']);
}

// Let Yapeal know what settings to use to connect to the database.
YapealDBConnection::setDatabaseSectionConstants($iniVars['Database']);

// Clean up settings that we don't need any more.
unset($iniVars);
	sync_all_permissions($mysql_host, $mysql_yapeal_db, $mysql_eve_dbDump, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password);
?>
