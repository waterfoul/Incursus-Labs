<?php
	/* connect to server, login and get TeamSpeak3_Node_Host object by URI */
	$ts3_ServerInstance = TeamSpeak3::factory("serverquery://phpUser:OJRuXDTg@localhost/");
	
	/* display server select form */
	$servers = $ts3_ServerInstance->serverList();
	
	foreach($servers as $v)
	  	foreach($v->clientList() as $client)
  		{
  			$client->poke("test");
		}