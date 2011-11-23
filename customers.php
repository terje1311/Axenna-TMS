<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
     

    <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
			var oTable = $('#example').dataTable( {
				   "bProcessing": true,
					"bServerSide": true,
					"sScrollY": 200,
					"sScrollX": "100%",
					"sScrollXInner": "110%",
					"bScrollCollapse": true,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"sAjaxSource": "data/salesreps.php",
				"fnDrawCallback": function () {
						$('#example tbody td').editable('data/savereps.php', {
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

      <title>Sales Reps</title>
    </head>

<body id="dt_example">
<?php
require_once "menu.php";
?>
		
			<div id="container">
		
			<div class="full_width">
	<h1>Sales Reps</h1>			
			<div id="SalesReps">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
		
			<th width="25px">ID</th>
			<th width="280px">Name</th>
			<th width="80px">Phone 1</th> 
			<th width="80px">Phone 2</th>			
			<th width="200px">Email 1</th>
			<th width="200px">Email 2</th>
			<th width="200px">Address</th>
			<th width="40px">Zip</th>
			<th width="180px">City</th>
			<th width="10px">Superv</th>
			<th width="150px">Start date</th>
			<th width="150px">End date</th>		
			<th width="10px">Hat</th>
			<th width="10px">CC</th>		
			<th width="150px">Skills</th>
			<th width="150px">Comments</th>		
			<th width="50px">Contract</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Phone 1</th> 
			<th>Phone 2</th>			
			<th>Email 1</th>
			<th>Email 2</th>
			<th>Address</th>
			<th>Zip</th>
			<th>City</th>
			<th>Supervisor</th>
			<th>Start date</th>
			<th>End date</th>		
			<th>Hat</th>
			<th>CC</th>		
			<th>Skills</th>
			<th>Comments</th>		
			<th>Contract</th>
		</tr>
	</tfoot>
</table>
			</div>

<div class="spacer"></div>			
</div>
</div>

</body>
</html>
