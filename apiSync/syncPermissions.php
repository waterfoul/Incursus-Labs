<?php
	function sync_permissions($uid)
	{
		
	}
	function sync_all_permissions($mysql_host, $mysql_yapeal_db, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password)
	{
		$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
		$yapeal = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_yapeal_db);
		
		$qry = $yapeal->query("SELECT keyID, accessMask FROM  `accountAPIKeyInfo`");
		while($row = $qry->fetch_object())
		{
			$regKey = new RegisteredKey($row->keyID);
			if ($regKey->recordExists() && $regKey->isActive && $regKey->activeAPIMask != $row->accessMask)
			{
				$regKey->activeAPIMask = $row->accessMask;
				$regKey->store();
			}
			
			$qry2 = $yapeal->query("SELECT characterID FROM  `accountKeyBridge` WHERE keyID = " . $row->keyID);
			while($row2 -> $qry2->fetch_object())
			{
				$char = new RegisteredCharacter($row2->characterID);
				if(!$char->recordExists() || !$char->isActive || $regKey->activeAPIMask != $row->accessMask)
				{
					$char->activeAPIMask = $row->accessMask;
					$char->isActive = 1;
					$char->store();
				}
			}
		}
		
		$qry=$phpBB->query('SELECT user_id,pf_api_key FROM  `phpbb_profile_fields_data`');
		while($row = $qry->fetch_object())
		{
			$key = explode(":",$row->pf_api_key);
			$mask=$yapeal->query("SELECT accessMask FROM  `accountAPIKeyInfo` WHERE keyID = " . $key[0])->fetch_object()->accessMask;
			$qry2=$yapeal->query("SELECT characterID FROM  `accountKeyBridge` WHERE keyID = " . $key[0]);
			while($row2=$qry2->fetch_object())
			{
				if(($mask & 8913152)==8913152)
				{
					print("DEFCON 3");
					if(($mask & 90179600)==90179600)
					{
						print("DEFCON 2");
						if(($mask & 393226)==393226)
						{
							print("DEFCON 1");
						}
					}
				}
			}
		}
	}
?>
