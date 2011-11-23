<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location:login.php");
}
include_once "menu.php";

$orderStatusID = $_GET['status'];
if($orderStatusID=="") { $orderStatusID="all"; } 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
<script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 
</head>
<body >
<script type="text/javascript" >
var price = new Array();
var productDescription = new Array();
</script>


<?php 
$querys = "SELECT * FROM ".$products." ORDER by productName desc";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while ($Rows=MySQL_fetch_array($Results)) { // list products 
?>
<script type="text/javascript" >
price[<?php print $Rows['ID'];?>] = '<?php print $Rows['unitPrice']; ?>';
productDescription[<?php print $Rows['ID'];?>] = '<?php print $Rows['productDescription']; ?>';
</script>
<?php

}
?>



<div id="main_table">

<h1  class="ui-widget-header ui-corner-all" style="padding:3px;">&nbsp; <span id="heading"><?php print $heading1; ?></span> 
&nbsp; 
<input id="allButton" type="button" onclick="showOrders('<?php print $orderStatusID; ?>')" value="<?php print $LANG['show_all'];?>"> 

&nbsp; 
<select id="status" name="status" onchange="javaScript:showOrders(this.options[this.selectedIndex].value)">
<option value="all"><?php print $LANG['show_all']; ?></option>
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
&nbsp;
</h1>


<div id="list"></div>

<iframe src="" id="iFrame" style="border:0;width:95%;height:450px;float:left;"></iframe>

<div id="data" style="width:100%"></div></div>




<script type="text/javascript">
	
function getOrder (orderID) {
	document.getElementById("allButton").style.visibility='visible';
		 
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
	
		$( "#datepicker" ).datepicker();
	   
   
    }
  }
xmlhttp.open("GET","data/display_order.php?orderID="+orderID,true);
xmlhttp.send();
document.getElementById("statusBar").innerHTML="";

}	


function setPrice(priceID) {
document.getElementById("unitPrice").value = price[priceID];
}

//setPrice(document.getElementById("product").options[document.getElementById("product").selectedIndex].value);

function saveOrder() {

	
xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
    }
  }
  
  	var queryString = "?orderDate=" + encodeURIComponent(document.getElementById("orderDate").value) + 
	"&unitPrice=" + encodeURIComponent(document.getElementById("unitPrice").value) +
	"&comments=" + encodeURIComponent(document.getElementById("orderComments").value) +
	"&creditDays=" + encodeURIComponent(document.getElementById("creditDays").value) +
	"&otherTerms=" + encodeURIComponent(document.getElementById("otherTerms").value) +
	"&customerContact=" + encodeURIComponent(document.getElementById("customerContact").value) +
	"&productID=" + encodeURIComponent(document.getElementById("productID").value) +
	"&regNumber=" + encodeURIComponent(document.getElementById("regNumber").value) +
	"&orderID=" + encodeURIComponent(document.getElementById("orderID").value)  	
	;

xmlhttpi.open("GET","data/process_order.php"+queryString,true);
xmlhttpi.send();


	}



	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "no" ] );
		$( "#orderDate" ).datepicker( $.datepicker.regional[ "no" ] );	
		});




function deleteOrder(companyName, orderStatusID, orderID) {


jConfirm("<?php print $LANG['confirm_delete_order']; ?> "+companyName+" ?", "<?php print $LANG['confirm_delete_heading'];?>", function(y) {
	if(y==true) {
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
    showOrders(orderStatusID);
    }
  }
xmlhttp.open("GET","data/delete_order.php?orderID="+orderID,true);
xmlhttp.send();
	}
		
	
});
	}


function convertOrderStatus(orderID, orderStatusID)
{

	document.getElementById("allButton").style.visibility='visible';
	
	
xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/convert_order_status.php?orderID="+orderID+"&orderStatusID="+orderStatusID,true);
xmlhttpi.send();


}


function showOrders(orderStatusID) {
	if (orderStatusID!="all") {
	getOrderName(orderStatusID)
	} else {
		document.getElementById("heading").innerHTML="<?php print $LANG['all_orders'];?>";

		}

xmlhttp2=new XMLHttpRequest();
xmlhttp2.onreadystatechange=function()  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
    document.getElementById("list").innerHTML=xmlhttp2.responseText;
 oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 25,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "<?php print $LANG['LengthMenu']; ?>",
			"sZeroRecords": "<?php print $LANG['ZeroRecords']; ?>",
			"sInfo": "<?php print $LANG['Info']; ?>",
			"sInfoEmpty": "<?php print $LANG['InfoEmpty']; ?>",
			"sInfoFiltered": "<?php print $LANG['InfoFiltered']; ?>",
			"sSearch": "<?php print $LANG['search']; ?>",
			"oPaginate": {
				"sFirst":    "<?php print $LANG['First']; ?>",
				"sPrevious": "<?php print $LANG['Previous']; ?>",
				"sNext":     "<?php print $LANG['Next']; ?>",
				"sLast":     "<?php print $LANG['Last']; ?>"
				}
		}
		});
    }
  }
xmlhttp2.open("GET","data/display_orders.php?orderStatusID="+orderStatusID,true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("iFrame").src=""
document.getElementById("allButton").style.visibility='hidden';
document.getElementById("statusBar").innerHTML="";
//document.getElementById(orderStatus).defaultSelected = true;
}	
	
	
function getOrderName(orderStatusID) {

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("heading").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/get_order_name.php?orderStatusID="+orderStatusID,true);
xmlhttpi.send();
	
	}	
	
	
	
showOrders('<?php print $orderStatusID; ?>'); // display orders at page load 
</script>

</body>
</html>
