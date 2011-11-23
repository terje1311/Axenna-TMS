<?php
include_once "../lang/".$_SESSION['lang'].".php";
include_once "db.php";

$orgn = $_GET['regnumber'];
$name = strtolower(str_replace(" ", "-", $_GET['name']));

//$name="axenna-enterprise-ltd";

$handle = fopen("http://www.proff.no/regnskapdetaljerte/".$name."/halden/-/".$orgnr."/", "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    }
    fclose($handle);
}


$dom = new domDocument;

    /*** load the html into the object ***/
    $dom->loadHTML($doc);

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the table by its tag name ***/
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

echo '<h1>'.$s_accounts.'</h1>';    
echo '<table class="bluetable" style="font-size:0.9em;">';

echo '<tr><td valign="top"><table align="left" style="font-size:1.2em;">';
    /*** loop over the table rows ***/
    $i = 0;
    
    
    foreach ($rows as $row)
    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');  // get data
        $heads = $row->getElementsByTagName('th');  // get headings
    
        
      if($i==0) {
      	  
echo '<tr class="tablehead">';
echo '<td></td>';

$h=0;
foreach($heads as $head) {
if($head->nodeValue!="Graf") {  // don't include this header
echo '<td style="width:100px;">'.$head->nodeValue.'</td>';
}
$h++;
}
echo '</tr>';

}

      if($i>0 && $i!=26 && $i!=31 && $i!=94 && $i!=105 && $i!=113 && $i!=106  && $i<125) {    // include only these rows

			if($i==32 || $i==33 || $i==63 || $i==73 || $i==95 || $i==107 || $i==114 || $i==123) {  // these are headings 
       	echo '<tr class="tablehead">';
			} else {       																								// these are data 
       	echo '<tr class="'.$class_value.'">';
       	}

       	echo '<td>'.$i.'</td>';
       	echo '<td style="width:150px;">'.trim(utf8_decode($heads->item(0)->nodeValue)).'</td>';
			
			if($i == 124) {	
			$start_str = 1;
			} else {
			$start_str = 0;		
			}			
			
			for ($a = $start_str; $a < $cols->length-1; $a++) {	 	
			
			$value = trim(utf8_decode($cols->item($a)->nodeValue));		 		
					 	
		 	if($value=="?"){ 		
				$value="0";		 	
		 		}
		 			echo '<td>'.$value.'</td>';    
					
					}  // end listing col 
			echo '</tr>';
						if($class_value == "blank") {
						$class_value = "colored";
						} else {
							$class_value = "blank";
							} 			
						
			
      }
	
		$i++;
    }


echo '</table>';
echo '</td></tr></table>';

 ?>
