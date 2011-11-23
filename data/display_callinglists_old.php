<?php 
session_start();
require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";
$ownerID = $_SESSION['userID'];

$query = "SELECT listID, listName, place, branch, Comments, userName FROM ".$callinglists.", ".$users."  WHERE ownerID=userID order by dateCreated desc";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 

echo '<span id="container">';		
echo '<span class="full_width">';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
echo '<thead>';
echo '<tr><th style="width:250px">'.$LANG['list_name'].'</th><th>'.$s_place.'</th><th style="width:250px" >'.$s_business_branch.'</th><th>'.$s_owner.'</th><th  style="width:150px">'.$s_comments.'</th></tr>';
echo '</thead>';


while($Row=MySQL_fetch_array($Result)) {

echo '<tr><td><a href="javascript:displayListItems(\''.$Row['listID'].'\')">'.$Row['listName'].'</a></td><td>'.$Row['place'].'</td><td>'.$Row['branch'].'</td><td>'.$Row['userName'].'</td><td>'.$Row['Comments'].'</td></tr>';

    	}

echo '</table>';
echo '</span>';		
echo '</span>';

?>

