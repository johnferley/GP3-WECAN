<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 {text-align: center; font-family: Calibri;}
		table {table-layout: fixed}
		#buttons { background: #e6e6e6}
		input {width: 100%; height: 100%; font-size: 12px}
		button {width: 100%; height: 100% ; background: transparent; font-size: px; border-width: 2px; border-color: transparent; color: blue}
		button:hover {border-width: 2px; border-color: #ffffff #e6e6e6 #e6e6e6 #ffffff; border-style: groove ridge ridge groove}
		body {margin:0; }
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

<h1>Teams</h1>
    <div>
		<?php echo $output; ?>
    </div>

	<div id="buttons">
	<table>
		<tr>
		<form action="<?php echo site_url('main/update_valid_card')?>" method="post">
		<td><div style="width: 300px"><input type="text" name="enterFilter" placeholder="Enter Team IDs (separated by ',') or 'all'" /></div></td>
		<td><div style="width: 150px"><button type="submit" name="submitForm" value="updateValidityOnTeam">Update Card Validity</button></div></td>
		</form>
		</tr>
		<tr>
		<form action="<?php echo site_url('main/update_new_card')?>" method="post">
		<td><div style="width: 300px"><input type="text" name="enterFilter" placeholder="Enter Team IDs (separated by ',') or 'all'" /></div></td>
		<td><div style="width: 150px"><button type="submit" name="submitForm" value="issueNewCardOnTeam">Issue Cards if None</button></div></td>
		</form>
		</tr>
		<tr>
		<form action="<?php echo site_url('main/update_authorisations')?>" method="post">
		<td><div style="width: 300px"><input type="text" name="enterFilter" placeholder="Enter Team IDs (separated by ',') or 'all'" /></div></td>
		<td><div style="width: 150px"><button type="submit" name="submitForm" value="updateAuthOnTeam">Update Authorisations</button></div></td>
		</form>
		</tr>
	</table>
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
