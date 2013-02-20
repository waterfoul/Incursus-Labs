<?php
	require_once("TeamSpeak3/TeamSpeak3.php");
	/* connect to server, login and get TeamSpeak3_Node_Host object by URI */
	$ts3_ServerInstance = TeamSpeak3::factory("serverquery://serveradmin:aVMT3VfwUxSpME8x9DLehHBK@localhost:10011/");
	
	/* display server select form */
	$servers = $ts3_ServerInstance->serverList();
	
	foreach($servers as $v)
	  	foreach($v->clientList() as $client)
  		{
			try{
				$client->poke("test");
			}catch(TeamSpeak3_Adapter_ServerQuery_Exception $e){};
		}
