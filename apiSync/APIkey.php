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

        if(!empty($_GET["eveAPIgrab"]))
                switch($_GET["eveAPIgrab"])
                {
                        case "STATUS":
                                print(getAPIStatus($_GET["key"], $_GET["vcode"]));
                                break;
                }
?>