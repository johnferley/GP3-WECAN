<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1, h2 { text-align: center; font-family: Calibri; }
		table.mytable {border-collapse: collapse;}
		table.mytable td, th {border: 1px solid grey; padding: 5px 15px 2px 7px;}
		th {background-color: #f2e4d5;}	
		body {margin:0; }	
	</style>
</head>
<body>

<h1>Queries</h1>
<div align='center'>
	<button type="submit" onclick="location.href='<?php echo site_url('main/query1')?>'">Search by card for authorisation to access venue for match</button> <!--></-->
	<button type="submit" onclick="location.href='<?php echo site_url('main/query2')?>'">All competitors who have access to venue for match</button> 
    <button type="submit" onclick="location.href='<?php echo site_url('main/query3')?>'">All venues accessible by a given competitor</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query4')?>'">Allow card to enter venue because they have match authorisation</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query1')?>'">prevent unorthorised or invalid cards from entering match</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query1')?>'">display entry attempts</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query7')?>'">Display log of all entries</button>
</div>
<form action= "<?php echo site_url ('main/authCheck')?>" method = 'post'>
    <?php 
        $cardIDs = "";
        $swipeDate = "";
        $swipeVenue = "";
		$fixtureIDs = "";
        
        
        $cardList = mysql_query('select * from card');          // get the whole card list
        $dateList = "<input type = 'date' name = 'dateList'>";  // get a list of dates named dateList
        $venueList = mysql_query ('select * from venue');       // get a list of all venues
		$fixtureSel = mysql_query('SELECT * FROM fixture');
        
            while ($row = mysql_fetch_array($cardList))                 // loop through card table
            {
                $cardIDs .= "<option>" . $row['cardID']. "</option>";    // add the row's card ID to cardIDs
            }
            
            //foreach (mysql_fetch_array($venueList) as $row)
            while ($row = mysql_fetch_array($venueList))                    //loop through the venue table
            {
                $swipeVenue .= "<option value=". $row['venueID'].">" . $row['venueName']. "</option>";  // add the row's venue name to swipeVenue
                "<option value=1>Breda</option>"
            }
			
			while ($row = mysql_fetch_array($fixtureSel))                    //loop through the venue table
            {
                $fixtureIDs .= "<option>". $row['fixtureID']. "</option>";  // add the row's venue name to swipeVenue
            }
            
            
                echo ('CardID: '.
                "<select name='cardSelected'>
                    " . $cardIDs . 
                "</select>");       //list of card IDs
                
                echo('Fixture '.
                    "<select name='fixtureSelected'>
                    " . $fixtureIDs . 
                "</select>");       // selet fixture
                
                
                	<!--><form action= "<?php echo site_url ('main/authCheck')?>" method = 'post'>
				<?php /*
					$cardIDs = "";
					$swipeDate = "";
					$swipeVenue = "";
					$fixtureIDs = "";
					
					
					$cardList = mysql_query('select * from card');          // get the whole card list
					$dateList = "<input type = 'date' name = 'dateList'>";  // get a list of dates named dateList
					$venueList = mysql_query ('select * from venue');       // get a list of all venues
					$fixtureSel = mysql_query('SELECT * FROM fixture');		// get all fixtures
					
						while ($row = mysql_fetch_array($cardList))                 // loop through row in card table
						{
							$cardIDs .= "<option value =". $row['cardID']. "> Card ID:" . $row['cardID']. "</option>";    // add the row's card ID to cardIDs
						}
						
						while ($row = mysql_fetch_array($venueList))                    //loop through the venue table
						{
							$swipeVenue .= "<option value=". $row['venueID'].">" . $row['venueName']. "</option>";  // add the row's venue name to swipeVenue
						}
						
						while ($row = mysql_fetch_array($fixtureSel))                    //loop through the venue table
						{
							$fixtureIDs .= "<option value =". $row['fixtureID']. ">". $row['fixtureDate']. ", Venue " . $row['Venue_venueID'] . "</option>";  // add the row's venue name to swipeVenue
						}
						
						
							echo ('<td><div style="float: left; width: 50px"> '.
							"<select name='cardSelected'>
								" . $cardIDs . 
							"</select></div></td>");       //list of card IDs
							
							echo ('<td><div style="float: left; width: 150px"> '.
							"<select name='fixtureSelected'>
								" . $fixtureIDs . 
							"</select></div></td>");*/	// select fixture
				?>
				
				<td><div style="float: left; width: 150px"><button type="submit">Select</button></div></td>
			</form></-->
            
    ?>
    <button type="submit">GOOOOO!!</button>
</form>;
</div>
</body>
</html>
