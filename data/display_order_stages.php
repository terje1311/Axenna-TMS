<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../index.php");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");

$query = "SELECT * from ".$orderstatus.""; 
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
$i=1;
?>
<br>
<style type="text/css">
input.text { 
width:300px; 
} 
</style>
<table style="width:900px">
<tr><td style="vertical-align:top">

<table style="width:400px;margin-right;5px">
<tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['order_stages']; ?></h1></th></tr>

<?php
while($Row=MySQL_fetch_array($Result)) {
?>
<tr >
<td># <?php print $i; ?></td>
<td><a href="#" onclick="editItem('OrderStatus','edit','<?php print $Row['orderStatusID'];?>')" ><?php print htmlspecialchars($Row['orderStatusName']);?></a></td>
<td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_order_status'];?>" onclick="editItem('OrderStatus', 'edit','<?php print $Row['orderStatusID'];?>')" alt="" > </td>
<td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_order_status'];?>" onclick="deleteItem('OrderStatus', '<?php print $Row['orderStatusID'];?>','<?php print $LANG['confirm_delete'].": ".$Row['orderStatusName']."?";?>','<?php print $LANG['delete_order_status'];?>')" alt="" > </td>
</tr>

<?php 
$i++;
} ?>
</table>	

</td>
<td style="width:500px;vertical-align:top">

<table style="width:500px">
<tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
<tr>
<td style="text-align:center">
<div id="actionArea" style="text-align:center;">
<img src="images/folder_lists_32.png" onclick="editItem('OrderStatus','add','')" alt="<?php print $LANG['add_order_status']; ?>" >
<br>
<?php print $LANG['add_order_status']; ?>
</div>

</td>

</tr>
</table>

</td></tr>
</table>

<br>
