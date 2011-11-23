<?php
include "menu.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Norsk Verdivurdering - Online system</title>
<link rel="stylesheet" type="text/css" href="lib/jquery/jquery.jqplot.css" />		
 <script language="javascript" type="text/javascript" src="lib/jquery/jquery.js"></script> 		
  <script language="javascript" type="text/javascript" src="lib/jquery/jquery.jqplot.js"></script> 
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.barRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pieRenderer.js"></script>

  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.highlighter.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pointLabels.js"></script>		
		
 <script class="code" type="text/javascript">$(document).ready(function(){
        var s1 = [2, 6, 7, 10];
        var ticks = ['a', 'b', 'c', 'd'];
        
        plot1 = $.jqplot('chart1', [s1], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
    });</script>
		
     </head>
	<body>

<div id="chart1" style="height:350px;width:300px"></div>

</body>
</html>