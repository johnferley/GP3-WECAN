<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 { text-align: center; 	font-family: Calibri; }
		table {border-collapse: collapse;border: 3px solid grey; width: 50%;}
		th {border-collapse: collapse;border: 3px solid grey}
		tr, td {border: 1px solid grey; padding: 5px 15px 2px 7px;}
		body {margin:0; }
		button { border-radius: 12px 12px 12px 12px; margin: 0 3px 0 0; font-size: 15px; display: block; padding: 8px 15px; font-weight: bold; text-decoration: none; color: #000; background-color: #f69d0e; border: 1px solid #c1c1c1;}
		button:hover {background-color: #ba1f1c;}
	</style>
</head>
<body>

<h1><?php echo $header; ?></h1>
<br>
<div align="center">
<?php echo $table; ?>
</div>
<br>
<div>
    <button type="button" onclick="goBack()">Back</button>
</div>
    
</body>
</html>

<script>
function goBack() {
    window.history.back();
}
</script>