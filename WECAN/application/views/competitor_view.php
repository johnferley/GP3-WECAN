<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 {text-align: center; font-family: Calibri;}
		table {table-layout: fixed}
		#buttons { background: #e6e6e6}
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

<h1>Competitors</h1>
    <div>
		<?php echo $output; ?>
    </div>

	<div id="buttons">
	<table>
		<tr>
		<form action="<?php echo site_url('main/update_valid_card')?>" method="post">
		<td><div><input style="width: 300px"type="text" name="enterFilter" placeholder="Enter Competitor IDs (separated by ',') or 'all'" /></div></td>
		<td><div><button style="width: 150px" type="submit" name="submitForm" value="updateValidityOnCompetitor">Update Card Validity</button></div></td>
		</form>
		<form action="<?php echo site_url('main/delete_duplicates')?>" method="post">
		<td style="width: 100%"><div><button style="float:right; width: 150px" type="submit" name="submitForm" value="deleteDuplicatesOnCompetitor">Delete Duplicates</button></div></td>
		</form>
		</tr>
		<tr>
		<form action="<?php echo site_url('main/update_new_card')?>" method="post">
		<td><div><input style="width: 300px" type="text" name="enterFilter" placeholder="Enter Competitor IDs (separated by ',') or 'all'" /></div></td>
		<td><div><button style="width: 150px" type="submit" name="submitForm" value="issueNewCardOnCompetitor">Issue Cards if None</button></div></td>
		</form>
		</tr>
		<tr>
		<form action="<?php echo site_url('main/update_authorisations')?>" method="post">
		<td><div><input style="width: 300px" type="text" name="enterFilter" placeholder="Enter Competitor IDs (separated by ',') or 'all'" /></div></td>
		<td><div><button style="width: 150px" type="submit" name="submitForm" value="updateAuthOnCompetitor">Update Authorisations</button></div></td>
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
