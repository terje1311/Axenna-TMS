<?php
$server = "localhost";
$username = "norskver_online";
$password= "online432A";
$Link = mysql_connect($server, $username, $password);
$DBName = "norskver_online";

//Table Names

$orders = " `Orders`";
$accounts = " `Regnskap`";
$companies = " `Companies`";
$companystatus = " `CompanyStatus`";
$salesreps = " `SalesReps`";
$branchcodes = " `BranchCodes`";
$invoices = " `Invoices`";
$products = " `Products`";
$orderstatus = " `OrderStatus`";
$contacts = " `Contacts`";
$branches = " `BranchCodes`";
$callinglists = " `RavnInfo`";
$callinglistcompanies = " `CallingListCompanies`";
$users = " `Users`";
$preferences = " `Preferences`";
$departments = " `Departments`";
$templates = " `Templates`";
$currencies = " `Currencies`";
$roles = " `Roles`";
$contracts = " `Contracts`";
$workplaces = " `Workplaces`";
$modules = " `modules`";

?>
