<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$ID = $_GET['ID'];
$regNumber = $_GET['regNumber'];

$redirect = $_GET['redirect'];

$query = "DELETE FROM Companies WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
			print $LANG['customer_deleted'];
		  }

if($regNumber!="") {
$queryL = "UPDATE ".$callinglists." SET salesRepID=0 WHERE Orgnr=".$regNumber;
	if (!$ResultL= mysql_db_query($DBName, $queryL, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
        	print "Moved back to callinglist";
     }   	
}	
?>