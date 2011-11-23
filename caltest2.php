<!DOCTYPE html>
<html>
<head>

<title></title>


      <script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.js"></script>
      <script type="text/javascript" language="javascript" src="lib/datatables/examples/examples_support/jquery.jeditable.js"></script>
		<script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
	
					<script src="lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="lib/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="lib/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="lib/jquery/development-bundle/themes/smoothness/jquery.ui.all.css">
	
	<script src="lib/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-no.js"></script>
		 <link href="css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>




<h1>JQuery - Calendar</h1>



<input type="text" id="datepicker">


<script type="text/javascript">


	$(function() {
		$( "#datepicker" ).datepicker();
		$( "#datepicker" ).datepicker( $.datepicker.regional[ "no" ] );
	});

</script>

</body>
</html>