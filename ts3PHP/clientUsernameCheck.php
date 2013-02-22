<?php
	require_once("TeamSpeak3/TeamSpeak3.php");
	require_once("../config.php");
	error_reporting(E_ALL);
        ini_set('display_errors', '1');
	$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
	/* connect to server, login and get TeamSpeak3_Node_Host object by URI */
	$ts3_ServerInstance = TeamSpeak3::factory("serverquery://serveradmin:aVMT3VfwUxSpME8x9DLehHBK@localhost:10011/");
	
	/* display server select form */
	$servers = $ts3_ServerInstance->serverList();
	
	foreach($servers as $v)
	  	foreach($v->clientList() as $client)
  		{
			try{
				$qry = $phpBB->query("SELECT group_id, username FROM phpbb_profile_fields_data AS d LEFT JOIN phpbb_users AS u ON u.user_id = d.user_id WHERE d.pf_tskey = '" . $client->client_unique_identifier . "'");
				if($row = $qry->fetch_object())
				{
					$baseGroup = -1;
					switch($row->group_id)
			                {
			                        case 10:
			                                $baseGroup = 10;
				                break;
			                        case 9:
			                                $baseGroup = 12;
		                                break;
                			        case 8:
			                                $baseGroup = 11;
		                                break;
                			        case 11:
			                                $baseGroup = 9;
		                                break;
                			        case 2:
			                                $baseGroup = 8;
		                                break;
					}
					if($row->username != $client->client_nickname)
                                        {
                                                $client->poke("Please change your username to '" . $row->username . "' in order to recieve roles");
						$baseGroup = -1;
                                        }
					foreach(array(10, 12, 11, 9, 8) as $i)
					{
						if($baseGroup == $i)
							try{
								$client->addServerGroup($i);
							}catch(TeamSpeak3_Adapter_ServerQuery_Exception $e){}
						else
							try{
								$client->remServerGroup($i);
							}catch(TeamSpeak3_Adapter_ServerQuery_Exception $e){}
					}
				}
			}catch(TeamSpeak3_Adapter_ServerQuery_Exception $e){};
		}
