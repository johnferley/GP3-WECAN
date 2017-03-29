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

<h1>Cards</h1>
    <div>
		<?php echo $output; ?>
    </div>

	<div id="buttons">
	<table>
		<tr>
		<form action="<?php echo site_url('main/update_valid_card')?>" method="post">
		<td><div style="float: left; width: 300px"><input type="text" name="enterFilter" placeholder="Enter Card IDs (separated by ',') or 'all'" /></div></td>
		<td><div style="float: left; width: 150px"><button type="submit" name="submitForm" value="updateValidityOnCard">Update Card Validity</button></div></td>
		</form>
		</tr>
		<tr>
		<form action="<?php echo site_url('main/update_authorisations')?>" method="post">
		<td><div style="float: left; width: 300px"><input type="text" name="enterFilter" placeholder="Enter Card IDs (separated by ',') or 'all'" /></div></td>
		<td><div style="float: left; width: 150px"><button type="submit" name="submitForm" value="updateAuthOnCard">Update Authorisations</button></div></td>
		</form>
		</tr>
    <tr>
      			<form action= "<?php echo site_url ('main/fixtureSwipe')?>" method = 'post'>
				<?php 
					$cardIDs = "<option value = '' disabled selected> Select Card ID </option>";
					$swipeDate = "";
					$swipeVenue = "<option value = '' disabled selected> Select Venue </option>";
					
					
					$cardList = mysql_query('select * from card');          // get the whole card list
					$dateList = "<input type = 'date' name = 'dateList'>";  // get a list of dates named dateList
					$venueList = mysql_query ('select * from venue');       // get a list of all venues
					
					while ($row = mysql_fetch_array($cardList))                 // loop through card table
					{
						$cardIDs .= "<option>" . $row['cardID']. "</option>";    // add the row's card ID to cardIDs
					}
					
					//foreach (mysql_fetch_array($venueList) as $row)
					while ($row = mysql_fetch_array($venueList))                    //loop through the venue table
					{
						$swipeVenue .= "<option value=". $row['venueID'].">" . $row['venueName']. "</option>";  // add the row's venue name to swipeVenue
					}
					
					echo ('<td><div style="float: left; width: 150px"> '.
								"<select name='cardSelected'>
									" . $cardIDs . 
								"</select></div></td>");
					
					echo ('<td><div style="float: left; width: 120px"> '. 
							$dateList). '</div></td>';
								
					echo ('<td><div style="float: left; width: 140px"> '.
								"<select name='venueSelected'>
									" . $swipeVenue . 
								"</select></div></td>");
				?>
				<td><button type="submit">Simulate Entry</button></td>
			</form>;
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
