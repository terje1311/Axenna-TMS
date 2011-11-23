<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: login.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
<?php
include_once "menu.php";
?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php print "Axenna Telemarketing - ".$_SESSION['companyName']; ?></title>
<link rel="stylesheet" type="text/css" href="lib/jquery/jquery.jqplot.css" />
  <script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 
  <script language="javascript" type="text/javascript" src="lib/jquery/jquery.jqplot.js"></script> 
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.barRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pieRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.highlighter.js"></script>
  <script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pointLabels.js"></script>	
  
  	
<?php
$valuesS ="";
if(isset($_SESSION['admin'])) {  // check for admin rights and select all sales 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders."  GROUP by salesRepID ORDER BY orderValue desc";
$sales_title = $LANG['sales_per_salesrep'];

} elseif(isset($_SESSION['supervisor']) ) {  // check for supervisor rights and select sales from subordinates 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders." WHERE salesRepID IN (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") OR salesRepID=".$_SESSION['userID']." GROUP by salesRepID ORDER BY orderValue desc";
$sales_title = $LANG['sales_per_salesrep'];

} else {  // select users own sales 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders." WHERE salesRepID=".$_SESSION['userID']." GROUP by salesRepID ORDER BY orderValue desc";
$sales_title = $LANG['my_sales'];
}
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($Rows = mysql_fetch_array($Results)) {

$queryname = "SELECT fullName FROM ".$users." WHERE userID=".$Rows['salesRepID'];
if (!$Resultname= mysql_db_query($DBName, $queryname, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$Rowname = mysql_fetch_array($Resultname);

$valuesS = $valuesS.",".$Rows['orderValue'];
$x_axisS = $x_axisS.",'".substr($Rowname['fullName'],0, strpos($Rowname['fullName']," "))."'";
		}

$valuesS = substr($valuesS,1);
$x_axisS = substr($x_axisS,1);

$valuesM ="";
if(isset($_SESSION['admin']) ) {  // check for admin rights and show all monthly sales
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders." GROUP by orderMonth";

} elseif(isset($_SESSION['supervisor'])) { // check for supervisor rights and show monthly sales for subordinates  
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders.", ".$users." WHERE salesRepID IN (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") OR salesRepID=".$_SESSION['userID']." GROUP by orderMonth";

} else {  // select users own sales per month
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders." WHERE salesRepID=".$_SESSION['userID']." GROUP by orderMonth";
}

if (!$ResultM= mysql_db_query($DBName, $queryM, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($RowM = mysql_fetch_array($ResultM)) {

$valuesM = $valuesM.",".$RowM['orderValue'];
$x_axisM = $x_axisM.",'".$LANG['MS'][$RowM['orderMonth']]."'";
		}

$valuesM = substr($valuesM,1);
$x_axisM = substr($x_axisM,1);

?>
 <script class="code" type="text/javascript">
var addProduct = "<?php print $LANG['addProduct'];  ?>"
var editProduct = "<?php print $LANG['editProduct'];  ?>"

var addUser = "<?php print $LANG['add_user'];  ?>"
var editUser = "<?php print $LANG['edit_user'];  ?>"

var addRole = "<?php print $LANG['add_role'];  ?>"
var editRole = "<?php print $LANG['edit_role'];  ?>"

var addCurrencie = "<?php print $LANG['add_currency'];  ?>"
var editCurrencie = "<?php print $LANG['edit_currency'];  ?>"

var addContract = "<?php print $LANG['add_contract'];  ?>"
var editContract = "<?php print $LANG['edit_contract'];  ?>"

var addOrderStatu = "<?php print $LANG['add_order_status'];  ?>"
var editOrderStatu = "<?php print $LANG['edit_order_status'];  ?>"

var addWorkplace = "<?php print $LANG['add_workplace'];  ?>"
var editWorkplace = "<?php print $LANG['edit_workplace'];  ?>"

var addDepartment = "<?php print $LANG['add_department'];  ?>"
var editDepartment = "<?php print $LANG['edit_department'];  ?>"

var dataSaved = "<?php print $LANG['data_saved'];  ?>"
 
 $(document).ready(function(){
 	
 	// Tabs
			$('#tabs').tabs();
						
        var s1 = [<?php print $valuesS;?>];
        var ticks = [<?php print $x_axisS;?>];
        
        plot1 = $.jqplot('salesGraph', [s1], {
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
    
        $('#salesGraph').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );

        var s2 = [<?php print $valuesM;?>];
        var ticks2 = [<?php print $x_axisM;?>];


        plot2 = $.jqplot('monthlySales', [s2], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                }
            },
            highlighter: { show: false }
        });
    
        $('#monthlySales').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
        
        
		  var s3 = [<?php print $values;?>];
        var ticks3 = [<?php print $x_axis;?>];


        plot3 = $.jqplot('cashFlow', [s3], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks3
                }
            },
            highlighter: { show: false }
        });
    
        $('#cashFlow').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );              
        
        

      });


      
function show(showType) { 
   
 if (showType=="cashFlow") { 
  document.getElementById('graphArea').innerHTML="";

   		var s3 = [<?php print $values;?>];
        var ticks3 = [<?php print $x_axis;?>];
			var Title = "<?php print $LANG['cash_flow']; ?>";
			
        plot3 = $.jqplot('graphArea', [s3], {
            seriesDefaults:{
                //renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks3
                }
            },
            highlighter: { show: false },
            title: Title,  
        });
			
			
} else {
		  document.getElementById("graphFrame").src="data/get_order_charts.php?orderStatusID="+showType
      }
 } // end function show



     
      
  

      </script>
		
     </head>
	<body>


	
  <div id="main_table" style="margin-left:20px">
 <a href="index.php" ><img src="images/logo1.png" style="border:0px;" alt="Norsk Verdivurdering" ></a>
 <span style="margin-left:740px">         
 <a href="#" onclick="JavaScript:punch('In','<?php print $_SESSION['userID'];?>');"><img src="images/punchin.png" border="0" alt="<?php print $LANG['punchin'];?>" title="<?php print $LANG['punchin'];?>" ></a>
 <a href="#" onclick="JavaScript:punch('Out','<?php print $_SESSION['userID'];?>');"><img src="images/punchout.png" border="0" alt="<?php print $LANG['punchout'];?>" title="<?php print $LANG['punchout'];?>"></a>
 </span>              
   <br>          
		<div id="tabs" style="width:1040px;">
			<ul>
				<?php 
				if(isset($_SESSION['admin']) || isset($_SESSION['supervisor']) || isset($_SESSION['salesModule']) ) {  // check for admin or module rights				
				?>
				<li><a href="#tabs-1"><?php print $LANG['sales_system'];?></a></li>
				<?php
				}
				if(isset($_SESSION['admin']) ||  isset($_SESSION['orderModule'])  ) {  // check for admin or module rights
				?>			
				<li><a href="#tabs-2"><?php print $LANG['order_system'];?></a></li>
				<?php
				}
				?>
				<li><a href="#tabs-3"><?php print $LANG['reports'];?></a></li>
				<li><a href="#tabs-4"><?php print $LANG['administration'];?></a></li>
				</ul>
			
<?php	// Show Sales Module		
if(isset($_SESSION['admin']) || isset($_SESSION['supervisor']) || isset($_SESSION['salesModule'])  )  {  // Check for user rights
?>			
<div id="tabs-1">

<table summary="" style="border:0px;cell-spacing:0px">
<tr>
<td valign="top" width="180">
<h1><?php print $LANG['sales_system'];?></h1>
<?php			
if(isset($_SESSION['admin']))  {  // Check for admin rights
$queryle = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lead'");
$queryo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='opportunity'");
$queryc = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='customer'");
$querylo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lost'");

} else if(isset($_SESSION['supervisor']))  {  // Check for Supervisor rights and select sales from subordinates and self
$queryle = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lead' and salesRepID like (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID'] ); 
$queryo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='opportunity' and salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID']);
$queryc = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='customer' and ".$companies.".salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID'] );
$querylo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lost' and salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID']);

} else if(isset($_SESSION['salesModule']))  {  
$queryle = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lead' and salesRepID=".$_SESSION['userID']);
$queryo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='opportunity' and salesRepID=".$_SESSION['userID']);
$queryc = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='customer' and salesRepID=".$_SESSION['userID']);
$querylo = mysql_query("SELECT ID from ".$companies." WHERE companyStatus='lost' and salesRepID=".$_SESSION['userID']);
}

$leads = mysql_num_rows($queryle); 
$opportunities = mysql_num_rows($queryo); 
$customers = mysql_num_rows($queryc); 
$lost = mysql_num_rows($querylo); 

?>

				
	<a href="show_customer.php?status=lead"><img src="images/folder_green_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=lead"><?php print $LANG['leads'];?></a>
	<span style="color:#777777">(<?php print $leads;?>)</span>
	<br>
   <a href="show_customer.php?status=opportunity"><img src="images/folder_red_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=opportunity"><?php print $LANG['opportunities'];?></a>
	<span style="color:#777777">(<?php print $opportunities;?>)</span>	
	<br>         
   <a href="show_customer.php?status=customer"><img src="images/folder_yellow_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=customer"><?php print $LANG['sales'];?></a>
	<span style="color:#777777">(<?php print $customers;?>)</span>	
	<br>			
	<a href="show_customer.php?status=lost"><img src="images/folder_brown_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=lost"><?php print $LANG['lost'];?></a>
	<span style="color:#777777">(<?php print $lost;?>)</span>	
	<br><br>        
   <a href="show_callinglists.php"><img src="images/folder_blue_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_callinglists.php"><?php print $LANG['calling_lists'];?></a>
</td>
<td width="20">&nbsp;</td>
<td valign="top">

<h1><?php print $sales_title;?></h1>

<div id="salesGraph" style="height:200px;width:350px"></div>


</td>
<td width="20">&nbsp;</td>
<td valign="top">

<h1><?php print $LANG['sales_per_month'];?></h1>

<div id="monthlySales" style="height:200px;width:350px"></div>

</td>
</tr>		                        
</table>                       

</div>
<?php 
} // end Sales Module 

// Show Order Module		
if(isset($_SESSION['admin']) || isset($_SESSION['orderModule'])  )  {  // Check for user rights
?>	
      
<div id="tabs-2">
			
<table summary="" style="border:0px;cell-spacing:0px;width:950px;">
<tr>
<td valign="top"> 
	<h1><?php print $LANG['order_processing'];?></h1>
<?php
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {         

$queryn = mysql_query("SELECT orderID from ".$orders." WHERE orderStatusID=".$Rows['orderStatusID']);
$number = mysql_num_rows($queryn); 
         
echo'&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'"><img src="images/folder_blue_22.png" style="border:0px;vertical-align:middle;" alt="" /></a>&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'">'.$Rows['orderStatusName'].'</a> <span style="color:#777777">('.$number.')</span><br>';

}
?>

</td>
<td width="10">&nbsp;</td>
<td  valign="top">

	<h1><?php print $LANG['order_overview'];?></h1> 
<table summary="" class="ui-widget-content ui-corner-all" width="230" >
<tr>
<td><img src="images/spreadsheet_file_22.png" alt="" ></td>
<td><?php print $LANG['total'];?></td>
</tr>
<tr>
<td><?php print $LANG['order_value_total'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders;
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_paid'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID = '7'";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>


<tr>
<td><?php print $LANG['order_value_outstanding'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID != '7'";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	

<br>
<table summary="" class="ui-widget-content ui-corner-all" width="230" >
<tr>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderDate=DATE(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);


if($orderValue[0] > 0 && $orderValue[0] < 10000) {
	$iconfile="emotes_22/face-cool.png";
	} else if($orderValue[0] > 10000) {
	$iconfile="emotes_22/face-smile-big.png";
	} else {
	$iconfile="spreadsheet_file_22.png";
	}
?>
<td><img src="images/<?php print $iconfile;?>" alt="" ></td>
<td><?php print $LANG['order_value_total'];?></td>
</tr>
<tr>
<td><?php print $LANG['today'];?>:</td>
<td>
<?php
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>


<tr>
<td><?php print $LANG['this_week'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE WEEK(orderDate)=WEEK(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>



<tr>
<td><?php print $LANG['this_month'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE MONTH(orderDate)=MONTH(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	

	
	
</td>

<td valign="top">
<h1><?php print $LANG['graph_overview'];?> &nbsp;
<select style="font-size:13px;" onchange="show(this.value)">
<option value=""><?php print $LANG['show'];?></option>
<option value="0"><?php print $LANG['cash_flow'];?></option> >
<?php

$selected="";
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {
if($Rows['orderStatusName']==$Row['orderStatus']) { 
$selected="selected";
} else {
$selected="";
}


?>
<option id="<?php print $Rows['orderStatusID'];?>" value="<?php print $Rows['orderStatusID'];?>"  <?php print $selected;?> ><?php print $LANG['show']." ".$Rows['orderStatusName'];?></option>
<?php } ?>

</select>
</h1>
<iframe id="graphFrame" style="width:450px;height:300px;border:none" src=""></iframe>

</td>
</tr>		                        
</table>                       

</div>
<?php 
} // end Order Module 
?>

<div id="tabs-3">
	
<a href="#" onclick="JavaScript:showTimeSheet(<?php print $_SESSION['userID'];?>)" style="text-decoration:none"><img src="images/timesheet.png" style="vertical-align:middle" alt="" >  <?php print $LANG['my_timesheet'];?></a>

<?php // Show Reports Module		
if(isset($_SESSION['admin']) || isset($_SESSION['supervisor']) || isset($_SESSION['reportModule'])  )  {  // Check for user rights
?>
&nbsp;
<a href="#" onclick="JavaScript:showSalesReport()" style="text-decoration:none"><img src="images/user_list_32.png" style="vertical-align:middle" alt="" >  <?php print $LANG['salesreport'];?></a>

<?php } ?>

<div id="reportArea"></div>

</div>
		
<div id="tabs-4">
<table style="width:100%;font-weight:normal" class="ui-widget-header ui-corner-all" >
<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showProfile('<?php print $_SESSION['userID']; ?>')" style="text-decoration:none">
<img src="images/user_list_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['my_profile'];?></a>
</td>                           
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showUserDocuments('<?php print $_SESSION['userID']; ?>')" style="text-decoration:none">
<img src="images/folder_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['my_documents'];?></a>
</td>                           

<?php 
if(isset($_SESSION['admin'])) {
?>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showPreferences()" style="text-decoration:none">
<img src="images/admin_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['preferences'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showUsers()" style="text-decoration:none">
<img src="images/users_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['users'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showWorkplaces()" style="text-decoration:none">
<img src="images/home_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['workplaces'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showDepartments()" style="text-decoration:none">
<img src="images/departments_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['departments'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showRoles()" style="text-decoration:none">
<img src="images/roles_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['roles'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showOrderStages()" style="text-decoration:none">
<img src="images/folder_lists_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['order_stages'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showContracts()" style="text-decoration:none">
<img src="images/contracts_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['contracts'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showCurrencies()" style="text-decoration:none">
<img src="images/currencies_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['currencies'];?></a>
</td>
<td style="text-align:center;"> 
<a href="#" onclick="JavaScript:showProducts()" style="text-decoration:none">
<img src="images/products_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['products'];?></a>
</td> 
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showTemplates()" style="text-decoration:none">
<img src="images/folder_txt_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['templates'];?></a>
</td> 
<?php 
} else if($_SESSION['supervisor'])  {
?>	
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showUsers()" style="text-decoration:none">
<img src="images/users_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['users'];?></a>
</td>
<?php
} 
?>	
</tr>
</table>		                


<div id="adminArea"></div>

</div>


</div>

		</div>
 
        
            </div>
            
</body>
</html>
