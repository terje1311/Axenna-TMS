<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../lang/".$_SESSION['lang'].".php");

$companyName = mysql_real_escape_string($_GET['companyName']);
$companyRegNumber = mysql_real_escape_string($_GET['companyRegNumber']);
$companyAddress = mysql_real_escape_string($_GET['companyAddress']);
$companyZip = mysql_real_escape_string($_GET['companyZip']);
$companyCity = mysql_real_escape_string($_GET['companyCity']);
$companyPhone = mysql_real_escape_string($_GET['companyPhone']);
$companyFax = mysql_real_escape_string($_GET['companyFax']);
$companyEmail = mysql_real_escape_string($_GET['companyEmail']);
$companyInternet = mysql_real_escape_string($_GET['companyInternet']);
$defaultCurrency = mysql_real_escape_string($_GET['defaultCurrency']);
$defaultCreditDays = mysql_real_escape_string($_GET['defaultCreditDays']);
$companyBankAccount = mysql_real_escape_string($_GET['companyBankAccount']);
$companyManagerID = mysql_real_escape_string($_GET['companyManagerID']);



$query = "UPDATE ".$preferences." SET 
companyName = '".$companyName."', 
companyRegNumber = '".$companyRegNumber."', 
companyAddress = '".$companyAddress."', 
companyZip = '".$companyZip."', 
companyCity = '".$companyCity."', 
companyPhone = '".$companyPhone."', 
companyFax = '".$companyFax."', 
companyEmail = '".$companyEmail."', 
companyInternet = '".$companyInternet."', 
defaultCurrency = '".$defaultCurrency."', 
defaultCreditDays = '".$defaultCreditDays."',  
companyBankAccount = '".$companyBankAccount."',  
companyManagerID = '".$companyManagerID."' 
WHERE companyID = 1 ;"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $s_data_saved;
		  }

?>