<?php
include_once "lang/".$_SESSION['lang'].".php";
include_once "data/db.php";
$customer ="";
$orgn = $_GET['regnumber'];
$handle = fopen("http://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=".$orgn, "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    }
    fclose($handle);
}

$startpos = strpos($doc,'<table border="0" width="100%">');
$endpos = strpos($doc, '<td class="liste" colspan="3">', $startpos);
$length = $endpos - $startpos;
$infotable1 = substr($doc, $startpos, $length);
$infotable = str_replace("<br>", ", ", $infotable1);


//echo $infotable; 

$dom = new domDocument;

    /*** load the html into the object ***/
    $dom->loadHTML($infotable);

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the table by its tag name ***/
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

echo '<form name="regform" method="POST" action="save_customer.php">';
echo '<table style="width:950px;font-size:0.9em;background-color:#dedede;border:solid 1px #777777">';
echo '<tr><td valign="top"><table align="left">';
    /*** loop over the table rows ***/
	 $button_value = $LANG['create_customer'];
    $i = 0;
    foreach ($rows as $row)
    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');
        /*** echo the values ***/
	if($i==0) { // check if already customer
	$regnumber=str_replace(" ","", $cols->item(1)->nodeValue);
	$regnumber = trim($regnumber);	
	$query = "SELECT companyName from ".$companies." WHERE regNumber=".$regnumber;
	if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        }
     if($Row=MySQL_fetch_array($Result)) {
     $customer = $Row['companyName']; 
	  $button_value = $LANG['already_customer'];
	  $button_status = " disabled ";
	  $button_style = "color:red;";
         }
	}        
        
if($i==10) {
	echo '</table><table>';
	}        
        
      if($i<17) {  
       	echo '<tr><td style="width:150px;">'.trim(utf8_decode($cols->item(0)->nodeValue)).'</td>';
				if($i==14 || $i==15) {
      			$value_full = ltrim(utf8_decode($cols->item(1)->nodeValue));
      			$pos = strpos($value_full, " ");
      			$value = substr($value_full, 0, $pos);		
				} elseif($i==16) { 		 					
					$value_full = trim(utf8_decode($cols->item(1)->nodeValue));		 		
	 				$value = str_replace(",","", $value_full);
	 				$value = str_replace(" ","", $value);
				} else {
 			 		$value = trim(utf8_decode($cols->item(1)->nodeValue));		 		
	 			}
		 			
 			echo '<td><input type="text" name="'.$i.'" style="width:300px;font-size:0.9em;" value="'.$value.'"></td></tr>';    
      }
		$i++;
    }

echo '<tr><td colspan="2" align="right"><input id="but1" style="'.$button_style.'" type="submit" value="'.$button_value.'" '.$button_status.'></td></tr>';
if($customer!="") {
   	echo '<tr><td colspan="2" align="right"><input type="button" onclick="document.location=\'show_customer.php?regnumber='.$regnumber.'\'" value="'.$LANG['show'].' '.$customer.'"></td></tr>';
	}
echo '</table>';
echo '</td></tr></table></form>';
 ?>
