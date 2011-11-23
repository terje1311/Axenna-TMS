<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location:login.php");
}

if(isset($_COOKIE['style'])) {
		$_SESSION['style'] = $_COOKIE['style'];
	} else if(!isset($_SESSION['style'])) {
		$_SESSION['style'] = "smoothness";
	}	

if($_GET['style']!="") {
	$_SESSION['style'] = $_GET['style'];
	setcookie('style',$_GET['style']);
	}


if(!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = "nb_NO";
	} 


ini_set('session.gc_maxlifetime', 360*60);
setlocale(LC_ALL,'nb_NO.utf8');


include_once "lang/".$_SESSION['lang'].".php";
include_once "data/db.php";
?>

<style type="text/css" title="currentStyle">
			@import "css/page_styles.css";
			@import "css/table_styles.css";
			@import "css/table_jui.css";
			
</style>
   
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.js"></script>
      <script type="text/javascript" language="javascript" src="lib/datatables/examples/examples_support/jquery.jeditable.js"></script>
		<script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
	<script src="lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="lib/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="lib/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="lib/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-<?php print strtolower(substr($_SESSION['lang'],3,2)); ?>.js"></script>
	<script src="lib/jquery/jquery.alerts.js"></script>	
	

	<link rel="stylesheet" href="lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
	<link rel="stylesheet" href="lib/jquery/jquery.alerts.css">
	

		 <link href="css/styles.css" type="text/css" rel="stylesheet">


<script type="text/javascript">
var lang = '<?php print strtolower(substr($_SESSION['lang'],3,2)); ?>'; // to be used in indexFunctions.js

var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

function jsddm_open()
{	jsddm_canceltimer();
	jsddm_close();
	ddmenuitem = $(this).find('ul').eq(0).css('visibility', 'visible');}

function jsddm_close()
{	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{	closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{	if(closetimer)
	{	window.clearTimeout(closetimer);
		closetimer = null;}}

$(document).ready(function()
{	$('#jsddm > li').bind('mouseover', jsddm_open);
	$('#jsddm > li').bind('mouseout',  jsddm_timer);});

document.onclick = jsddm_close;
</script>


<ul id="jsddm">
			<li><a href="index.php"><?php print $LANG['home']; ?></a></li>

			<li><a href="index.php"><?php print $LANG['sales_system']; ?></a>

				<ul>
					<li><a href="show_customer.php?status=lead"><img src="images/folder_green_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;<?php print $LANG['leads'];?></a></li>
					<li><a href="show_customer.php?status=opportunity"><img src="images/folder_red_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;<?php print $LANG['opportunities'];?></a></li>
					<li><a href="show_customer.php?status=customer"><img src="images/folder_yellow_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;<?php print $LANG['sales'];?></a></li>
					<li><a href="show_customer.php?status=lost"><img src="images/folder_brown_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;<?php print $LANG['lost'];?></a></li>
					<li><a href="show_callinglists.php"><img src="images/folder_blue_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;<?php print $LANG['calling_lists'];?></a></li>
				</ul>
			</li>

			<li><a href="index.php?#tabs-2"><?php print $LANG['order_system']; ?></a>

				<ul>

<?php
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {         
         
echo'<li><a href="show_orders.php?status='.$Rows['orderStatusID'].'"><img src="images/folder_blue_16.png" style="border:0px;vertical-align:middle;" alt="" />&nbsp;'.$Rows['orderStatusName'].'</a></li>';

}
?>
				
			</ul>
			</li>

<?php
if(isset($_SESSION['admin'])) {   // check for admin rights
?>
	<li><a href="index.php?#tabs-4">Admin</a>
		
		<ul>		
				
		</ul>
	</li>
<?php
}
?>	
	<li style="border-radius:7px;-moz-border-radius:7px;"><a href="#">Linker</a>
						<ul>
							<li><a href="http://www.brreg.no" target="_blank">Br&oslash;nn&oslash;ysund</a></li>
							<li><a href="http://www.proff.no" target="_blank">Proff.no</a></li>
							<li><a href="http://www.ssb.no" target="_blank">SSB</a></li>
						</ul>
	</li>			

	<li>
	<select id="style" onchange=document.location.href='index.php?style='+this.value>
		
	<option id="smoothness" value="smoothness">Smoothness</option>	
<option id="ui-darkness" value="ui-darkness">Darkness</option>	
	<option id="humanity" value="humanity">Humanity</option>	
	<option id="sunny" value="sunny">Sunny</option>	
		<option id="vader" value="vader">Vader</option>	
	<option id="dark-hive" value="dark-hive">Dark-Hive</option>	
<option id="eggplant" value="eggplant">Eggplant</option>		
<option id="le-frog" value="le-frog">Le Frog</option>		
<option id="mint-choc" value="mint-choc">Mint choc</option>	
<option id="flick" value="flick">Flick</option>	
<option id="overcast" value="overcast">Overcast</option>	
<option id="cupertino" value="cupertino">Cupertino</option>		
<option id="blitzer" value="blitzer">Blitzer</option>	
<option id="south-street" value="south-street">South Street</option>	
<option id="pepper-grinder" value="pepper-grinder">Pepper Grinder</option>		
	</select>	
	<script type="text/javascript" >
document.getElementById('<?php print $_SESSION['style'];?>').selected = true;
	
	
</script>
	</li> 

</ul>


<span id="statusBar" style="float:left; width:400px; padding:2px;text-align:center; color:red"></span>


<span class="ui-widget-content ui-corner-bottom" style="float:right;padding:2px;text-align:right;">
&nbsp;<?php print "Logged in as: ".$_SESSION['fullName']." &nbsp <a href=\"login.php?logout=yes\">Log out</a> &nbsp;"; ?>
<div id="punchArea" style="padding-top:5px;padding-bottom:3px;text-align:center">
<?php
if(strstr($_SESSION['punched'],"in")) {
		print "<span style=\"color:blue\">".$LANG['punched']." ".$_SESSION['punched']."</span>"; 
	}

if(strstr($_SESSION['punched'],"out")) {
		print "<span style=\"color:red\">".$LANG['punched']." ".$_SESSION['punched']."</span>"; 
	}
?>
</div>
</span>

<div class="clear"> </div>
