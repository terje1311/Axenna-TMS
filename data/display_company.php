<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../login.php; Window-target: top");
}

require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";
$listID = $_GET['listID'];
$ID = $_GET['ID'];

$query = "SELECT * FROM ".$callinglistcompanies." as items JOIN ".$callinglists." as lists WHERE lists.listID = items.listID and items.ID = ".$ID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 

echo '<span id="container">';		
echo '<span class="full_width">';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display">';
echo '<thead>';
echo '<tr><th style="width:250px">'.$s_company_name.'</th><th>'.substr($s_org_number,0,3).'.</th><th>'.$s_place.'</th><th>'.$s_business_branch.'</th><th>'.$s_created.'</th><th style="width:150px">'.$s_comments.'</th></tr>';
echo '</thead>';


while($Row=MySQL_fetch_array($Result)) {

echo '<tr><td><a href="javascript:getData(\''.$Row['regNumber'].'\',\''.$Row['companyName'].'\')">'.$Row['companyName'].'</a></td><td>'.$Row['regNumber'].'</td><td>'.$Row['place'].'</td><td>'.$Row['branch'].'</td><td>'.$Row['dateCreated'].'</td><td>'.$Row['Comments'].'</td></tr>';

    	}

echo '</table>';
echo '<h2>'.$s_calls.'</h2>';
echo '<table class="greentable" width="100%">';
echo '<thead>';
echo '<tr><th style="width:100px">'.$s_contact_type.'</th><th>'.$s_time.'</th><th>'.$s_person.'</th><th>'.$s_telephone.'</th><th style="width:150px">'.$s_comments.'</th></tr>';
echo '</thead>';


echo '</span>';		
echo '</span>';

?>

