<?php
/**
 * returns profile xml based on ajax call 
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
define('IN_PHPBB', true);
define('ADMIN_START', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../phpBB/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
include($phpbb_root_path . 'includes/message_parser.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup('posting');
if(!$auth->acl_get('a_'))
	exit();
	

	include("../config.php");
	$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
	if($_GET["ADD"]){
		$phpBB->query("INSERT INTO  `Incusus_phpBB`.`eve_blocklist` (`id` ,`Type` ,`Name`) VALUES (NULL ,  '" . $phpBB->escape_string($_GET["TYPE"]) . "',  '" . $phpBB->escape_string($_GET["ADD"]) . "')");
		print($phpBB->insert_id);
	}
	if($_GET["REMOVE"])
		$phpBB->query("DELETE FROM `Incusus_phpBB`.`eve_blocklist` WHERE `eve_blocklist`.`id` = " . $phpBB->escape_string($_GET["REMOVE"]) . ",this);");


garbage_collection();
exit_handler();
?>
