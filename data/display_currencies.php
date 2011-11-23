<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");

$query = "SELECT * from ".$currencies.""; 
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
<tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['currencies']; ?></h1></th></tr>

<?php
while($Row=MySQL_fetch_array($Result)) {
?>
<tr >
<td># <?php print $i; ?></td>
<td><a href="#" onclick="editItem('Currencies','edit','<?php print $Row['currencyID'];?>')" ><?php print htmlspecialchars($Row['currencyName']);?></a></td>
<td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_currency'];?>" onclick="editItem('Currencies', 'edit','<?php print $Row['currencyID'];?>')" alt="" > </td>
<td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_currency'];?>" onclick="deleteItem('Currencies', '<?php print $Row['currencyID'];?>','<?php print $LANG['confirm_delete'].": ".htmlspecialchars($Row['currencyName'])."?";?>','<?php print $LANG['delete_currrency'];?>')" alt="" > </td>
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
<img src="images/currencies_32.png" onclick="editItem('Currencies','add','')" alt="<?php print $LANG['add_currency']; ?>" >
<br>
<?php print $LANG['add_currency']; ?>
</div>

</td>

</tr>
</table>

</td></tr>
</table>

<br>
