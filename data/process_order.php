<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$orderID = mysql_real_escape_string($_GET['orderID']);
$regNumber = mysql_real_escape_string($_GET['regNumber']);
$productID = mysql_real_escape_string($_GET['productID']);
$unitPrice = mysql_real_escape_string($_GET['unitPrice']);
$orderDate = mysql_real_escape_string($_GET['orderDate']);
$customerContact = utf8_decode(mysql_real_escape_string($_GET['customerContact']));
$creditDays = mysql_real_escape_string($_GET['creditDays']);
$otherTerms = utf8_decode(mysql_real_escape_string($_GET['otherTerms']));
$comments = utf8_decode(mysql_real_escape_string($_GET['comments']));

if($_GET['orderStatusID']!="") {
$orderStatusID = mysql_real_escape_string($_GET['orderStatusID']);
} else {
$orderStatusID = 1;
}

	$queryType = "UPDATE";
	$queryEnd="WHERE orderID=".$orderID."";


$query =  $queryType." ".$orders." SET 
regNumber='".$regNumber."', 
productID='".$productID."',
orderStatusID = '".$orderStatusID."',
salesRepID='".$_SESSION['userID']."',
unitPrice='".$unitPrice."',
orderDate='".$orderDate."',
customerContact='".$customerContact."',
creditDays='".$creditDays."',
otherTerms='".$otherTerms."',
orderComments='".$comments."',
regDate=NOW() ".$queryEnd.";";


if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "Order not saved <br>".$query."<br>".mysql_error();
        } else {
			print $LANG['data_saved'];
		}

?>
