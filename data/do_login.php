<?php
session_start();
require_once("db.php");

$userName = $_POST['userName'];
$pwd = md5($_POST['pwd']);

// SET SESSION USER VARIABLES

if(!isset($_SESSION['lang'])) {
$_SESSION['lang']="nb_NO";
}	


$query = "SELECT userID, fullName, roles, userEmail, phone, active, mobilePhone from ".$users." WHERE userName = '".mysql_real_escape_string($userName)."' and pwd='".$pwd."'";
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());

if($Row=MySQL_fetch_array($Result))  { // user exists 

if($Row['active']) { // user is active, set variables
	
$_SESSION['userID'] = $Row['userID'];
$_SESSION['fullName'] = $Row['fullName'];
$_SESSION['roles'] = $Row['roles'];
$_SESSION['userEmail'] = $Row['userEmail'];
$_SESSION['phone'] = $Row['phone'];
$_SESSION['mobilePhone'] = $Row['mobilePhone'];

// SET SESSION COMPANY VARIABLES
$queryc = "SELECT * from ".$preferences." WHERE companyID=1 ";
$Resultc = mysql_db_query($DBName, $queryc, $Link) or die(MySql_error());
$Rowc=MySQL_fetch_array($Resultc);
$_SESSION['companyName'] = $Rowc['companyName'];
$_SESSION['companyEmail'] = $Rowc['companyEmail'];
$_SESSION['creditDays'] = $Rowc['defaultCreditDays'];
$_SESSION['currency'] = $Rowc['defaultCurrency'];
$_SESSION['regNumber'] = $Rowc['companyRegNumber'];
$_SESSION['companyInternet'] = $Rowc['companyInternet'];
$_SESSION['companyPhone'] = $Rowc['companyPhone'];
$_SESSION['companyBankAccount'] = $Rowc['companyBankAccount'];

// SET SESSION ROLE AND MODULE RIGHTS
$Roles = explode(',', $Row['roles']);
foreach ($Roles as $Role) {
if($Role==1) { // set Admin rights - admin is always roleID 1
	$_SESSION['admin'] = "yes";
	}
$Rolestr .= $Role." OR roleID like ";
}
$Rolestr = substr($Rolestr, 0, strlen($Rolestr)-15);

$queryr = "SELECT * from ".$roles." WHERE roleID like ".$Rolestr;
$Resultr = mysql_db_query($DBName, $queryr, $Link) or die(MySql_error());
while($Rowr=MySQL_fetch_array($Resultr)) {
if($Rowr['supervisorRights']==1) {
	$_SESSION['supervisor'] = "yes";
	}
if($Rowr['salesModule']==1) {
	$_SESSION['salesModule'] = "yes";
	}
if($Rowr['orderModule']==1) {
	$_SESSION['orderModule'] = "yes";
	}
if($Rowr['reportModule']==1) {
	$_SESSION['reportModule'] = "yes";
	}
}

print $_SESSION['fullName'];   // Send full name to login form 

} else { // user account is inactive
print "inactive";
}

} else {  // user name or pwd is not found 
print "nologin";
}
?>

