<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");

$type = $_GET['Type'];
if($type=="In") {
	$registered = $LANG['punchedin'];
	$_SESSION['punched'] = "in - ".date("D d. M - H:i:s");
	$color = "blue";
	} else {
	$registered = $LANG['punchedout'];	
	$_SESSION['punched'] = "out - ".date("D d. M - H:i:s");
	$color = "red";
	}

$userID = $_GET['userID'];

$query = "INSERT INTO Workhours SET Type='".$type."', userID='".$userID."', Stamp=NOW()";
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());

print "<span style=\"color:".$color."\">".$registered." - ".date("D d. M - H:i:s")."</span>";

?>

