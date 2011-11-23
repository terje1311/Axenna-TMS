<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body >
<?php 
include_once "menu.php";
?>


<div id="main_table">

<h1 class="ui-widget-header ui-corner-all" style="padding:3px;">&nbsp; <?php print $LANG['calling_lists']; ?> <input id="allButton" type="button" onclick="showAllLists()" value="<?php print $LANG['show_all'];?>"> 


<?php print $LANG['search'];?>: 

<select id="searchColumn">
<option value="Orgnr"><?php print $LANG['org_number']; ?></option>
<option value="Firmanavn"><?php print $LANG['company_name']; ?></option>
<option value="City"><?php print $LANG['place']; ?></option>
<option value="Bransjer"><?php print $LANG['business_branch']; ?></option>
<option value="AccountYear"><?php print $LANG['last_account_year']; ?></option>

</select>



<input ID="searchField" type="text" name="searchField">
<input  type="button" onclick="searchCallingList()" value="<?php print $LANG['search']; ?>"> 
</h1>


<div id="list"></div>

<div id="graphHead" style="visibility:hidden;"><h1><?php print $LANG['graphs_overview'];?> </h1></div>

<iframe src="" id="graphs" style="border:0;width:95%;height:180px;float:left;">

</iframe>



<div id="data" style="width:100%"></div>




</div>
<script type="text/javascript">

var oTable;

function deleteCustomer(companyName, companyStatus, ID) {
	y = confirm("<?php print $LANG['confirm_delete']; ?> "+companyName)
	if (y == true) {
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    alert(xmlhttp.responseText);
    showCustomers();
    }
  }
xmlhttp.open("GET","data/delete_customer.php?redirect="+companyStatus+"&ID="+ID,true);
xmlhttp.send();
	
		
		}
	}

function getCustomer (regNumber) {
	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';
	 
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","data/display_customer_data.php?regnumber="+regNumber,true);
xmlhttp.send();

}	

function loadInfo(regNumber)
{

	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/get_info.php?regnumber="+regNumber,true);
xmlhttpi.send();
document.getElementById("statusBar").innerHTML="";


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
document.getElementById("graphs").src="data/get_charts.php?regnumber="+regNumber+"&name="+companyName;
	
	}


function getGraphs(regNumber, companyName) {
	document.getElementById("graphHead").style.visibility='visible';    
    document.getElementById("graphs").src="data/get_charts.php?regnumber="+regNumber+"&name="+companyName;

 	}



function showAllLists (limitStart, limitEnd) {

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
xmlhttp2.open("GET","data/display_callinglists.php?limitStart="+limitStart+"&limitEnd="+limitEnd,true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("graphs").src=""
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("allButton").style.visibility='hidden';
	
}	
	

	
function searchCallingList (limitStart, limitEnd) {


if(document.getElementById("searchField").value!="") {  

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
xmlhttp2.open("GET","data/search_callinglist.php?limitStart="+limitStart+"&limitEnd="+limitEnd+"&field="+document.getElementById("searchColumn").options[document.getElementById("searchColumn").selectedIndex].value+"&phrase="+document.getElementById("searchField").value,true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("graphs").src=""
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("allButton").style.visibility='visible';

} else {
document.getElementById("statusBar").innerHTML='<?php print $LANG['search_field_empty']; ?>';
}
}		
	

function convertStatus(regNumber, companyStatus)
{

	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/convert_customer_status.php?regNumber="+regNumber+"&companyStatus="+companyStatus,true);
xmlhttpi.send();
}

function makeLeads() {
	var total="";
if (document.getElementById('listForm').makeLead[0].value!="") {
	
	for(var i=0; i < document.getElementById('listForm').makeLead.length; i++){
		if(document.getElementById('listForm').makeLead[i].checked)
		total +=document.getElementById('listForm').makeLead[i].value + ","
	}
if(total=="") {
alert("Velg ett eller flere firma du vil lagre som Lead(s)") 
} else { //send data

document.getElementById("statusBar").innerHTML="<?php print $LANG['processing']."... ";?>";

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","data/create_many_leads.php?list="+total,true);
xmlhttpi.send();
  
		}	// end send data
}	
showAllLists();


}
	
showAllLists();
document.getElementById("statusBar").innerHTML="";


</script>


</body>
</html>