<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$notes = $_GET['notes'];

$query = "UPDATE ".$companies." SET lastContacted=NOW() WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
$querys = "SELECT lastContacted from ".$companies." WHERE regNumber=".$regNumber;
$Results= mysql_db_query($DBName, $querys, $Link);
$Rows = MySQL_fetch_array($Results);     	
				print $Rows['lastContacted'];;
		  }

