<?php
/**
 * returns profile xml based on ajax call 
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
define('IN_PHPBB', true);
define('ADMIN_START', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../phpBB';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
$role_id = request_var('role', 0);
$sql_array = array(
       'SELECT'    => 'r.role_id, r.role_name, ' ,  
       'FROM'      => array(
           RP_ROLES   => 'r'
       ),
       'ORDER_BY'  => 'r.role_id'
   );
if($role_id==1)
{
   $sql_array['SELECT'] .= 'r.role_needed1 as role_needed';   
}
else 
{
   $sql_array['SELECT'] .= 'r.role_needed2 as role_needed';
}

$sql = $db->sql_build_query('SELECT', $sql_array);
$result = $db->sql_query($sql);
header('Content-type: text/xml');
$xml = '<?xml version="1.0" encoding="UTF-8"?>
<rolelist>';
while ($row = $db->sql_fetchrow($result))
// preparing xml
{
    $xml .= '<role>'; 
    $xml .= "<role_id>" . $row['role_id'] . "</role_id>";
    $xml .= "<role_name>" . $row['role_name'] . "</role_name>";
    $xml .= "<role_needed>" . $row['role_needed'] . "</role_needed>";
    $xml .= '</role>';
}
$db->sql_freeresult($result);
$xml .= '</rolelist>';
//return xml to ajax
echo($xml); 
?>

<?php
/*	include("../config.php");
	$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
	if($_GET["ADD"])
		$phpBB->query("INSERT INTO  `Incusus_phpBB`.`eve_blocklist` (`id` ,`Type` ,`Name`) VALUES (NULL ,  '" . $phpBB->escape_string($_GET["TYPE"]) . "',  '" . $phpBB->escape_string($_GET["ADD"]) . "')");
	if($_GET["REMOVE"])
		$phpBB->query("DELETE FROM `Incusus_phpBB`.`eve_blocklist` WHERE `eve_blocklist`.`id` = " . $phpBB->escape_string($_GET["REMOVE"]) . ");");*/
?>