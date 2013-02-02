<?php
	function getAPIStatus($key, $vcode)
    {
            $xml = simplexml_load_file("https://api.eveonline.com/account/APIKeyInfo.xml.aspx?keyID=" . $key . "&vCode=" . $vcode);
            if(!empty($xml->error))
                    return("BAD KEY OR VCODE");
            if($xml->result->key->attributes()->type!="Account")
                    return("NOT ACCOUNT TYPE");
            $mask = $xml->result->key->attributes()->accessMask;
            $standings = maskmatches($mask, 524288);                //Just Standings
            $skills = maskmatches($mask, 8);                        //Just Character Sheet
            $defcon3 = maskmatches($mask, 8913152);                 //Public Character Info, Standings, Killlog
            $defcon2 = $defcon3 && maskmatches($mask, 90179600);    //Private Character Info, Contracts, ContactList, MailMessages, WalletJournal, WalletTransactions
            $defcon1 = $defcon2 && maskmatches($mask, 393226);      //SkillQueue, SkillInTraining, CharacterSheet, AssetList
            $retval=array();
            if($defcon3)
                    $retval = array("DEFCON 3");
            if($defcon2)
                    $retval = array("DEFCON 2");
            if($defcon1)
                    $retval = array("DEFCON 1");
            if($skills)
                    $retval[] = "SKILLS";
            if($standings)
                    $retval[] = "STANDINGS";
            return implode(",",$retval);
    }
    function maskmatches($mask,$check){return ($mask & $check) == $check;}
	function syncKeys($mysql_host, $mysql_yapeal_db, $mysql_phpBB_db, $mysql_phpBB_prefix, $mysql_user, $mysql_password)
	{
		$phpBB = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_phpBB_db);
		$yapeal = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_yapeal_db);
		
		chdir("yapeal");
        set_include_path(get_include_path() . PATH_SEPARATOR . "yapeal");		
		// Define short name for directory separator which always uses unix '/'.
		if (!defined('DS')) {
		  define('DS', '/');
		}
		// Get the base dir of Yapeal.
		$dir = str_replace('\\', DS, dirname(__FILE__)) . DS . ".." . DS . "yapeal" . DS;
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
		
		$qry = $phpBB->query("SELECT pf_api_key FROM " . $mysql_phpBB_prefix . "profile_fields_data");
		$keys = array();
		$chars = array();
		
		while($row = $qry->fetch_object())
		{
			$key = explode(":",$row->pf_api_key);
			$regKey = new RegisteredKey($key[0]);
			if ($regKey->recordExists() && $regKey->isActive)
				$keys[] = $key[0];
			else {
				$xml = simplexml_load_file("https://api.eveonline.com/account/APIKeyInfo.xml.aspx?keyID=" . $key[0] . "&vCode=" . $key[1]);
	            if(empty($xml->error) && $xml->result->key->attributes()->type=="Account")
				{
					$keys[] = $key[0];
	            	$mask = $xml->result->key->attributes()->accessMask;
					$regKey->vCode = $key[1];
					$regKey->activeAPIMask = $mask;
					$regKey->isActive = 1;
					$regKey->store();
					$page = new SimpleXMLElement("https://api.eveonline.com/account/Characters.xml.aspx?keyID=" . $regKey->keyID . "&vCode=" . $regKey->vCode, NULL, TRUE);
			        $i=0;
			        foreach($page->result->rowset->row as $row){
			        		$chars[] = $row->attributes()->characterID;
			                $char = new RegisteredCharacter($row->attributes()->characterID);
							$char->activeAPIMask = $mask;
							$char->isActive = 1;
							$char->store();
							$char = NULL;
							unset($char);
			        }
					$regKey = NULL;
					unset($regKey);
				}
			}
		}

		$qry = $yapeal->query("SELECT keyID, isActive FROM utilRegisteredKey");
		while($row = $qry->fetch_object())
			if($row->isActive && !in_array($row->keyID, $keys))
			{
                $regKey = new RegisteredKey($row->keyID);
				$regKey->isActive = 0;
				$regKey->store();
			}
	
		chdir("..");
		
	}

    if(!empty($_GET["eveAPIgrab"]))
            switch($_GET["eveAPIgrab"])
            {
                    case "STATUS":
                            print(getAPIStatus($_GET["key"], $_GET["vcode"]));
                            break;
            }
	
?>