<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$companyInternet = $_GET['companyInternet'];
$companyEmail = $_GET['companyEmail'];
$companyPhone = $_GET['companyPhone'];
$companyMobilePhone = $_GET['companyMobilePhone'];
$companyFax = $_GET['companyFax'];
$companyPostAddress = $_GET['companyPostAddress'];

$query = "UPDATE ".$companies." SET 
companyInternet='".$companyInternet."', 
companyEmail='".$companyEmail."',
companyPhone='".$companyPhone."',
companyMobilePhone='".$companyMobilePhone."',
companyFax='".$companyFax."',
companyPostAddress='".$companyPostAddress."'
WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $LANG['company_contact_data_saved'];
		  }
?>