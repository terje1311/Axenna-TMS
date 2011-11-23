<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
} else {
header('Content-type: text/xml');
}

require_once("db.php");
// Get Area Names for Javascript select boxes
print"<?xml version=\"1.0\"?>\n";
print "<complete>\n";
$mask = $_GET['mask'];

$query = "SELECT ID, regNumber, companyName from ".$companies." WHERE companyName like '".mysql_real_escape_string($mask)."%' order by companyName";
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());

while($Row=MySQL_fetch_array($Result)) {
print"<option value=\"".$Row['regNumber']."\">".$Row['companyName']."</option>\n";
}
print "</complete>";
?>

