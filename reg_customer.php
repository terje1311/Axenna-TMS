<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 
<title></title>

<script type="text/javascript">

function loadInfo()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("regform").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","data/get_info.php?regnumber="+document.getElementById('regnumber').value,true);
xmlhttp.send();

}

function loadAccounts()
{
xmlhttp2=new XMLHttpRequest();
xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
    document.getElementById("accform").innerHTML=xmlhttp2.responseText;
    }
  }
xmlhttp2.open("GET","data/get_accounts.php?regnumber="+document.getElementById('regnumber').value,true);
xmlhttp2.send();
}

function load() {
	loadInfo();
	loadAccounts();
		}
		
function getCustomer (regNumber) {
	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';
	 
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","data/display_customer_data.php?regnumber="+regNumber,true);
xmlhttp.send();

}	
		
		

</script>


</head>
<body id="dt_example">
<?php
include_once "menu.php";
?>
<div class="mainTable">
<h1><?php print $LANG['new_customer'];?></h1>
<img src="images/logo_32.png" alt="Logo" align="left" valign="baseline"/>&nbsp;

<?php print $LANG['write_org_number'];?>: <input ID="regnumber" type="text" name="regnumber">
<input  type="button" onclick="load()" value="<?php print $LANG['get_data']; ?>">
<br /><br />
<div id="regform">

</div>

<div id="list">

</div>


</div>
</body>
</html>