<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../index.php;");
}
header('Content-type: text/xml');
require_once("db.php");
// Get Area Names for Javascript select boxes
print"<?xml version=\"1.0\"?>\n";
print "<complete>\n";
$mask = $_GET['mask'];

$query = "SELECT ID, SN2007, Tekst_SN2007 from ".$branchcodes." WHERE Tekst_SN2007 like '".mysql_real_escape_string($mask)."%' order by Tekst_SN2007";
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());

while($Row=MySQL_fetch_array($Result)) {
print"<option value=\"".utf8_encode($Row['Tekst_SN2007'])."\">".$Row['Tekst_SN2007']."</option>\n";
}
print "</complete>";
?>

