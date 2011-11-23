<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
      <script  src="lib/dhtmlxGrid/dhtmlxGrid/codebase/dhtmlxcommon.js"></script>		
		<script  src="lib/dhtmlxGrid/dhtmlxGrid/codebase/dhtmlxgrid.js"></script>        
		<script  src="lib/dhtmlxGrid/dhtmlxGrid/codebase/dhtmlxgridcell.js"></script>    
		<script  src="lib/dhtmlxConnector/codebase/connector.js"></script>
		
		<link rel="STYLESHEET" type="text/css" href="lib/dhtmlxGrid/dhtmlxGrid/codebase/dhtmlxgrid.css">
		<link rel="stylesheet" type="text/css" href="lib/dhtmlxGrid/dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_skyblue.css">
		<link href="css/styles.css" type="text/css" rel="stylesheet">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
      <title>Sales Reps</title>
    </head>

    <body>
<?php
require_once "lang/".$_SESSION['lang'].".php";
//require_once "lib/db.php";
?>


<div id="gridbox" style="width:600px;height:270px;overflow:hidden"></div>
            
            
<script>

//init grid and set its parameters (this part as always);
mygrid = new dhtmlXGridObject('gridbox');
mygrid.setImagePath("lib/dhtmlxGrid/dhtmlxGrid/codebase/imgs/");
mygrid.setHeader("Name,Phone");
mygrid.setInitWidths("100,150");
mygrid.setColAlign("left,right");
mygrid.setColTypes("ed,ed");
mygrid.setSkin("dhx_skyblue");
mygrid.setColSorting("str,str");
mygrid.init();
mygrid.loadXML("data/gridconnector.php");
//used just for demo purposes;
//============================================================================================;
<!-- myDataProcessor = new dataProcessor("php/update.php"); -->
//lock feed url;
<!-- myDataProcessor.init(mygrid); -->
//link dataprocessor to the grid;
//============================================================================================;

</script>


</body>
</html>
