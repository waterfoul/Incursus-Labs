<?php
        include("../config.php");
?>
<html>
    <head>
	    <link type="text/css" href="../header.css" rel="stylesheet" />
	    <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
	    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
	    <link rel="stylesheet" type="text/css" href="jquery.multiselect.css">
	    <link rel="stylesheet" type="text/css" href="jquery.multiselect.filter.css">
	    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	    <script type="text/javascript" charset="utf8" src="jquery.multiselect.min.js"></script>
	    <script type="text/javascript" charset="utf8" src="jquery.multiselect.filter.min.js"></script>
	    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
	    <script type="text/javascript">
            (function($) {
                /*
                 * Function: fnGetColumnData
                 * Purpose:  Return an array of table values from a particular column.
                 * Returns:  array string: 1d data array
                 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
                 *           int:iColumn - the id of the column to extract the data from
                 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
                 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
                 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
                 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
                 */
                $.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
                    // check that we have a column id
                    if ( typeof iColumn == "undefined" ) return new Array();

                    // by default we only want unique data
                    if ( typeof bUnique == "undefined" ) bUnique = true;

                    // by default we do want to only look at filtered data
                    if ( typeof bFiltered == "undefined" ) bFiltered = true;

                    // by default we do not want to include empty values
                    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;

                    // list of rows which we're going to loop through
                    var aiRows;

                    // use only filtered rows
                    if (bFiltered == true) aiRows = oSettings.aiDisplay;
                    // use all rows
                    else aiRows = oSettings.aiDisplayMaster; // all row numbers

                    // set up data array
                    var asResultData = new Array();

                    for (var i=0,c=aiRows.length; i<c; i++) {
                        iRow = aiRows[i];
                        var aData = this.fnGetData(iRow);
                        var sValue = aData[iColumn];

                        // ignore empty values?
                        if (bIgnoreEmpty == true && sValue.length == 0) continue;

                        // ignore unique values?
                        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

                        // else push the value onto the result data array
                        else asResultData.push(sValue);
                    }

                    return asResultData;
                }
            }(jQuery));


            function fnCreateSelect( aData )
            {
                var r='<select><option value=""></option>', i, iLen=aData.length;
                for ( i=0 ; i<iLen ; i++ )
                {
                    r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
                }
                return r+'</select>';
            }


            $(document).ready(function() {
                /* Initialise the DataTable */
                var oTable = $('#maintable').dataTable();

                /* Add a select menu for each TH element in the table footer */
                $("#maintable #filter .select").each( function () {
                    $td = $(this)
                    this.innerHTML = fnCreateSelect( oTable.fnGetColumnData($td.index()));
                    $('select', this).multiselect({
					   selectedText: "# of # selected"
					}).multiselectfilter().change( function () {
                        console.log([$(this).val(), $td.index()]);
                        oTable.fnFilter( $(this).val(), $td.index() );
                    } );
                } );
                
                $("#maintable #filter .text").keyup( function () {
			        /* Filter on the column (the index) of this element */
			        oTable.fnFilter( this.value, $(this).index() );
			    } );
			    
			    /*
			     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
			     * the footer
			     */
			    $("#maintable #filter .text").each( function (i) {
			        asInitVals[i] = this.value;
			    } );
			     
			    $("#maintable #filter .text").focus( function () {
			        if ( this.className == "search_init" )
			        {
			            this.className = "";
			            this.value = "";
			        }
			    } );
			     
			    $("#maintable #filter .text").blur( function (i) {
			        if ( this.value == "" )
			        {
			            this.className = "search_init";
			            this.value = asInitVals[$("tfoot input").index(this)];
			        }
			    } );
            } );
	    </script>
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
	                    SELECT c.`itemID`, g.`groupName`, c.`Profit`, c.`Date`, i.`typeName`, b.`researchTechTime`, b.`productionTime`, b.`researchCopyTime`, d.`valueInt`, d.`valueFloat`
	                    FROM  `calculatedTheory` c
	                    LEFT JOIN `naa_dbdump`.`invTypes` AS i ON c.`itemID` = i.`typeID`
	                    LEFT JOIN `naa_dbdump`.`invGroups` AS g ON i.`groupID` = g.`groupID`
	                    LEFT JOIN `naa_dbdump`.`invBlueprintTypes` as b ON b.`productTypeID` = i.`typeID`
	                    LEFT OUTER JOIN `naa_dbdump`.`dgmTypeAttributes` as d ON d.`typeID` = b.`productTypeID` AND d.`attributeID` = 422
	                    GROUP BY c.`itemID`
	                    ORDER BY  `c`.`Profit` DESC,
	                                  `c`.`Date` ASC
	            ");
				print("<table id='maintable'>
				        <thead><tr>            <th>Item Name</th>    <th>Group</th>          <th>Profit Margin</th><th>Profit/Min</th><th>Build Time</th><th>Invent Time</th><th>Copy Time</th><th>Total Time</th><th>Date</th><th>Item ID</th></tr></thead>
				        <thead><tr id='filter'><th class='text'></th><th class='select'></th><th class='text'></th><th></th>          <th></th>          <th></th>           <th></th>         <th></th>          <th></th>    <th>&nbsp;</th></tr></thead>");
	            while($row = $qry->fetch_object())
	            {
	                    $buildtime = $row->productionTime/60/60;
	            $inventtime = 0;
	            $copytime = 0;
	            if($row->valueInt == 2 || $row->valueFloat == 2)
	            {
	                $copytime = ($row->researchCopyTime * 2)/60/60;
	                $inventtime = $row->researchTechTime/60/60;
	                }
	            $totaltime = $copytime/10 + $buildtime + $inventtime/10;
	            $ppm = 0;
	            if($totaltime > 0)
	                $ppm = $row->Profit/$totaltime;
	                        print("<tr><td>" . $row->typeName . "</td><td>" . $row->groupName . "</td><td>" . number_format($row->Profit,2) . "</td><td>" . number_format($ppm,2) . "</td><td>" . number_format($buildtime,2) . "</td><td>" . number_format($inventtime,2) . "</td><td>" . number_format($copytime,2) . "</td><td>" . number_format($totaltime,2) . "</td><td>" . $row->Date . "</td><td>" . $row->itemID . "</td></tr>");
	                }
	                print("</table>")
	        ?>
        </div>
    </body>
</html>
