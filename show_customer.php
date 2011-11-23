<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
<script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 
</head>
<body >
<?php 
include_once "menu.php";
$companyStatus = $_GET['status'];
?>
<script type="text/javascript" >
var customerStatus = '<?php print $companyStatus ?>';
</script>

<div id="main_table">

<h1 class="ui-widget-header ui-corner-all" style="padding:3px;"><span id="heading"><?php print $heading1; ?></span> 
<img id="logoIcon" src="images/logo_32.png" align="left" alt="Logo" style="width:34px;border:0px;vertical-align:middle;margin-top:0px;"/>&nbsp;
<input id="allButton" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:13px;padding:4px;width:80px" onclick="showCustomers(customerStatus)" value="<?php print $LANG['show_all'];?>"> 
&nbsp; 
<select id="status" name="status" onchange="javaScript:showCustomers(this.options[this.selectedIndex].value)">


<?php

$selected="";
$querys = "SELECT * FROM ".$companystatus." ORDER by statusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {
if($Rows['statusName']==$Row['companyStatus']) { 
$selected="selected";
} else {
$selected="";
}

$statusNamestr = $Rows['statusName']."_sel";
$statusName = $LANG[$statusNamestr];
?>
<option id="<?php print $Rows['statusName'];?>" value="<?php print $Rows['statusName'];?>"  <?php print $selected;?> ><?php print $statusName;?></option>
<?php } ?>
</select>
&nbsp;
<a href="#" onclick="document.getElementById('salesArea').style.height='1px';document.getElementById('salesArea').innerHTML='';registerSale(document.getElementById('regNumber').innerHTML)"><img id="registerSaleButton" src="images/sales_32.png" style="border:0px;vertical-align:middle;visibility:hidden" title="<?php print $LANG['register_sale'];?>"  alt="<?php print $LANG['register_sale'];?>" ></a>
&nbsp;
<a href="#" onclick="saveCallingDate(document.getElementById('regNumber').innerHTML)" ><img id="registerCallButton" src="images/voicecall_32.png" style="border:0px;vertical-align:middle;visibility:hidden" title="<?php print $LANG['register_calling_date'];?>" alt="<?php print $LANG['register_calling_date'];?>" /></a>

</h1>


<div id="list" style="padding-bottom:10px;"></div>
<div class="clear" style="height:5px;"></div>
<div id="graphHead" style="visibility:hidden;margin:0px"><h1><?php print $LANG['graphs_overview'];?></h1></div>

<iframe src="" id="graphs" style="border:0;width:95%;height:180px;float:left;">

</iframe>


<div id="data" style="width:100%"></div>


</div>




<script type="text/javascript">


	$(function() {
		$( "#datepicker" ).datepicker();
	});

var buttonValue = "down";

function maxNotes() {
		if(buttonValue=="down") {	
	document.getElementById("notes").style.height="450px";
	document.getElementById("notesButton").src="images/go_up_16.png"
	buttonValue="up";
	} else {
	document.getElementById("notes").style.height="104px";
	document.getElementById("notesButton").src="images/go_down_16.png"
	buttonValue="down";
	}
		
	}

function deleteCustomer(regNumber, companyName, companyStatus, ID) {

jConfirm("<?php print $LANG['confirm_delete']; ?> "+companyName+"<?php print $LANG['back_to_callinglist']; ?> ?", "<?php print $LANG['confirm_delete_heading'];?>", function(y) {
	if (y == true) {
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
    showCustomers(companyStatus);
    }
  }
xmlhttp.open("GET","data/delete_customer.php?regNumber="+regNumber+"&redirect="+companyStatus+"&ID="+ID,true);
xmlhttp.send();
		}
});

	}



function getCustomer (regNumber) {
	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';
	document.getElementById("registerSaleButton").style.visibility='visible';
	document.getElementById("registerCallButton").style.visibility='hidden';
	
	 
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
salesTable = $('#sales').dataTable({
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
xmlhttp.open("GET","data/display_customer_data.php?regnumber="+regNumber,true);
xmlhttp.send();
document.getElementById("statusBar").innerHTML="";

}	


function convertStatus(regNumber, companyStatus)
{

	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';
	
	if(companyStatus=="lead") {	
	document.getElementById("appleIcon").src='images/apple-green.png';
	} else if(companyStatus=="opportunity") {
	document.getElementById("appleIcon").src='images/apple-red.png';
	} else if(companyStatus=="customer") {
	document.getElementById("appleIcon").src='images/apple-gold.png';
	} else if(companyStatus=="lost") { 
	document.getElementById("appleIcon").src='images/apple-rotten.png';
	} 

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/convert_customer_status.php?regNumber="+regNumber+"&companyStatus="+companyStatus,true);
xmlhttpi.send();


}


function loadInfo()
{
xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/get_info.php?regnumber="+document.getElementById('regButton').value,true);
xmlhttpi.send();
document.getElementById("statusBar").innerHTML="";

}


function editCompany() {

if(document.getElementById("companySaveContactDataIcon").style.visibility=="hidden") {	
document.getElementById("companyInternet").disabled=false;
document.getElementById("companyEmail").disabled=false;
document.getElementById("companyPhone").disabled=false;
document.getElementById("companyMobilePhone").disabled=false;
document.getElementById("companyFax").disabled=false;
document.getElementById("companyPostAddress").disabled=false;
document.getElementById("companySaveContactDataIcon").style.visibility="visible";
document.getElementById("statusBar").innerHTML="";

} else {
document.getElementById("companyInternet").disabled=true;
document.getElementById("companyEmail").disabled=true;
document.getElementById("companyPhone").disabled=true;
document.getElementById("companyMobilePhone").disabled=true;
document.getElementById("companyFax").disabled=true;
document.getElementById("companyPostAddress").disabled=true;
document.getElementById("companySaveContactDataIcon").style.visibility="hidden";
}

}


function saveCompanyContactData(regNumber) {
document.getElementById("companyInternet").disabled=true;
document.getElementById("companyEmail").disabled=true;
document.getElementById("companyPhone").disabled=true;
document.getElementById("companyMobilePhone").disabled=true;
document.getElementById("companyFax").disabled=true;
document.getElementById("companyPostAddress").disabled=true;

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
     document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
     }
  }
xmlhttpi.open("GET","data/save_company_contact_data.php?regNumber="+regNumber
+"&companyInternet="+document.getElementById('companyInternet').value 
+"&companyEmail="+document.getElementById('companyEmail').value 
+"&companyPhone="+document.getElementById('companyPhone').value 
+"&companyMobilePhone="+document.getElementById('companyMobilePhone').value 
+"&companyFax="+document.getElementById('companyFax').value 
+"&companyPostAddress="+document.getElementById('companyPostAddress').value 
,true);
xmlhttpi.send();


document.getElementById("companySaveContactDataIcon").style.visibility="hidden";

}



function saveNotes(regNumber)
{
xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
     document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
     }
  }
xmlhttpi.open("GET","data/save_notes.php?regNumber="+regNumber+"&notes="+document.getElementById('notes').value,true);
xmlhttpi.send();

}

function saveCallingDate(regNumber)
{
xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
     document.getElementById("lastContacted").innerHTML=xmlhttpi.responseText;
     }
  }
xmlhttpi.open("GET","data/save_calling_date.php?regNumber="+regNumber,true);
xmlhttpi.send();

}


function getData(regNumber, companyName) {
	
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("data").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","data/get_accounts.php?regnumber="+regNumber+"&name="+companyName,true);
xmlhttp.send();	

document.getElementById("graphHead").style.visibility='visible';    
document.getElementById("graphs").style.height='180px';
document.getElementById("graphs").src="data/get_charts.php?regnumber="+regNumber+"&name="+companyName;
document.getElementById("statusBar").innerHTML="";
}


function registerSale(regNumber) {
	document.getElementById("graphHead").style.visibility='visible';    
	document.getElementById("graphHead").innerHTML='<h1 class="ui-widget-header ui-corner-all" style="padding:2px;">&nbsp; <?php print $LANG['register_sale']; ?></h1>';  
	document.getElementById("graphs").style.height='300px';
  	document.getElementById("graphs").src="data/register_sale.php?regnumber="+regNumber;
	document.getElementById("statusBar").innerHTML="";
}

function editSales(regNumber,orderID) {
	document.getElementById("salesArea").innerHTML='';	
	document.getElementById("salesArea").style.visibility='hidden';
	document.getElementById("graphHead").style.visibility='visible';    
	document.getElementById("graphHead").innerHTML='<h1 class="ui-widget-header ui-corner-all" style="padding:2px;">&nbsp; <?php print $LANG['edit_sale']; ?></h1>';  
	document.getElementById("graphs").style.height='300px';
	document.getElementById('graphs').src="data/register_sale.php?regnumber="+regNumber+"&orderID="+orderID;	
	document.getElementById("statusBar").innerHTML="";
}

function deleteSales(regNumber,orderID) {
	jConfirm("<?php print $LANG['confirm_delete']." ".$LANG['order'].": "; ?>"+orderID+"", "<?php print $LANG['confirm_delete_heading'];?>", function(y) {
	if (y == true) {
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
    getCustomer(regNumber);
    }
  }
xmlhttp.open("GET","data/delete_order.php?orderID="+orderID,true);
xmlhttp.send();
		}
});

}
	


function showCustomers(companyStatus) {

customerStatus = companyStatus;

document.getElementById("registerSaleButton").style.visibility='hidden';
document.getElementById("registerCallButton").style.visibility='hidden';
	

if(companyStatus=="lead") { 
headingText="<?php print $LANG['leads'];?>"; 
document.getElementById("logoIcon").src='images/apple-green.png';
}
if(companyStatus=="opportunity") { 
headingText="<?php print $LANG['opportunities'];?>";
document.getElementById("logoIcon").src='images/apple-red.png'; 
}

if(companyStatus=="customer") { 
headingText="<?php print $LANG['sales'];?>"; 
document.getElementById("logoIcon").src='images/apple-gold.png';
}

if(companyStatus=="lost") { 
headingText="<?php print $LANG['lost'];?>"; 
document.getElementById("logoIcon").src='images/apple-rotten.png';
}

document.getElementById("heading").innerHTML=headingText;

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
xmlhttp2.open("GET","data/display_customers.php?companyStatus="+companyStatus,true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("graphs").src=""
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("allButton").style.visibility='hidden';
//document.getElementById("allButton").onclick = 'showCustomers('+customerStatus+')';
document.getElementById("statusBar").innerHTML="";
document.getElementById(companyStatus).defaultSelected = true;
}	
	


showCustomers('<?php print $companyStatus; ?>');

</script>
</body>
</html>

