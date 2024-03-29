<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";

$itemType = $_GET['itemType'];
$action = $_GET['action'];
$itemID = $_GET['itemID'];
$values = str_ireplace('false', '0', $_GET['values']);
$values = utf8_decode(str_ireplace('true', '1', $values));
$values = str_ireplace("\\", "", $values);


//print $values;
$valueArray = explode("|", $values);

$values = str_ireplace('|', ',', $values);


// Get Field Names
$query = "SHOW FIELDS FROM `".$itemType."`";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 

$a=0;

while($Fields = MySQL_fetch_array($Result)) {
	if($a==0) {
		$IDField = $Fields[0];
	} else {
		$fieldStr = $fieldStr.$Fields[0].","; // for adding new
		
			if($Fields[0]=="pwd") {  // check for password field
				if($valueArray[$a-1]!="\"\"") {
					$updateStr = $updateStr.$Fields[0]."=\"".md5(str_replace("\"", "", $valueArray[$a-1]))."\",";  // md5 password for updating	
				}				
			} else {
			$updateStr = $updateStr.$Fields[0]."=".$valueArray[$a-1].",";  // for updating all other fields	
			}			
		
	}
	$a++;
}

$fieldStr = substr($fieldStr, 0, strlen($fieldStr)-1); 
$updateStr = substr($updateStr, 0, strlen($updateStr)-1); 


// Insert new record
if($action=="save" && $itemID=="") {
$queryStart = "INSERT INTO `".$itemType."` SET ".$updateStr." ";
$queryEnd = "";
}


// Update record
if($action=="save" && $itemID!="") {
$queryStart = "UPDATE `".$itemType."` SET ".$updateStr." "; 
$queryEnd = "WHERE ".$IDField."=".$itemID;
 }

// Delete record
if($action=="delete" && $itemID!="") {
$queryStart = "DELETE FROM `".$itemType."` "; 
$queryEnd = "WHERE ".$IDField."=".$itemID;
}


$query = $queryStart.$queryEnd;


if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         	print "Data not saved<br>".mysql_error();
    } else {
    	print $LANG['data_saved'];
    	} 
    	


if($itemType=="Users") { // Create User Document Directories if needed 
	
	if($itemID=="") {
		$userID = mysql_insert_id();
	} else {
		$userID = $itemID;
	}

$userDir = "../documents/users/".$userID;
// Check if directories exist
if(!is_dir($userDir)) {  // create User Document Directory if not present
	if(mkdir($userDir, 0777) && mkdir($userDir."/thumbnails", 0777) && mkdir($userDir."/userphoto", 0777) && mkdir($userDir."/userphoto/thumbnails", 0777) ) {
   echo "... ".$LANG['user_directories_created'];
	} else {
   echo "Failed to create user directories...";
	}
} 

 	
} // End Create User Document Directories   	
    	
?>