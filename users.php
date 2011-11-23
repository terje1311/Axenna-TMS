<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
     

      <title>Users</title>
    </head>

<body id="dt_example">
<?php
require_once "menu.php";
?>
	
    <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
			var oTable = $('#example').dataTable( {
				   "bProcessing": true,
					"bServerSide": true,
					"sScrollY": 200,
					"sScrollX": "100%",
				   "bScrollCollapse": true,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"sAjaxSource": "data/get_users.php",
				"fnDrawCallback": function () {
						$('#example tbody td').editable('data/save_users.php', {
					   "submitdata": function ( value, settings ) {
						return {
						"ID": oTable.fnGetData( oTable.fnGetPosition(this)[0] )[0],
						"Field": oTable.fnGetPosition( this )[2]
						} 
						},
					   "callback": function( sValue, y ) {
						/* Redraw the table from the new data on the server */
							oTable.fnDraw();
							},
							"height": "14px"
						} );
					}
				} );
			} );
		  
		</script>
		
	<center>
			<div id="container" style="width:90%;text-align:left">
		
			<h1><?php print $LANG['users'];?></h1>			
			<div id="Users">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
		
			<th>ID</th>
			<th>User Name</th>
			<th >Full Name</th> 
			<th >Pwd</th>			
			<th >Roles</th>
			<th >Reg. Date</th>
			<th >Active</th>
			<th >Sales Rep ID</th>
			<th >Contact ID</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	
</table>
			</div>

<div class="spacer"></div>			
</div>
</center>
</body>
</html>
