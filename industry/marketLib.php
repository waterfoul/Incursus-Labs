<?php
	function getWaste($itemID)
	{
	    global $dump;
	    $q2=$dump->query("
            SELECT b.wasteFactor
            FROM invBlueprintTypes AS b
            WHERE b.productTypeID = ". $itemID);
        $r=$q2->fetch_object();
        if($r==null)
            return 0;
        else
            return $r->wasteFactor;
	}
	function getBaseMaterials($itemID,$ME,$waste)
	{
	    global $dump;
	    $mats=array();
	    $q2=$dump->query("
            SELECT m.materialTypeID, m.quantity
		    FROM invTypeMaterials AS m
	        WHERE m.typeID = ".$itemID
        );
        while($r2=$q2->fetch_object())
            $mats[$r2->materialTypeID]=$r2->quantity;

    	$q2=$dump->query("SELECT valueInt FROM `dgmTypeAttributes` WHERE  `typeID` =" . $itemID . " AND  `attributeID` =422");
        while($r2=$q2->fetch_object())
            if($r2->valueInt==2){
                $q3=$dump->query("SELECT parentTypeID FROM  `invMetaTypes` WHERE  `typeID` = " . $itemID);
                if($r3=$q3->fetch_object()){
                	$q4=$dump->query("SELECT m.materialTypeID, m.quantity
                                        FROM invTypeMaterials AS m
                                        WHERE m.typeID = ".$r3->parentTypeID);
                    while($r4=$q4->fetch_object())
                        if(array_key_exists($r4->materialTypeID, $mats))
                            $mats[$r4->materialTypeID]-=$r4->quantity;
                }
            }
            if($ME<0)
                foreach($mats as $i=>$v)
                    $mats[$i]=round($v+($v*(($waste/100)*(1-$ME))));
            else
                foreach($mats as $i=>$v)
                    $mats[$i]=round($v+($v*(($waste/$ME+1)/100)));
        return($mats);
    }
    function getExtraMaterials($itemID)
    {
        global $dump;
        $mats=array();
        $q2=$dump->query("
            SELECT r.requiredTypeID, r.quantity, r.damagePerJob, b.wasteFactor
	        FROM ramTypeRequirements AS r
	        INNER JOIN invBlueprintTypes AS b
	            ON r.typeID = b.blueprintTypeID
	        INNER JOIN invTypes AS t
	            ON r.requiredTypeID = t.typeID
	        INNER JOIN invGroups AS g
	            ON t.groupID = g.groupID
	        WHERE b.productTypeID = ". $itemID ."
	                    AND r.activityID = 1
	        AND g.categoryID != 16
        ");
        while($r2=$q2->fetch_object())
            $mats[$r2->requiredTypeID]=$r2->quantity*$r2->damagePerJob;
        return($mats);
    }
	function getInventMaterials($itemID,$bpRuns,$chance)
	{
	    global $dump;
	    $mats=array();
	    $q2=$dump->query("SELECT valueInt FROM `dgmTypeAttributes` WHERE  `typeID` =" . $itemID . " AND  `attributeID` =422");
	    while($r2=$q2->fetch_object())
	        if($r2->valueInt==2){
	            $q3=$dump->query("
                    SELECT a.requiredTypeID, a.quantity
                    FROM ramTypeRequirements as a
                    LEFT JOIN invBlueprintTypes b ON a.typeID = b.blueprintTypeID
                    LEFT JOIN `invMetaTypes` as c ON c.parentTypeID = b.productTypeID
                    LEFT JOIN `invTypes` as d ON a.requiredTypeID = d.typeID
                    WHERE c.`typeID` = 1422
                    AND a.activityID = 8
                    AND d.marketGroupID = 966
	            ");
	            while($r3=$q3->fetch_object()){
                    $mats[$r3->requiredTypeID]=$r3->quantity*(1/$bpRuns)*(1/$chance);
	            }
	        }
	    return $mats;
    }
	function getCentralPrice($type, $col, $itemID, $time, $db)
	{
		$qry = "SELECT `" . $col . "` as a FROM `marketStat` WHERE `Type` = '" . $type . "' and `itemID` = '" . $itemID . "' and grabbedAt < '" . $time . "' ORDER BY `grabbedAt` DESC LIMIT 1";
		print($qry);
		$qry = $db->query($qry);
		return $qry->fetch_object()->a;
	}
