<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");


$query = "SELECT * from ".$users." WHERE userID=".$_SESSION['userID'];	

$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
$i=1;
?>
<br>
<style type="text/css">
input.text { 
width:300px; 
} 
</style>
<table style="width:1020px">
<tr><td style="vertical-align:top">
<iframe style="margin:0;padding:0;border:none;width:570px;height:500px" src="lib/upload/index.php?photo=yes&userID=<?php print $_SESSION['userID']; ?>"></iframe>
</td>
<td style="width:450px;vertical-align:top">
<table style="width:450px">
<tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
<tr>
<td style="text-align:center">
<div id="actionArea" style="text-align:center;"></div>

</td>

</tr>
</table>

</td></tr>
</table>

<br>
