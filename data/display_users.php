<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");

if($_SESSION['admin']) {
$query = "SELECT * from ".$users.""; 
} else {
$query = "SELECT * from ".$users." WHERE supervisorID=".$_SESSION['userID'];	
}	

$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
$i=1;
?>
<br>
<style type="text/css">
input.text { 
width:300px; 
} 
</style>
<table style="width:1000px">
<tr><td style="vertical-align:top">

<table style="width:450px;margin-right;5px">
<tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['users']; ?></h1></th></tr>

<?php
while($Row=MySQL_fetch_array($Result)) {
if ($Row['active']==0) {
	$inactive = "(".$LANG['inactive'].")";
	} else {
	$inactive = "";	
	}	
?>
<tr >
<td># <?php print $i; ?></td>
<td><a href="#" onclick="editItem('Users','edit','<?php print $Row['userID'];?>')" ><?php print htmlspecialchars($Row['fullName']);?></a> <span style="color:red"><?php print $inactive; ?></span>  </td>
<td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_user'];?>" onclick="editItem('Users', 'edit','<?php print $Row['userID'];?>')" alt="" > </td>
<td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_user'];?>" onclick="deleteItem('Users', '<?php print $Row['userID'];?>','<?php print $LANG['confirm_delete'].": ".$Row['fullName']."?";?>','<?php print $LANG['delete_user'];?>')" alt="" > </td>
</tr>

<?php 
$i++;
} ?>
</table>	

</td>
<td style="width:550px;vertical-align:top">

<table style="width:550px">
<tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
<tr>
<td style="text-align:center">
<div id="actionArea" style="text-align:center;">
<img src="images/add_product_32.png" onclick="editItem('Users','add','')" alt="<?php print $LANG['add_user']; ?>" >
<br>
<?php print $LANG['add_user']; ?>
</div>

</td>

</tr>
</table>

</td></tr>
</table>

<br>
