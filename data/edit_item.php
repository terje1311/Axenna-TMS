<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$itemType =  $_GET['itemType'];
$action = $_GET['action'];
$itemID = $_GET['itemID'];

// Get Field Names
$query = "SHOW FIELDS FROM `".$itemType."`";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 

if($action!="add") {
// Determine ID Field Name
while($Fields = MySQL_fetch_array($Result)) {
$IDField = $Fields[0];
break;
}
}

// Delete Item
if($action =="delete") {
$queryd = "DELETE FROM `".$itemType."` WHERE ".$IDField."=".$itemID;
	if (!$Resultd= mysql_db_query($DBName, $queryd, $Link)) {
         	print "No database connection <br>".$queryd;
    } else {
    print $LANG['data_deleted'];	
    }

} // end delete

if($action=="edit" || $action =="add" ) { 

// Edit or Add Item  

if($action=="edit") { 
// Get Data
$queryd = "SELECT * FROM `".$itemType."` WHERE ".$IDField."=".$itemID;
if (!$Resultd= mysql_db_query($DBName, $queryd, $Link)) {
         	print "No database connection <br>".$queryd;
    } 
$Rowd = MySQL_fetch_array($Resultd);
}

?>
<center>
<body>

<table summary="">
<tr>
<th> </th>
<form name="itemForm" id="itemForm">
</tr>
<?php
if($action == "add") {
$i=0;
} else {
$i=1;	
}

while($Row=MySQL_fetch_array($Result)) {
if($i>0) {	

?>
<tr>
<td><?php 
if($itemType=="Roles" && $itemID==1  && strstr($Row[1], "tinyint")) {  // don't display labels for check boxes if listing Admin role
	// do nothing
	} else { // display labels 
print $LANG[$Row[0]].": ";
}
?> </td>
<td>
<?php 
if(strstr($Row[1], "tinyint") ) {  // display checkbox if field type is tinyint/boolean

	if($itemType=="Roles" && $itemID==1 ) {  // don't display checkboxes if listing Admin role
	// do nothing
	} else { // display 
	
		if($Rowd[$i]==1) {
			$checked = "checked";
		} else {
			$checked = "";
		}	
?>
<input type="checkbox" value="1" id="<?php print "value".$i;?>" <?php print $checked; ?> ></input>
<?php 
	} // end if not admin role
} // end boolean


 
else if(strstr($Row[1], "date") ) {  // display date picker if fiels type isa date
?>
<input type="text" onclick="showDatePicker('<?php print "value".$i; ?>')" id="<?php print "value".$i;?>" value="<?php print $Rowd[$i];?>" > </input>
<?php 
} // end date


else if(strstr($Row[1], "text") ) {  // display text area if field type is text
?>
<textarea style="width:250px;height:100px" name="<?php print $Row[0];?>" id="<?php print "value".$i;?>">
<?php print $Rowd[$i];?>
</textarea>
</td>
<?php 
} else if(strstr($Row[0], "currencyID") ) {   // List currencies
$querycu = "SELECT * FROM ".$currencies;
if (!$Resultcu= mysql_db_query($DBName, $querycu, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="currencyID" id="<?php print "value".$i;?>">
<?php 
while($Rowcu=MySQL_fetch_array($Resultcu)) {
?>

<option value="<?php print $Rowcu['currencyID'];?>"><?php print $Rowcu['currencySymbol'];?></option>

<?php 
} // end Rowu loop
?>
</select>
<?php // List Product Owners
} else if(strstr($Row[0], "productOwnerID") ) {
$queryu = "SELECT userID, fullName FROM ".$users;
if (!$Resultu= mysql_db_query($DBName, $queryu, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="productOwnerID" id="<?php print "value".$i;?>">
<?php 
while($Rowu=MySQL_fetch_array($Resultu)) {
if($Rowu['userID']==$Rowd['productOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

?>

<option value="<?php print $Rowu['userID'];?>" <?php print $selected;?> ><?php print $Rowu['fullName'];?></option>

<?php 
} // end Rowu loop
?>
</select>

<?php 
} else if(strstr($Row[0], "supervisorID") ) { // List users to be selected as supervisors
$querysu = "SELECT userID, fullName FROM ".$users;
if (!$Resultsu= mysql_db_query($DBName, $querysu, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="supervisorID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['nobody'];?></option>
<?php 
while($Rowsu=MySQL_fetch_array($Resultsu)) {
if($Rowsu['userID']==$Rowd['supervisorID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>

<?php 
} // end Rowsu loop
?>
</select>


<?php 
} else if(strstr($Row[0], "managerID") ) {  // List users to be selected as Deapartment Managers
$querysu = "SELECT userID, fullName FROM ".$users;
if (!$Resultsu= mysql_db_query($DBName, $querysu, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="managerID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['nobody'];?></option>
<?php 
while($Rowsu=MySQL_fetch_array($Resultsu)) {
if($Rowsu['userID']==$Rowd['managerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>

<?php 
} // end Rowsu loop
?>
</select>



<?php   // List contract Types
} else if(strstr($Row[0], "contractID") ) {
$querycon = "SELECT contractID, contractName FROM ".$contracts;
if (!$Resultcon= mysql_db_query($DBName, $querycon, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="contractID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
while($Rowcon=MySQL_fetch_array($Resultcon)) {
if($Rowcon['contractID']==$Rowd['contractID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowcon['contractID'];?>"  <?php print $selected;?> ><?php print $Rowcon['contractName'];?></option>

<?php 
} // end Rowcon loop
?>
</select>


<?php   // List Workplaces
} else if(strstr($Row[0], "workplaceID") ) {
$queryw = "SELECT workplaceID, workplaceName FROM ".$workplaces;
if (!$Resultw= mysql_db_query($DBName, $queryw, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="workplaceID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
while($Roww=MySQL_fetch_array($Resultw)) {
if($Roww['workplaceID']==$Rowd['workplaceID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Roww['workplaceID'];?>"  <?php print $selected;?> ><?php print $Roww['workplaceName'];?></option>

<?php 
} // end Roww loop
?>
</select>


<?php   // List Departments
} else if(strstr($Row[0], "departmentID") ) {
$querydep = "SELECT departmentID, departmentName FROM ".$departments;
if (!$Resultdep= mysql_db_query($DBName, $querydep, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="departmentID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
while($Rowdep=MySQL_fetch_array($Resultdep)) {
if($Rowdep['departmentID']==$Rowd['departmentID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowdep['departmentID'];?>"  <?php print $selected;?> ><?php print $Rowdep['departmentName'];?></option>

<?php 
} // end Rowdep loop
?>
</select>


<?php   // List Super Departments
} else if(strstr($Row[0], "superDepartmentID") ) {
$querydep = "SELECT departmentID, departmentName FROM ".$departments;
if (!$Resultdep= mysql_db_query($DBName, $querydep, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="departmentID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
while($Rowdep=MySQL_fetch_array($Resultdep)) {
	
if($Rowdep['departmentID']==$Rowd['superDepartmentID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
if($Rowdep['departmentID']!=$Rowd['departmentID']) { // don't list own department
?>
<option value="<?php print $Rowdep['departmentID'];?>"  <?php print $selected;?> ><?php print $Rowdep['departmentName'];?></option>
<?php 
} // emd if
} // end Rowdep loop
?>
</select>



<?php // List Roles
} else if(strstr($Row[0], "roles") ) {
$queryr = "SELECT * FROM ".$roles;
if (!$Resultr= mysql_db_query($DBName, $queryr, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 
?>
<select name="roles" id="<?php print "value".$i;?>" multiple="multiple" size="<?php print mysql_num_rows($resultr); ?>">
<?php 
while($Rowr=MySQL_fetch_array($Resultr)) {
	
if( strstr($Rowd['roles'], $Rowr['roleID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>

<option value="<?php print $Rowr['roleID'];?>" <?php print $selected;?>  ><?php print $Rowr['roleName'];?></option>

<?php 
} // end Rowr loop
?>
</select>



<?php 
}  else { // List all other fields as text inputs
if($Rowd[$i]!=$Rowd['pwd']) { // don't lists passwords
$fieldVal = $Rowd[$i];
} else {
$fieldVal = "";
}
if($Rowd[$i]==$Rowd['userName'] && $itemID=="") { // Check if username Exists when registering new user
$onBlur = "onblur=checkUsername('+this.value+','value".$i."');";
} else {
$onBlur = "";
}	
?>
<?php if(strstr($Row[0], "documents") && $itemID!="") { ?>
<input type="hidden" id="<?php print "value".$i;?>">
<img src="images/folder_blue_32.png" title="<?php print $LANG['documents'];?>" onclick="uploadContract('<?php print $itemID;?>')" >
<?php } else { ?>
<input type="text" <?php print $onBlur;?> name="<?php print $Row[0];?>" id="<?php print "value".$i;?>" value="<?php print $fieldVal;?>">
<?php } ?>
</td>
<?php 
if($Rowd[$i]==$Rowd['userName'] && $itemID!="") { // Show user photo if available
// Check if userphoto is present
$dir    = "../documents/users/".$itemID."/userphoto/thumbnails/";
$files = scandir($dir);
$userPhoto = $files[2]; // select the first file after . and .. 
?>
<td rowspan="5" style="width:30px">
<img src="documents/users/<?php print $itemID; ?>/userphoto/thumbnails/<?php print $userPhoto; ?>" alt="" >
</td>
<?php 
} // end show user photo
}
}
 ?>

</tr>
<?php
$i++;
 } 
 ?>

<tr>
</form>
<td></td>
<td>

<?php 
if($itemType=="Products") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['productID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showproducts=false;showProducts()" value="<?php print $LANG['cancel'];?>">
<?php 
}
 
if($itemType=="Users") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['userID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showusers=false;showUsers()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Roles") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['roleID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showroles=false;showRoles()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Contracts") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['contractID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showcontracts=false;showContracts()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Workplaces") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['workplaceID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showroles=false;showWorkplaces()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Departments") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['departmentID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showroles=false;showDepartments()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="OrderStatus") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['orderStatusID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showroles=false;showOrderStages()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="Currencies") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['currencyID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="Showroles=false;showCurrencies()" value="<?php print $LANG['cancel'];?>">
<?php 
}
?>



</td>

</tr>

</table>

<script type="text/javascript" >

</script>

</center>
<?php 
} // end if delete or edit/add
?>
</body>