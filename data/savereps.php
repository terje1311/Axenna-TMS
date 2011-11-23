<?php
// Get database Connection
require_once "db.php";
$field =null;
$res = mysql_db_query($DBName, "select * from ".$salesreps."", $Link);
$field_offset = intval($_POST['Field']);
$field = mysql_field_name($res, $field_offset);
//mysql_close($Link);

  $query="UPDATE ".$salesreps." SET ".$field."='".utf8_decode($_POST['value'])."'  WHERE ID=".$_POST['ID'];

    if (!$Result= mysql_db_query($DBName, $query, $Link)) {
          print "Data not saved <br>".mysql_error();
         } else {
          print  "Data saved";
         }

// Logging
//$fd = fopen('test.txt', 'w');
//$streng = "Verdi: ".$_POST['value']."\nKolonne: ".$_POST['Field']."\nID :".$_POST['ID'];
//fwrite ($fd, $streng);
//fclose($fd);
?>

      	
		
