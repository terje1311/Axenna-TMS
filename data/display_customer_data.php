<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}


require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$regNumber = trim($_GET['regnumber']);

$query = "SELECT * FROM ".$companies." INNER JOIN BranchCodes WHERE Companies.regNumber='".$regNumber."' and Companies.branchCode like BranchCodes.SN2007";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
if(!$Row=MySQL_fetch_array($Result)) {
	       print "No record found <br>".$query;
    	}
?>


<span style="width:95%;text-align:left;margin-right:20px">

<table class="ui-widget-content ui-corner-all"  style="float:left;height:170px;font-size:12px;" cellpadding="0" cellspacing="4">
<tr><td valign="top" style="width:450px;margin-right:10px;">
<table class="ui-widget-content" style="border:none;font-size:12px;padding:10px;height:100%;width:450px;">
<tr>
<td>
<?php
if($Row['companyStatus']=="lead") {
  $companyIcon = "apple-green.png";
} elseif($Row['companyStatus']=="opportunity") {
$companyIcon = "apple-red.png";	
	} elseif($Row['companyStatus']=="customer") {
$companyIcon = "apple-gold.png";	
	} else {
$companyIcon = "apple-rotten.png";	
	}
?>
<img id="appleIcon" src="images/<?php print $companyIcon;?>" style="width:32px;vertical-align:middle">

<?php print $LANG['org_number']; ?>:</td>
<td>
<span id="regNumber"><?php print $Row['regNumber']; ?></span> &nbsp;
<input type="button" value="<?php print $LANG['get_data'];?>" onclick="getData('<?php print $Row['regNumber'];?>','<?php print $Row['companyName'];?>'); getGraphs('<?php print $Row['regNumber'];?>','<?php print $Row['companyName'];?>')">
&nbsp; 
<select id="companyStatus" name="status" onchange="javaScript:convertStatus('<?php print $Row['regNumber'];?>',this.options[this.selectedIndex].value)">


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

$statusNamestr = $Rows['statusName'];

if ($statusNamestr == "customer") { $statusNamestr = "sales";   } 

$statusName = $LANG[$statusNamestr];
?>
<option id="<?php print $Rows['statusName'];?>" value="<?php print $Rows['statusName'];?>"  <?php print $selected;?> ><?php print $statusName;?></option>
<?php } ?>
</select>

</td>
</tr>

<tr>
<td><?php print $LANG['company_name']; ?>:</td>
<td><b><?php print $Row['companyName'];?></b></td>
</tr>

<tr>
<td><?php print $LANG['company_type']; ?>:</td>
<td><?php print $Row['companyType'];?></td>
</tr>

<tr>
<td><?php print $LANG['company_address']; ?>:</td>
<td><?php print $Row['companyAddress'];?></td>
</tr>

<tr>
<td><?php print $LANG['company_manager']; ?>:</td>
<td><?php print $Row['companyManager'];?></td>
</tr>

<tr>
<td><?php print $LANG['business_branch']; ?>:</td>
<td><?php print $Row['branchCode']." - ".$Row['Tekst_SN2007'];?>  </td>
</tr>
</table>


</td><td valign="top" style="width:300px">
<table class="ui-widget-content" style="border:none;font-size:12px;padding:10px;height:100%;width:300px">
<tr>
<td><a href="mailto:<?php print $Row['companyEmail']; ?>"><?php print $LANG['email']; ?></a>:</td>
<td>
<input type="text" id="companyEmail" name="companyEmail" style="color:black" disabled value="<?php print $Row['companyEmail']; ?>">
</td>
<td rowspan="3" valign="top">
<img id="companyEditIcon" src="images/edit_16.png" title="<?php print $LANG['edit'];?>" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';" onclick="editCompany();" border="0" alt="" >
<img id="companySaveContactDataIcon" src="images/save_16.png" title="<?php print $LANG['save'];?>" style="visibility: hidden;margin-top:5px;" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';" onclick="saveCompanyContactData(<?php print $regNumber?>);" border="0" alt="" >
</td>
</tr>
<tr>
<td><a href="http://<?php print $Row['companyInternet']; ?>" target="_blank">WWW</a>:</td>
<td colspan="2"><input type="text" id="companyInternet" name="companyInternet" style="color:black"  disabled value="<?php print $Row['companyInternet']; ?>"></td>
</tr>
<tr>
<td><?php print $LANG['phone']; ?>:</td>
<td colspan="2"><input type="text" id="companyPhone" name="companyPhone"  style="color:black" disabled value="<?php print $Row['companyPhone']; ?>"></td>
</tr>
<tr>
<td><?php print $LANG['mobile_phone']; ?>:</td>
<td colspan="2"><input type="text" id="companyMobilePhone" name="companyMobilePhone" style="color:black" disabled value="<?php print $Row['companyMobilePhone']; ?>"></td>
</tr>
<tr>
<td><?php print $LANG['fax']; ?>:</td>
<td colspan="2"><input type="text" id="companyFax" name="companyFax" style="color:black" disabled value="<?php print $Row['companyFax']; ?>"></td>
</tr>
<tr>
<td><?php print $LANG['post_address']; ?>:</td>
<td colspan="2"><input type="text" id="companyPostAddress" name="companyPostAddress"  style="color:black" disabled value="<?php print $Row['companyPostaddress'];?>"></td>
</tr>
</table>
</td></tr></table>


<table class="ui-widget-content ui-corner-all" style="font-size:12px;float:left;height:170px;margin-left:5px;" cellpadding="0" cellspacing="4">
<tr><td valign="top">
<table class="ui-widget-content"  style="border:none;padding:0px;float:left;height:100%;width:400px;font-size:12px;">
<tr>
<td valign="top">
<b><?php print $LANG['notes'];?></b> &nbsp; <img id="notesButton" onclick="maxNotes()" src="images/go_down_16.png" alt="" >
<a href="#" onclick="saveNotes(<?php print $regNumber?>)" ><img src="images/save_16.png" border="0" align="right" title="<?php print $LANG['save'];?>" alt="<?php print $LANG['save'];?>" /></a>

<form name="callForm" id="callForm" method="post">

<textarea id="notes" name="notes" style="width:100%;height:100px;">
<?php print $Row['comments'];?>
</textarea>
</form>
<?php print $LANG['last_contacted'].": "?> <span id="lastContacted"><?php print $Row['lastContacted']; ?></span> &nbsp; <a href="#" onclick="saveCallingDate(document.getElementById('regNumber').innerHTML)" ><img id="registerCallButton" src="images/voicecall_16.png" style="border:0px;vertical-align:bottom" title="<?php print $LANG['register_calling_date'];?>" alt="<?php print $LANG['register_calling_date'];?>" /></a>
</td>
</tr></table>
</td>
</tr></table>

<div id="salesArea" style="width:50%;visibility:visible">
<?php 
if($Row['companyStatus']=="customer") {   // List sales for customers
?>

<div class="clear">&nbsp;</div>
<h1 class="ui-widget-header ui-corner-all" style="width:100%;text-align:center;font-weight:bold"><?php print $LANG['sales']; ?></h1>

<table id="sales" class="display" style="font-size:1.1em">
<thead>
<th><?php print $LANG['order'];?></th>
<th><?php print $LANG['order_date'];?></th>
<th><?php print $LANG['product_name'];?></th>
<th><?php print $LANG['price'];?></th>
<th><?php print $LANG['sales_rep'];?></th>
<?php 
	if(isset($_SESSION['admin'])) {
?>
<th>&nbsp;</th>
<?php } ?>
</thead>

<?php 
$querys = "SELECT orderID, orderDate, productName, fullName, ".$orders.".unitPrice FROM ".$orders." , ".$products." , ".$users." WHERE ".$orders.".productID=".$products.".productID and ".$orders.".salesRepID=".$users.".userID and regNumber=".$Row['regNumber'];
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No sales found or no database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {

	       
   print"<tr><td>".$Rows['orderID']."</td><td>".$Rows['orderDate']."</td><td>".$Rows['productName']."</td><td>".$Rows['unitPrice']."</td><td>".$Rows['fullName']."</td>";
	if(isset($_SESSION['admin'])) {
	print "<td><a href=\"#\" onclick=\"editSales(".$regNumber.",".$Rows['orderID'].");\"><img src=\"images/edit_16.png\"></a>"; 
	print "&nbsp;<a href=\"#\" onclick=\"deleteSales(".$regNumber.",".$Rows['orderID'].");\"><img src=\"images/cancel_16.png\"></a></td>";   
	}
   print "</tr>"; 
	       
    	}

?>
</table>

<?php } ?>
</div>
</span>