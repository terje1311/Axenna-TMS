<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<div id="uploadForm" style="visibility:hidden;height:0px;">
<form id="uploadForm" action="data/upload_document.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="docType" value="contractDocument">
<input type="hidden" name="userID" value="<?php print $Rowd['userID']; ?>">
<br>
<input type="file" name="file" id="file" />
<br />
<input type="button" name="submit" onclick="document.getElementById('uploadForm').submit" value="<?php print $LANG['upload']; ?>" />
</form>
</div>
</body>
</html>