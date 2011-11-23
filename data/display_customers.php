<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}
require_once "db.php";
require_once "../lang/".$_SESSION['lang'].".php";



$companyStatus = $_GET['companyStatus'];


$redirect = $companyStatus;
	

if(isset($_SESSION['admin']) ) {   // check for admin rights	

$query = "SELECT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
companyEmail, companyCity, lastContacted, comments, ".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
FROM ".$companies.", ".$users." WHERE companyStatus='".$companyStatus."' and ".$companies.".salesRepID=".$users.".userID"; 

} else if(isset($_SESSION['supervisor']) ) {   // check for supervisor rights	

$query = "SELECT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
companyEmail, companyCity, lastContacted, comments, ".$companies.".regDate, ".$companies.".salesRepID   
FROM ".$companies." WHERE companyStatus='".$companyStatus."' 
and salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") 
OR salesRepID=".$_SESSION['userID']; 

	} else {  // Display user's companies

$query = "SELECT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
companyEmail, companyCity, lastContacted, comments, ".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
FROM ".$companies.", ".$users." WHERE companyStatus='".$companyStatus."' and userID=".$_SESSION['userID']." 
and ".$companies.".salesRepID=".$users.".userID" ; 

}

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 

echo '<span style="width:95%;text-align:left;float:left;left-margin:20px">';		
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" style="font-size:1em;" id="example">';
echo '<thead>';
echo '<tr><th>#</th><th>'.$LANG['company_name'].'</th>
<th>'.$LANG['company_manager'].'</th>
<th>'.$LANG['phone'].'</th>
<th>'.$LANG['email'].'</th>
<th>'.$LANG['place'].'</th>
<th>'.$LANG['sales_rep'].'</th>
<th>'.$LANG['last_contacted'].'</th>
<th>'.$LANG['comments'].'</th>
<th></th></tr>';
echo '</thead>';
echo '<tbody>';

$i=1;
while($Row=MySQL_fetch_array($Result)) {
if ($Row['companyPhone']=="-" && $Row['companyMobilePhone']!="-" ) {
	$Row['companyPhone']=$Row['companyMobilePhone'];
  }	

echo '<tr><td>'.$i.'</td><td>';

if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor']) ) {   // check for admin or supervisor rights
echo '<a href="javascript:getCustomer(\''.$Row['regNumber'].'\')">';
}

echo $Row['companyName'];

if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor']) ) {   // check for admin or supervisor rights
echo '</a>';
}

echo '</td><td width="150">'.$Row['companyManager'].'</td>';

echo '<td>'.$Row['companyPhone'].'</td>
<td><a href="mailto:'.$Row['companyEmail'].'">'.$Row['companyEmail'].'</a></td>
<td>'.$Row['companyCity'].'</td>
<td>'.substr($Row['fullName'],0, strpos($Row['fullName']," ")).'</td>
<td>'.$Row['lastContacted'].'</td>';

echo '<td>'.substr($Row['comments'],0,15).'...</td><td>';


if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor']) ) {   // check for admin or supervisor rights
echo '<a href="javascript:deleteCustomer(\''.$Row['regNumber'].'\',\''.$Row['companyName'].'\', \''.$redirect.'\', \''.$Row['ID'].'\')"><img src="images/cancel_16.png" border=0 title="'.$s_delete.'"></a>';
}
echo '</td>';



'</tr>';
$i++;
    	}
echo '</body>';
echo '</table>';
echo '</span>';		
