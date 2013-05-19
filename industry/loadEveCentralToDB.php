<?php
	include("../config.php");
	$db = new mysqli($mysql_host, $mysql_evecentral_username, $mysql_evecentral_password, $mysql_evecentral);
	$qry = $db->query("SELECT typeID FROM " . $mysql_eve_dbDump . ".invTypes WHERE marketGroupID IS NOT NULL and marketGroupID < 100000");
	$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$urlbase = "http://api.eve-central.com/api/marketstat?usesystem=30000142";
	$urls = array($urlbase);
	$i=0;
	while( $row = $qry->fetch_object() )
	{
		if(strlen($urls[$i] . "&typeid=" . $row->typeID) > 2048)
		{
			$i++;
			$urls[$i] = $urlbase;
		}
		$urls[$i] = $urls[$i] . "&typeid=" . $row->typeID;
	}
	foreach($urls as $url)
	{
		$items = new SimpleXMLElement(file_get_contents($url, false, $context));
		foreach($items->marketstat->type as $v)
		{
			$db->query("
				INSERT INTO  `naa_evecentral`.`marketStat` (
					`recordID` ,
					`itemID` ,
					`Type` ,
					`volume` ,
					`avg` ,
					`max` ,
					`min` ,
					`stddev` ,
					`median` ,
					`percentile` ,
					`grabbedAt`
				)
				VALUES
				(
					NULL,
					'" . $v->attributes()->id . "',
					'buy',
					'" . $v->buy->volume . "',
					'" . $v->buy->avg . "',
					'" . $v->buy->max . "',
					'" . $v->buy->min . "',
					'" . $v->buy->stddev . "',
					'" . $v->buy->median . "',
					'" . $v->buy->percentile . "',
					NOW( )
				);
			");
			$db->query("
				INSERT INTO  `naa_evecentral`.`marketStat` (
					`recordID` ,
					`itemID` ,
					`Type` ,
					`volume` ,
					`avg` ,
					`max` ,
					`min` ,
					`stddev` ,
					`median` ,
					`percentile` ,
					`grabbedAt`
				)
				VALUES
				(
					NULL,
					'" . $v->attributes()->id . "',
					'sell',
					'" . $v->sell->volume . "',
					'" . $v->sell->avg . "',
					'" . $v->sell->max . "',
					'" . $v->sell->min . "',
					'" . $v->sell->stddev . "',
					'" . $v->sell->median . "',
					'" . $v->sell->percentile . "',
					NOW( )
				);
			");
			$db->query("
				INSERT INTO  `naa_evecentral`.`marketStat` (
					`recordID` ,
					`itemID` ,
					`Type` ,
					`volume` ,
					`avg` ,
					`max` ,
					`min` ,
					`stddev` ,
					`median` ,
					`percentile` ,
					`grabbedAt`
				)
				VALUES
				(
					NULL,
					'" . $v->attributes()->id . "',
					'all',
					'" . $v->all->volume . "',
					'" . $v->all->avg . "',
					'" . $v->all->max . "',
					'" . $v->all->min . "',
					'" . $v->all->stddev . "',
					'" . $v->all->median . "',
					'" . $v->all->percentile . "',
					NOW( )
				);
			");
		}
	}
?>