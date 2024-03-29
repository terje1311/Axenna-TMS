<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: _top");
}

require_once "db.php";
include_once "../lang/".$_SESSION['lang'].".php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="../css/styles.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="../lib/jquery/development-bundle/themes/<?php print $_SESSION['style']?>/jquery.ui.all.css">
<link rel="stylesheet" href="../lib/jquery/development-bundle/demos/demos.css">

	<script src="../lib/jquery/development-bundle/jquery-1.4.2.js"></script>
	<script src="../lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="../lib/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="../lib/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="../lib/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-no.js"></script>
</head>

<body style="margin:0px">
<?php

$regNumber = trim($_GET['regnumber']);


if($_GET['orderID']!="") {
$orderID = $_GET['orderID'];
} else if($_POST['orderID']!="") {
$orderID = $_POST['orderID'];
}	
	
$formAction = "Insert";

if($orderID!="") { // GET Order Data

$formAction = "Update";

$query = "SELECT * FROM ".$orders." WHERE orderID=".$orderID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         print "No database connection <br>".mysql_error();
    } 
while ($Row=MySQL_fetch_array($Result)) { // get order data rows
$unitPrice = $Row['unitPrice'];
$creditDays = $Row['creditDays'];
$productID = $Row['productID'];
$comments = $Row['orderComments'];
$customerContact = $Row['customerContact'];
$otherTerms = $Row['otherTerms'];
$orderDate = $Row['orderDate'];
$regNumber = $Row['regNumber'];
}    

} // end get order data


if($orderDate=="") {	
$orderDate = date("Y-m-d");	
}

if($creditDays=="") {
	$creditDays = $_SESSION['creditDays'];
	}  

if($customerContact=="") {
		// Get company manager from company table		
		$queryc = "SELECT companyManager FROM ".$companies." WHERE regNumber=".$regNumber;
			if (!$Resultc= mysql_db_query($DBName, $queryc, $Link)) {
           print "No database connection <br>".mysql_error();
        	} else { 
        		$Rowc=MySQL_fetch_array($Resultc);
			}        
		
			$customerContact = $Rowc['companyManager'];
		} 


?>


<script type="text/javascript" >
var price = new Array();
var productDescription = new Array();
var standardTerms = new Array();
</script>


<table class="ui-widget-content ui-corner-all" style="height:200px;font-size:12px;padding:10px;float:left;margin-right:5px;">
<form id="registerForm" method="post" action="save_order.php?formAction=<?php print $formAction; ?>">
<input type="hidden" name="regNumber" value="<?php print $regNumber;?>">
<input type="hidden" name="orderID" value="<?php print $orderID;?>">
<tr>
<td width="150"><?php print $LANG['product']; ?>:</td>
<td>
<select style="width:250px;" id="product" name="productID" onchange="setPrice(this.options[this.selectedIndex].value)">

<?php

$selected="";


$querys = "SELECT * FROM ".$products." ORDER by productName";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while ($Rows=MySQL_fetch_array($Results)) {  // list products 

?>
<script type="text/javascript" >
price[<?php print $Rows['productID'];?>] = '<?php print $Rows['unitPrice']; ?>';
productDescription[<?php print $Rows['productID'];?>] = '<?php print $Rows['productDescription']; ?>';
standardTerms[<?php print $Rows['productID'];?>] = '<?php print $Rows['standardTerms']; ?>';
</script>
<?php

	
if($orderID!="") {

if($Rows['productID']==$productID) { 
$selected="selected";
} else {
$selected="";
}

}
?>
<option id="<?php print $Rows['productID'];?>" value="<?php print $Rows['productID'];?>"  <?php print $selected; ?> ><?php print $Rows['productName'];?></option>
<?php 
} // end list products
?>
</select>
&nbsp;
</td>
<td>
<?php print $LANG['order_date'];?>: &nbsp;
</td>
<td valign="top">
<input type="text" style="width:150px;" id="orderDate" name="orderDate" value="<?php print $orderDate; ?>" >
</td>
</tr>

<tr>
<td><?php print $LANG['negotiated_price'];?></td>
<td>
<input type="text" style="width:220px;" id="unitPrice" name="unitPrice" class="editField" value="<?php print $unitPrice; ?>"> <?php print $_SESSION['currency']; ?>
</td>
<td style="text-align:right;">
<?php print $LANG['notes'];?>: &nbsp;
</td>
<td valign="top" rowspan="3">
<textarea style="width:250px;height:98px" id="comments" name="comments" class="editField">
<?php print $comments; ?>
</textarea>

</td>

</tr>

<tr>
<td><?php print $LANG['credit_days']; ?>:</td>
<td>
<input type="text" style="width:250px;" id="creditDays" name="creditDays" class="editField" value="<?php print $creditDays; ?>">
</td>
</tr>

<tr>
<td valign="top"><?php print $LANG['other_terms']; ?>:</td>
<td>
<textarea style="width:250px;height:70px" id="otherTerms" name="otherTerms" class="editField">
<?php print $otherTerms; ?>
</textarea>
</td>
</tr>

<tr>
<td><?php print $LANG['contact_person']; ?>:</td>
<td><input type="text" style="width:250px;" id="customerContact" name="customerContact" class="editField" value="<?php print $customerContact; ?>"></td>
<td></td>
<td valign="top">
<img  id="companyregisterSalesButton" src="../images/save_22.png" title="<?php print $LANG['save'];?>" style="float:left;border:none" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';" onclick="saveOrder()" border="0" alt="" >
<?php 
if($orderID!="") {
?>
&nbsp;
<input type="button" onclick="document.location='order_confirmation.php?orderID=<?php print $orderID;?>';" value="<?php print $LANG['send_order_confirmation']; ?>">
<?php	
}	
?>

</td>
</form>
</tr>

</table>

<table class="ui-widget-content ui-corner-all" style="width:400px;font-size:12px;padding:10px;height:200px;vertical-align:top;margin-left:5px;">
<tr>
<td class="ui-widget-header ui-corner-all" style="text-align:center;height:15px;">
<?php print $LANG['description'];?>
</td>
</tr>
<tr>
<td valign="top" id="description"> 
<?php 
if($orderID!="") {
print "<br>".$LANG['order_registered'];

print "<p><b>".$LANG['order_number'].":</b> ".$orderID."<br>";	
}
?>
</td>
</tr>
</table>

<script type="text/javascript" >
function setPrice(priceID) {
document.getElementById("unitPrice").value = price[priceID];
document.getElementById("description").innerHTML = productDescription[priceID];
document.getElementById("otherTerms").innerHTML = standardTerms[priceID];
}




<?php
if ($orderID=="") {
?>
setPrice(document.getElementById("product").options[document.getElementById("product").selectedIndex].value);
<?php } ?>

function saveOrder() {
	parent.document.getElementById("appleIcon").src='images/apple-gold.png';
	parent.document.getElementById("companyStatus").options["customer"].selected=true;
		
	document.getElementById("registerForm").submit();
	}

</script>


<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "no" ] );
		$( "#orderDate" ).datepicker( $.datepicker.regional[ "no" ] );	
		});
</script>


</body>
</html>

