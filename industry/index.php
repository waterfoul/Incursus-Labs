<?php
	include("../config.php");
?>
<html>
	<head>
		<link type="text/css" href="../header.css" rel="stylesheet" />
		<link type="text/css" href="filtergrid.css" rel="stylesheet" />
		<script type="text/javascript" src="tablefilter.js"></script>
        <script type="text/javascript" src="sorttable.js"></script>
	</head>
	<body>
		<div id="wrap">
			<?php
				define('IN_PHPBB', true);
				include("../header.php");
				if($user->data['loginname'] != "waterfoul" && $user->data['loginname'] != "MrWacko" && $user->data['loginname'] != "themastercheif92")
					exit();
				$db = new mysqli($mysql_host, $mysql_evecentral_username, $mysql_evecentral_password, $mysql_evecentral);
				$qry = $db->query("
					SELECT DISTINCT(c.`itemID`), g.`groupName`, c.`Profit`, c.`Date`, i.`typeName`
					FROM  `calculatedTheory` c
					LEFT JOIN  `naa_dbdump`.`invTypes` AS i ON c.`itemID` = i.`typeID`
					LEFT JOIN  `naa_dbdump`.`invGroups` AS g ON i.`groupID` = g.`groupID`
					ORDER BY  `c`.`Profit` DESC,
						      `c`.`Date` DESC
				");
				print("<table id='maintable' class='filterable sortable'><tr><th>Item Name</th><th>Group</th><th>Profit</th><th>Build Time</th><th>Invent Time</th><th>Copy Time</th><th>Total Time</th><th>Date</th><th>Item ID</th></tr>");
				while($row = $qry->fetch_object())
				{
					$q4=$dump->query("SELECT `researchTechTime`,`productionTime`,`researchCopyTime` FROM `invBlueprintTypes` WHERE `productTypeID` = " . $item[0]);
					$buildtime = 0;
		            $inventtime = 0;
		            $copytime = 0;
		            $totaltime = 0;
			        $r4=$q4->fetch_object();
					if($r4){
						$buildtime = $r4->productionTime/60/60;
			            $inventtime = 0;
			            $copytime = 0;
			            if($item[1] == 2)
			            {
			            	$copytime = ($r4->researchCopyTime * 2)/60/60;
			            	$inventtime = $r4->researchTechTime/60/60;
			        	}
			            $totaltime = $copytime/10 + $buildtime + $inventtime/10;
		            }
					print("<tr><td>" . $row->typeName . "</td><td>" . $row->groupName . "</td><td>" . number_format($row->Profit,2) . "</td><td>" . $buildtime . "</td><td>" . $inventtime . "</td><td>" . $copytime . "</td><td>" . $totaltime . "</td><td>" . $row->Date . "</td><td>" . $row->itemID . "</td></tr>");
				}
				print("</table>")
			?>
		</div>
	</body>
</html>