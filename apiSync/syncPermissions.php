<?php
	function sync_permissions($uid)
	{
		
	}
	function sync_all_permissions($mysql_host, $mysql_yapeal_db, $mysql_eve_dbDump, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password)
	{
		$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
		$yapeal = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_yapeal_db);
		$dbDump = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_eve_dbDump);
		
		/* Sync the api and character lists */
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
			while($row2=$qry2->fetch_object())
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
		
		$block = array(
			0=>array(
				"Character"=>array(),
				"Corporation"=>array(),
				"Alliance"=>array(),
			),
			1=>array(
				"Character"=>array(),
				"Corporation"=>array(),
				"Alliance"=>array(),
			),
			2=>array(
				"Character"=>array(),
				"Corporation"=>array(),
				"Alliance"=>array(),
			),
			3=>array(
				"Character"=>array(),
				"Corporation"=>array(),
				"Alliance"=>array(),
			),
		);
		$qry=$phpBB->query('SELECT Type,Name,list FROM  `eve_blocklist`');
		while($row = $qry->fetch_object())
			$block[$row->list][$row->Type][] = strtolower($row->Name);
		
		/* Determine roles */
		$qry=$phpBB->query('SELECT d.user_id, u.username, d.pf_api_key, d.pf_api_key_corp, d.pf_api_key_lowsec, d.pf_override_min_time, u.user_regdate, u.group_id FROM `phpbb_profile_fields_data` as d LEFT JOIN phpbb_users as u ON d.user_id = u.user_id');
		while($row = $qry->fetch_object())
		{
			$key = explode(":",$row->pf_api_key);
			$mask=$yapeal->query("SELECT accessMask FROM  `accountAPIKeyInfo` WHERE keyID = " . $key[0]);
			if(!$mask)
			{
				setRoles($row->user_id,$row->username,5,$row->group_id,$phpBB);
				continue;
			}
			$mask = $mask->fetch_object()->accessMask;
			$qry2=$yapeal->query("SELECT characterID FROM  `accountKeyBridge` WHERE keyID = " . $key[0]);
			$chars = array();
			$charIds = array();
			$corps = array();
			$alliances = array();
			while($row2=$qry2->fetch_object())
			{
				$qry3=$yapeal->query("SELECT characterName,corporationID,corporationName FROM  `accountCharacters` WHERE characterID = " . $row2->characterID);
				$row3 = $qry3->fetch_object();
				$charIds[] = $row2->characterID;
				$chars[] = strtolower($row3->characterName);
				$corps[] = strtolower($row3->corporationName);
				$qry4=$yapeal->query("SELECT l.name FROM  `eveMemberCorporations` as m LEFT JOIN eveAllianceList as l ON m.allianceID = l.allianceID WHERE m.corporationID = " . $row3->corporationID);
				if($row4 = $qry4->fetch_object())
					$alliances[] = strtolower($row4->name);
			}
			$blocklevel = 0;
			foreach($chars as $v)
				if($blocklevel < 3 && in_array($v, $block[0]["Character"]))
					$blocklevel = 3;
				else if($blocklevel < 2 && in_array($v, $block[1]["Character"]))
					$blocklevel = 2;
				else if($blocklevel < 1 && in_array($v, $block[2]["Character"]))
					$blocklevel = 1;
			foreach($corps as $v)
				if($blocklevel < 3 && in_array($v, $block[0]["Corporation"]))
					$blocklevel = 3;
				else if($blocklevel < 2 && in_array($v, $block[1]["Corporation"]))
					$blocklevel = 2;
				else if($blocklevel < 1 && in_array($v, $block[2]["Corporation"]))
					$blocklevel = 1;
			foreach($alliances as $v)
				if($blocklevel < 3 && in_array($v, $block[0]["Alliance"]))
					$blocklevel = 3;
				else if($blocklevel < 2 && in_array($v, $block[1]["Alliance"]))
					$blocklevel = 2;
				else if($blocklevel < 1 && in_array($v, $block[2]["Alliance"]))
					$blocklevel = 1;
			
			if($blocklevel < 3 && isGanking($charIds, $mysql_eve_dbDump, $yapeal) === false)
				if(($mask & 8913152)==8913152  &&
				(
					$row->pf_api_key_corp == 1 ||
					$row->pf_override_min_time == 1 ||
					((time() - $row->user_regdate)/60/60/24) > 30
				))
					if(($mask & 90179600)==90179600 && $blocklevel < 2 && isSendingIsk($charIds, $yapeal, $block[3]) === false && $row->pf_api_key_lowsec == 1)
					{
						mailNotify($charIds, $row->username, $yapeal, $block[3]);
						if(($mask & 393226)==393226 && $blocklevel < 1 && $row->pf_api_key_corp == 1)
						{
							/*TODO:Add corp check*/
							setRoles($row->user_id,$row->username,1,$row->group_id,$phpBB);
						}
						else
							setRoles($row->user_id,$row->username,2,$row->group_id,$phpBB);
					}
					else
						setRoles($row->user_id,$row->username,3,$row->group_id,$phpBB);
				else
					setRoles($row->user_id,$row->username,4,$row->group_id,$phpBB);
			else
				setRoles($row->user_id,$row->username,5,$row->group_id,$phpBB);
		}
	}
	function setRoles($user_id,$user_name,$defcon,$oldgroup,$phpBB)
	{
		$groupid = -1;
		switch($defcon)
		{
			case 1:
				$groupid =  10;
				$phpBB->query("UPDATE phpbb_profile_fields_data SET pf_api_key_basic = 1, pf_api_key_community = 1 WHERE user_id = " . $user_id);
				break;
			case 2:
				$groupid =  9;
                $phpBB->query("UPDATE phpbb_profile_fields_data SET pf_api_key_basic = 1, pf_api_key_community = 1 WHERE user_id = " . $user_id);
				break;
			case 3:
				$groupid =  8;
                $phpBB->query("UPDATE phpbb_profile_fields_data SET pf_api_key_basic = 1, pf_api_key_community = 1 WHERE user_id = " . $user_id);
				break;
			case 4:
				$groupid =  11;
                $phpBB->query("UPDATE phpbb_profile_fields_data SET pf_api_key_basic = 1, pf_api_key_community = 0 WHERE user_id = " . $user_id);
				break;
			case 5:
				$groupid =  2;
                $phpBB->query("UPDATE phpbb_profile_fields_data SET pf_api_key_basic = 0, pf_api_key_community = 0 WHERE user_id = " . $user_id);
				break;
		}
		foreach(array(10,9,8,11,2) as $g)
		{
			if($g == $groupid)
				$phpBB->query("INSERT INTO `Incusus_phpBB`.`phpbb_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('" . $g . "', '" . $user_id . "', '0', '0');");
			$phpBB->query("DELETE FROM `phpbb_user_group` WHERE `phpbb_user_group`.`group_id` = " . $g . " AND `phpbb_user_group`.`user_id` = " . $user_id . ";" );
		}
		$phpBB->query("UPDATE phpbb_users SET group_id = " . $groupid . " WHERE user_id = " . $user_id );
		if($groupid != $oldgroup)
		{
			if(
				($oldgroup == 10) ||
				($oldgroup == 9 && $groupid != 10) ||
				($oldgroup == 8 && $groupid != 10 && $groupid != 9) ||
				($oldgroup == 11 && $groupid == 2)
			)
			{
				mail("IncursusForums@gmail.com", "USER DEMOTED", $user_name);
			}
		}
		
	}
	function isGanking($characterIds, $mysql_eve_dbDump, $yapeal)
	{
		foreach($characterIds as $char)
		{
			$qry = $yapeal->query("
			SELECT
				a.killID				
			FROM
				charAttackers as a
				LEFT JOIN charVictim as v ON a.killID = v.killID
				LEFT JOIN charKillLog as k ON a.killID = k.killID
				LEFT JOIN " . $mysql_eve_dbDump . ".mapSolarSystems as s ON k.solarSystemID = s.solarSystemID
				LEFT JOIN " . $mysql_eve_dbDump . ".invItems as i ON v.shipTypeID = i.typeID
				LEFT JOIN " . $mysql_eve_dbDump . ".invTypes as t ON i.typeID = t.typeID
			WHERE
				a.characterID = " . $char . "
				AND a.verifiedOK != 1
				AND s.security > 0.4
				AND t.groupID NOT IN (28, 29, 31, 237, 380, 463, 513, 543, 902, 941)" //Industrial, Capsule, Shuttle, Rookie ship, Transport Ship, Mining Barge, Freighter, Exhumer, Jump Freighter, Industrial Command Ship 
			);
			if($row = $qry->fetch_object())
				return $row->killID;
			$qry = $yapeal->query("
			SELECT
				a.killID				
			FROM
				charAttackers as a
				LEFT JOIN charVictim as v ON a.killID = v.killID
				LEFT JOIN charKillLog as k ON a.killID = k.killID
				LEFT JOIN " . $mysql_eve_dbDump . ".mapSolarSystems as s ON k.solarSystemID = s.solarSystemID
				LEFT JOIN " . $mysql_eve_dbDump . ".invItems as i ON v.shipTypeID = i.typeID
				LEFT JOIN " . $mysql_eve_dbDump . ".invTypes as t ON i.typeID = t.typeID
			WHERE
				a.characterID = " . $char . "
				AND a.verifiedOK != 1
				AND s.security > 0.4
				AND t.groupID IN (28, 380, 513, 902, 941)" //Industrial, Transport Ship, Freighter, Jump Freighter, Industrial Command Ship 
			);
			if($row = $qry->fetch_object())
			{
				$qry2 = $yapeal->query("
				SELECT
					c.killID
				FROM
					charItems as c
					LEFT JOIN " . $mysql_eve_dbDump . ".invItems as i ON v.shipTypeID = i.typeID
					LEFT JOIN " . $mysql_eve_dbDump . ".invTypes as t ON i.typeID = t.typeID
					LEFT JOIN " . $mysql_eve_dbDump . ".invGroups as g ON t.groupID = g.groupID
				WHERE
					c.killID = " . $row->killID . "
					AND `lft` != `rgt`-1
					AND g.categoryID = 6
					AND t.groupID NOT IN (28, 29, 31, 237, 380, 463, 513, 543, 902, 941)" //Industrial, Capsule, Shuttle, Rookie ship, Transport Ship, Mining Barge, Freighter, Exhumer, Jump Freighter, Industrial Command Ship
				);
				if($row2 = $qry->fetch_object())
					return $row->killID;
			}
		}
		return false;
	}
	function isSendingIsk($characterIds, $yapeal, $blocklist)
	{
		foreach($characterIds as $char)
		{
			$qry = $yapeal->query(
				"SELECT w.`refID`, w.`ownerID2`, w.`ownerName2` FROM
	    			`charWalletJournal` as w 
				 WHERE
					w.`verifiedOK` != 1
	     			AND w.`refTypeID` IN (0, 1, 6, 10, 35, 37, 71)
	      			AND w.`ownerID1` = " . $char
			);
			$char = true;
			while($row = $qry->fetch_object())
			{
				if(id_on_blocklist($row->ownerID2, $row->ownerName2, $yapeal, $blocklist))
					return $row->refID;
				$yapeal->query("UPDATE charWalletJournal SET verifiedOK = 1 WHERE refID = " . $row->refID);
			}
		}
		return false;
	}
	function mailNotify($characterIds, $name, $yapeal, $blocklist)
	{
		foreach($characterIds as $char)
		{
		$utc = new DateTimeZone("UTC");
			$qry = $yapeal->query(
				"SELECT m.`ownerID`, m.`messageID`, m.`title`, m.`messageID`, m.`toCharacterIDs`, m.`toCorpOrAllianceID` FROM
	    			`charMailMessages` as m
				 WHERE
					m.`mailSent` != 1
	      			AND m.`ownerID` = m.`senderID`
	      			AND m.`ownerID` = " . $char
			);
			$char = true;
			while($row = $qry->fetch_object())
			{
				$sendmail = false;
				$chars = split(",", $row->toCharacterIDs);
				foreach($chars as $c)
				{
					$char = get_char_from_cust($c, $utc);
					if(	$char != null && (
						in_array(strtolower($char->characterName), $blocklist["Character"]) ||
						in_array(strtolower($char->corporation), $blocklist["Corporation"]) ||
						in_array(strtolower($char->alliance), $blocklist["Alliance"])
					))
						$sendmail = $char->characterName . " (" . $char->corporation . "/" . $char->alliance . ")";
				}
				$corpOrAlliance = $row->toCorpOrAllianceID;
				$corp = get_corp_from_cust($id, $utc);
				if($sendmail === false && $corp != null)
				{
					if(in_array(strtolower($corp->corpName), $blocklist["Corporation"]))
						$sendmail = $corp->corpName;
					$qry4=$yapeal->query("SELECT l.name FROM `eveMemberCorporations` as m LEFT JOIN eveAllianceList as l ON m.allianceID = l.allianceID WHERE m.corporationID = " . $corp->corpID);
					if($row4 = $qry4->fetch_object() && in_array(strtolower($row4->name), $blocklist["Alliance"]))
						$sendmail = $corp->corpName . " (" . $row4->name . ")";
				}
				$alliance=$yapeal->query("SELECT l.name FROM eveAllianceList as l WHERE l.allianceID = " . $id);
				if($sendmail === false && $alliance != null && in_array(strtolower($alliance->name), $blocklist["Alliance"]))
					$sendmail = $alliance->name;
				if($sendmail !== false)
				{
					if(mail("IncursusForums@gmail.com", "Evemail Flagged", "User: " . $name . "\nTo: " . $sendmail . "\nSubject: " . $row->title))
						$yapeal->query("UPDATE charMailMessages SET mailSent = 1 WHERE messageID = " . $row->messageID);
				}
				else
					$yapeal->query("UPDATE charMailMessages SET mailSent = 1 WHERE messageID = " . $row->messageID);
			}
		}
		return false;
	}
	
	function id_on_blocklist($id, $name, $yapeal, $blocklist)
	{
		$utc = new DateTimeZone("UTC");
		$row2 = get_char_from_cust($id, $utc);
		if($row2 == null || strtolower($row2->characterName) != strtolower($name))
		{
			$row3 = get_corp_from_cust($id, $utc);
			if($row3 == null || strtolower($row3->corpName) != strtolower($name))
			{
				if(in_array(strtolower($name), $blocklist["Alliance"]))
					return true;
			}
			else
			{
				$qry4=$yapeal->query("SELECT l.name FROM `eveMemberCorporations` as m LEFT JOIN eveAllianceList as l ON m.allianceID = l.allianceID WHERE m.corporationID = " . $row3->corpID);
				if(($row4 = $qry4->fetch_object() && in_array(strtolower($row4->name), $blocklist["Alliance"])) ||
					in_array(strtolower($row3->corpID), $blocklist["Corporation"])
				)
					return true;
			}
			
		}
		else if(
			in_array(strtolower($row2->characterName), $blocklist["Character"]) ||
			in_array(strtolower($row2->corporation), $blocklist["Corporation"]) ||
			in_array(strtolower($row2->alliance), $blocklist["Alliance"])
		)
			return true;
		return false;
	}
	function get_char_from_cust($id, $utc)
	{
		$qry2 = $yapeal->query(
			"SELECT i.`characterName`, i.`corporation`, i.`alliance`, i.`cachedUntil` FROM
    			`custom_characterInfo` as i
			 WHERE
				characterID = " . $id
		);
		$row2 = null;
		if(!($row2 = $qry2->fetch_object()) || DateTime::createFromFormat("Y-m-d H:i:s", $row2->cachedUntil, $utc) < new DateTime())
		{
			$xml = simplexml_load_file("https://api.eveonline.com/eve/CharacterInfo.xml.aspx?characterID=" . $id);
			if(!empty($xml->error))
				continue;
			$yapeal->query(
				"INSERT INTO `Incursus_yapeal`.`custom_characterInfo`
				(`characterID`, `characterName`, `race`, `bloodline`, `corporationID`, `corporation`,
					`corporationDate`, `allianceID`, `alliance`, `allianceDate`, `securityStatus`, `cachedUntil`) VALUES
				('" . $xml->result->characterID . "', '" . $xml->result->characterName . "', '" . $xml->result->race . "', '" . $xml->result->bloodline . "', '" . $xml->result->corporationID . "', '" . $xml->result->corporation . "',
					'" . $xml->result->corporationDate . "', '" . $xml->result->allianceID . "', '" . $xml->result->alliance . "', '" . $xml->result->allianceDate . "', '" . $xml->result->securityStatus . "', '" . $xml->cachedUntil . "');"
			);
			
			$qry2 = $yapeal->query(
				"SELECT i.`characterName`, i.`corporation`, i.`alliance`, i.`cachedUntil` FROM
	    			`custom_characterInfo` as i
				 WHERE
					characterID = " . $id
			);
			$row2 = $qry2->fetch_object();
			if(!$row2)
				return null;
		}
		return $row2;
	}
	function get_corp_from_cust($id, $utc)
	{
		$qry3 = $yapeal->query(
			"SELECT * FROM
    			`custom_corpInfo` as i
			 WHERE
				corpID = " . $id
		);
		$row3 = null;
		if(!($row3 = $qry3->fetch_object()) || DateTime::createFromFormat("Y-m-d H:i:s", $row3->cachedUntil, DateTimeZone::UTC) < new DateTime())
		{
			$xml = simplexml_load_file("https://api.eveonline.com/corp/CorporationSheet.xml.aspx?corporationID=" . $id);
			if(!empty($xml->error))
				continue;
			$yapeal->query(
				"INSERT INTO `Incursus_yapeal`.`custom_corpInfo`
				(`corpID`, `corpName`, `cachedUntil`) VALUES
				('" . $xml->result->corporationID . "', '" . $xml->result->corporationName . "', '" . $xml->cachedUntil . "');"
			);
			
			$qry3 = $yapeal->query(
				"SELECT * FROM
	    			`custom_corpInfo` as i
				 WHERE
					corpID = " . $id
			);
			$row3 = $qry3->fetch_object();
			if(!$row3)
				return null;
		}
		return $row3;
	}
?>
