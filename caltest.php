<!DOCTYPE html>
<html>
<head>

<title></title>

   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.js"></script>
      <script type="text/javascript" language="javascript" src="lib/datatables/examples/examples_support/jquery.jeditable.js"></script>
		<script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
	
		<script type="text/javascript" src="lib/alloy/aui/aui.js"></script>
		<link rel="stylesheet" href="lib/alloy/aui-button/assets/aui-button-core.css" type="text/css" media="screen" title="no title" charset="utf-8" />
		<link rel="stylesheet" href="lib/alloy/aui-skin-classic/css/icons.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="lib/alloy/aui-skin-classic/css/aui-skin-classic-all-min.css" type="text/css" media="screen" />
		 <link href="css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>




<h1>Alloy - Calendar</h1>




	<button id="calButton" class="aui-buttonitem aui-buttonitem-content aui-state-default">
		<span class="aui-icon aui-icon-calendar"></span>
	</button>


<script type="text/javascript" charset="utf-8">

AUI().ready('aui-calendar-base', function(A) {

	var calendar2 = new A.Calendar({
		trigger: '#calButton',
		// locale: 'pt-br',
		firstDayOfWeek: 0,
		on: {
			select: function(event) {
				alert( event.date.formatted )
			}
		}
	})
	.render();

	// extras

	
});

</script>

</body>
</html>