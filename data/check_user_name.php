<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$userName = $_GET['userName'];
$query = "SELECT userID FROM ".$users." WHERE userName='".$userName."'";
// Check if username exists
if(mysql_num_rows(mysql_db_query($DBName, $query, $Link))){
print $LANG['user_name_exists'];
} else {
print "OK";	
}	
?>