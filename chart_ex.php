<!DOCTYPE html>
<html>
<head>
<link href="css/styles.css" type="text/css" rel="stylesheet">
<meta charset="utf-8" />
<script type="text/javascript" src="OpenChart/js/swfobject.js"></script>
<script type="text/javascript">
 
swfobject.embedSWF(
  "open-flash-chart.swf", "pie_chart",
  "300", "300", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/chart1.php"} );
 
swfobject.embedSWF(
  "open-flash-chart.swf", "Sum_salgsinntekter",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Sum salgsinntekter&ID=".$_GET['ID']); ?>"} );

swfobject.embedSWF(
  "open-flash-chart.swf", "Annen_driftsinntekt",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Annen driftsinntekt&ID=".$_GET['ID']); ?>"} );

swfobject.embedSWF(
  "open-flash-chart.swf", "Sum_driftsinntekter",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Sum driftsinntekter&ID=".$_GET['ID']); ?>"} );

swfobject.embedSWF(
  "open-flash-chart.swf", "Varekostnad",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Varekostnad&ID=".$_GET['ID']); ?>"} );

swfobject.embedSWF(
  "open-flash-chart.swf", "Lonnskostnader",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Lonnskostnader&ID=".$_GET['ID']); ?>"} ); 

swfobject.embedSWF(
  "open-flash-chart.swf", "Andre_driftskostnader",
  "380", "250", "9.0.0", "expressInstall.swf",
  {"data-file":"charts/<?php print urlencode("chart2.php?record=Andre driftskostnader&ID=".$_GET['ID']); ?>"} );


</script>


<title><?php print $s_graphs_overview; ?></title>
</head>
<body>
<?php
//require_once 'lib/db.php';
require_once "lang/".$_SESSION['lang'].".php";
?>
<h1><?php print $s_graphs_overview;?></h1>

<h2>Inntekter</h2>

<div id="Sum_salgsinntekter"></div>
<div id="Annen_driftsinntekt"></div>
<div id="Sum_driftsinntekter"></div>
<br clear="all">

<h2>Kostnader</h2>
<div id="Varekostnad"></div>
<div id="Lonnskostnader"></div>
<div id="Andre_driftskostnader"></div>


</body>
</html>