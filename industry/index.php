<?php
	include("../config.php");
?>
<html>
	<head>
		<link type="text/css" href="../header.css" rel="stylesheet" />
		<script type="text/javascript" href="tablefilter.js"></script>
		<script type="text/javascript" href="sorttable.js"></script>
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
					SELECT DISTINCT(c.`itemID`), c.`Profit`, c.`Date`, i.`typeName`
					FROM  `calculatedTheory` c
					LEFT JOIN  `naa_dbdump`.`invTypes` AS i ON c.`itemID` = i.typeID
					ORDER BY  `c`.`Profit` DESC,
						      `c`.`Date` DESC
				");
				print("<table class='sortable filterable'><tr><th>Item ID</th><th>Profit</th><th>Date</th><th>Item Name</th></tr>");
				while($row = $qry->fetch_object())
				{
					print("<tr><td>" . $row->itemID . "</td><td>" . $row->Profit . "</td><td>" . $row->Date . "</td><td>" . $row->typeName . "</td></tr>");
				}
				print("</table>")
			?>
		</div>
	</body>
</html>