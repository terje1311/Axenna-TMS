<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
<script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 

</head>
<body>
<?php 
include_once "menu.php";
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
</script> 


<div id="main_table">
<h1 class="ui-widget-header ui-corner-all" style="padding:3px 3px 3px 10px;"><span id="heading"><?php print $LANG['administration']; ?></span></h1>
<?php 
if(isset($_SESSION['admin'])) {
?>
<div  style="width:95%;padding:4px">
<table style="width:100%;font-weight:normal;font-size:1em;margin-bottom:0px;padding;0px" class="ui-widget-header ui-corner-all" >
<tr>
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
</tr>
</table>		                
<?php 
} 
?>		
<div id="adminArea" style="width:100%;font-size:0.9em"></div>

</div>

</div>
</div>

<script type="text/javascript">


	$(function() {
		$( "#datepicker" ).datepicker();
	});


</script>
</body>
</html>

