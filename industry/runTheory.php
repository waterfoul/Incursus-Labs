<?php
	include("../config.php");
	include("marketLib.php");
	$time = date("Y-m-d H:i:s");
	$db = new mysqli($mysql_host, $mysql_evecentral_username, $mysql_evecentral_password, $mysql_evecentral);
	$dump = new mysqli($mysql_host, $mysql_evecentral_username, $mysql_evecentral_password, $mysql_eve_dbDump);
	$excludeGroups = array();
 	/*$q=$dump->query("SELECT `groupID` FROM invGroups WHERE `categoryID` != 7");
	while($r=$q->fetch_object())
        $excludeGroups[] = $r->groupID;*/
	$i=5;
	$itemIDs = array();
	$q=$dump->query("SELECT `typeID` FROM `dgmTypeAttributes` WHERE  `valueInt` = 2 AND  `attributeID` = 422");
	while($r=$q->fetch_object())
	{
		$q2=$dump->query("SELECT `groupID`,`typeName` FROM `invTypes` WHERE `typeID` = '" . $r->typeID . "'");
        $r2 = $q2->fetch_object();
        if(strpos($r2->typeName, "Blueprint") === FALSE && !in_array($r2->groupID, $excludeGroups)){
        	$itemIDs[] = array($r->typeID, 2);
		}
	}
	$q=$dump->query("
		SELECT b.`productTypeId` as typeID FROM `invBlueprintTypes` as b
			LEFT OUTER JOIN `dgmTypeAttributes` as d ON d.`typeID` = b.`productTypeID` AND d.`attributeID` = 422
			LEFT OUTER JOIN `dgmTypeAttributes` as d2 ON d2.`typeID` = b.`productTypeID` AND d2.`attributeID` = 633
		WHERE (d.`typeID` IS NULL OR d.`valueInt` != 2 OR d.`valueFloat` != 2)
		AND (d2.`typeID` IS NULL OR d2.`valueInt` = 0 OR d2.`valueFloat` = 0)
	");
	while($r=$q->fetch_object())
	{
		$q2=$dump->query("SELECT `groupID`,`typeName` FROM `invTypes` WHERE `typeID` = '" . $r->typeID . "'");
        $r2 = $q2->fetch_object();
        if(strpos($r2->typeName, "Blueprint") === FALSE && !in_array($r2->groupID, $excludeGroups)){
        	$itemIDs[] = array($r->typeID, 1);
		}
	}
	foreach($itemIDs as $item)
	{
		$q4=$dump->query("SELECT `researchTechTime`,`productionTime`,`researchCopyTime` FROM `invBlueprintTypes` WHERE `productTypeID` = " . $item[0]);
        $r4=$q4->fetch_object();
		if($r4){
            $copytime = ($r4->researchCopyTime * 2)/60/60;
            $buildtime = $r4->productionTime/60/60;
            $inventtime = 0;
            if($item[1] == 2)
            	$inventtime = $r4->researchTechTime/60/60;
            $totaltime = $copytime/10 + $buildtime + $inventtime/10;
		}
		$itemID = $item[0];
        $waste=getWaste($itemID);
        $mats=getBaseMaterials($itemID,-4,$waste);
        $mats=$mats + getExtraMaterials($itemID);
        if($item[1] == 2)
        	$mats=$mats + getInventMaterials($itemID,10,0.4779);
        $profit = getCentralPrice("buy", "max", $itemID, $time, $db);
        foreach($mats as $i=>$v){
        	$profit -= getCentralPrice("buy", "max", $i, $time, $db) * $v;
        }
        $db->query("INSERT INTO `calculatedTheory` (`itemID`, `Profit`, `Date`) VALUES ('" . $itemID . "', '" . $profit . "', '" . $time . "');");
	}

?>