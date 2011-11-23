<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}


require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$notes = $_GET['notes'];

$query = "UPDATE ".$companies." SET comments='".$notes."' WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $LANG['notes_saved'];
		  }

