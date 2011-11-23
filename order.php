<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <link href="css/styles.css" type="text/css" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register Companies</title>
    </head>
    <body>
<?php
require_once "lang/".$_SESSION['lang'].".php";
require_once "lib/db.php";

if($_GET['action']=="delete") {  // Delete record
$orderID = $_GET['ID'];
// Delete record
    print "Deleting ........";
  $query="DELETE  FROM ".$order." WHERE orderID=".$orderID;

          if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "Record not deleted <br>".mysql_error();
        } else {
           print  "Record deleted";
        }


} //End delete record


if($_POST['action']=="register" || $_POST['action']=="update") {
      // Get record data and clean them up
  $org_number = $_POST['org_number'];
  $company_name = $_POST['company_name'];
  $contact_person = $_POST['contact_person'];
  $contact_email = $_POST['contact_email'];
  $contact_phone = $_POST['contact_phone'];
  $contact_address = $_POST['contact_address'];
  $contact_zipcode = $_POST['contact_zipcode'];
  $contact_city = $_POST['contact_city'];
  $business_branch = $_POST['business_branch'];
  $price = $_POST['price'];
  $currency = $_POST['currency'];
  $comments = $_POST['comments'];

if($_POST['action']=="register") {
// Save form data as new record
    print "Registering ........";
  $query="INSERT INTO ".$order." SET
  org_number = '$org_number',
  company_name = '$company_name',
  contact_person = '$contact_person',
  contact_email = '$contact_email',
  contact_phone = '$contact_phone',
  contact_address = '$contact_address',
  contact_zipcode = '$contact_zipcode',
  contact_city = '$contact_city',
  business_branch = '$business_branch',
  price = '$price',
  currency = '$currency',
  comments = '$comments'";
}

if($_POST['action']=="update") {
// get record ID
$orderID = $_POST['orderID'];
// Update record
    print "Updating ........";
  $query="UPDATE ".$order." SET
  org_number = '$org_number',
  company_name = '$company_name',
  contact_person = '$contact_person',
  contact_email = '$contact_email',
  contact_phone = '$contact_phone',
  contact_address = '$contact_address',
  contact_zipcode = '$contact_zipcode',
  contact_city = '$contact_city',
  business_branch = '$business_branch',
  price = '$price',
  currency = '$currency',
  comments = '$comments'
  WHERE orderID=".$orderID ;
}

        if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "Data not saved <br>".mysql_error();
        } else {
           print  "Data saved";
        }

} // end update or register

if ($_GET['action']=="edit") {
    $action_val = "update";
} else {
    $action_val = "register";
}

if($_GET['action']!="" && $_GET['action']!="delete") {   // Display Form


    if($_GET['action']=="edit") {   // Get record

    $query = "SELECT * from ".$order."WHERE orderID=".$_GET['ID'];
    if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br />".mysql_error();
           }
    if(!$Row=MySQL_fetch_array($Result)) {
        print "Record not found <br />".mysql_error();
    }

    }
    ?>
        <div class="form1">
        <form name="orderform" ID="orderform" method="POST" action="order.php">
            <input type="hidden" name="action" value="<?php print $action_val;?>">
            <input type="hidden" name="orderID" value="<?php print $Row['orderID'];?>">
            <input type="submit">
            <div>
              <span class="field1"><?php print $LANG['org_number'];  ?>: </span>
              <span><input class="field2" type="text" value="<?php print $Row['org_number']; ?>" name="org_number"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['company_name'];  ?>: </span>
              <span><input class="field2" type="text" value="<?php print $Row['company_name']; ?>" name="company_name"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['contact_person'];  ?>: </span>
              <span><input class="field2" type="text" value="<?php print $Row['contact_person']; ?>" name="contact_person"></span>
            </div>
            <div>
              <span class="field1"><?php print $s_contact_email;  ?>: </span>
              <span><input class="field2" type="text" value="<?php print $Row['contact_email']; ?>" name="contact_email"></span>
            </div>
            <div>
            <div>
              <span class="field1"><?php print $s_contact_phone;  ?>: </span>
              <span><input class="field2" type="text" value="<?php print $Row['contact_phone']; ?>" name="contact_phone"></span>
            </div>
              <span class="field1"><?php print $s_contact_address;  ?>: </span>
              <span><input  class="field2" type="text" value="<?php print $Row['contact_address']; ?>" name="contact_address"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['contact_zipcode'];  ?>: </span>
              <span><input  class="field2" type="text" value="<?php print $Row['contact_zipcode']; ?>" name="contact_zipcode"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['contact_city'];  ?>: </span>
              <span><input  class="field2" type="text" value="<?php print $Row['contact_city']; ?>" name="contact_city"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['business_branch'];  ?>: </span>
              <span><input  class="field2" type="text" value="<?php print $Row['business_branch']; ?>" name="business_branch"></span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['price'];  ?>: </span>
              <span><input  class="field2" style="width:130px" value="<?php print $Row['price']; ?>" type="text" name="price">
                  <select name="currency>">
                      <option value="NOK" selected>NOK</option>
                      <option value="SEK">SEK</option>
                      <option value="DK">DK</option>
                      <option value="EORO">EURO</option>
                      <option value="USD">USD</option>
                  </select>
              </span>
            </div>
            <div>
              <span class="field1"><?php print $LANG['comments'];  ?>: </span>
              <span><textarea class="field2" style="height:100px" name="comments"><?php print $Row['comments'];?></textarea></span>
            </div>
            <div>
              <span  class="field1"></span>
              <span>
                  <input class="button1" type="button" onclick="javascript:check();" value="<?php print $LANG['save']; ?>" name="submit">
                  <input class="button1" type="button" value="<?php print $LANG['cancel']; ?>" name="cancel" onclick="JavaScript:document.location='order.php'">
                  <input class="delbutton" type="button" value="<?php print $LANG['delete']; ?>" name="delete" onclick="JavaScript:reallyDelete('<?php print $Row['company_name'];?>','<?php print $Row['orderID'];?>')">
              </span>
            </div>
        </form>
        </div>

      
  <?php
} //end display form

if($_GET['action']!="edit" && $_GET['action']!="new") { // Display records
?>
        <form><input type="button" name="new" onclick="JavaScript:document.location='order.php?action=new'" value="<?php print $LANG['register_new'];?>"></form>

    <?php
        $query = " SELECT * FROM ".$customers." ORDER BY companyName";
        // Connect to databas
        if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
           }
// Print Table Heading
    ?>

<div><?php print $LANG['registered_companies'];?></div>
<div class="table_head1">
    <span style="float: left; width:90px;"><?php print substr($LANG['org_number'],0,3); ?>.</span>
    <span style="float: left; width:180px;"><?php print $LANG['company_name']; ?></span>
    <span style="float: left; width:150px;"><?php print $LANG['contact_person']; ?></span>
    <span style="float: left; width:150px;"><?php print $s_contact_email; ?></span>
    <span style="float: left; width:120px;"><?php print $s_contact_phone; ?></span>
    <span style="float: left; width:150px;"><?php print $s_contact_address; ?></span>
    <span style="float: left; width:60px;"><?php print substr($s_contact_zipcode,0,5); ?>.</span>
    <span style="float: left; width:100px;"><?php print $LANG['contact_city']; ?></span>
    <span style="float: left; width:100px;"><?php print $LANG['business_branch']; ?></span>
    <span style="float: left; width:80px;"><?php print $LANG['price']; ?></span>
    <span style="float: left; width:40px;"><?php print $s_currency; ?></span>
    <span style="float: left; width:100px;"><?php print $LANG['comments']; ?></span>
</div>



    <?php
        while ($Row=MySQL_fetch_array($Result)) {
        // Print record rows
   if($i==1) {
   $table_class = "table_row2";
   $i=2;
   } else {
   $table_class = "table_row1";
   $i = 1;
   }
            ?>

<div class="<?php print $table_class; ?>" style="float: left;">
    <span style="float: left; width:90px;"><?php print $Row['org_number']; ?></span>
    <span style="float: left; width:180px;"><a href="order.php?action=edit&ID=<?php print $Row['orderID'];?>"><?php print $Row['company_name']."&nbsp;"; ?></a></span>
    <span style="float: left; width:150px;"><?php print $Row['contact_person']; ?></span>
    <span style="float: left; width:150px;"><?php print $Row['contact_email']; ?></span>
    <span style="float: left; width:120px;"><?php print $Row['contact_phone']; ?></span>
    <span style="float: left; width:150px;"><?php print $Row['contact_address']; ?></span>
    <span style="float: left; width:60px;"><?php print $Row['contact_zipcode']; ?></span>
    <span style="float: left; width:100px;"><?php print $Row['contact_city']; ?></span>
    <span style="float: left; width:100px;"><?php print $Row['business_branch']; ?></span>
    <span style="float: left; width:80px;"><?php print $Row['price']; ?></span>
    <span style="float: left; width:40px;"><?php print $Row['currency']; ?></span>
    <span style="float: left; width:100px;"><?php print $Row['comments']; ?></span>
</div>
        <?php
        } // end row
        ?>

       
<?php
} // end display records
?>


 <script language="Javascript">

        function check() {
            if (document.orderform.org_number.value=="") {
                alert("<?php print $LANG['write_org_number'];?>");
                document.orderform.org_number.focus();
                return;
            } else {
                document.orderform.submit();
            }
        }

        function reallyDelete(company, deleteID) {
            y = confirm("<?php print $LANG['confirm_delete'];?>: "+company+"?");
                if (y==true) {
                document.location="order.php?action=delete&ID="+deleteID;
                }
        }
</script>

    </body>
</html>
