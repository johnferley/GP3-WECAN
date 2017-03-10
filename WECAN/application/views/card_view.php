<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 {text-align: center; font-family: Calibri;}
		#f {font-family: Arial; font-size: 14px; width: 100%; float: left; margin: 0 0 0 0; padding: 0; list-style: none;}
		#f {list-style: none; border:0;}
		#f li {float: top;}
		#f li button { width: 100%; margin: 0 0 3px 0; font-size: 15px; display: block; padding: 8px 15px; font-weight: bold; text-decoration: none; color: #000; background-color: #f2f2f2; border: 1px solid #c1c1c1;}
		#f li button:hover {background-color: #cccccc;}
	</style>
<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>

<h1>Cards</h1>
    <div>
		<?php echo $output; ?>
    </div>
	<div id="buttons">
		<ul id="f">
		<form action="<?php echo site_url('main/update_card')?>" method="post">
		<li><button type="submit">Update Card Validity</button></li>
		<li><input type="text" name="cardIDBox" placeholder="Enter Card ID" /><li>
		</form>
		<form action="<?php echo site_url('main/update_authorisations')?>" method="post">
		<li><button type="submit">Update Authorisations</button></li>
		</form>
		</ul>
	</div>

<script>
if (/add/.test(window.location.href))
{
	document.getElementById('buttons').style.display = 'none'
}
if (/read/.test(window.location.href))
{
	document.getElementById('buttons').style.display = 'none'
}
if (/edit/.test(window.location.href))
{
	document.getElementById('buttons').style.display = 'none'
}
</script>

</body>
</html>
