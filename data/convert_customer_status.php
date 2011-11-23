<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}


require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$companyStatus = $_GET['companyStatus'];


$query = "UPDATE ".$companies." SET companyStatus='".$companyStatus."' WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $LANG['company_status_changed'];
		  }

