<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../index.php;");
}

include_once("db.php");

$docType = $_POST['docType'];
$file = $_POST['file'];
$userID = $_POST['userID'];

if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
  }

if($docType=="contractDocument") {
$query = "UPDATE ".$users." SET contractDocument='".$file."'  WHERE userID=".$userID;
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
}

?>

