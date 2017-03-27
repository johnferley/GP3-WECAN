<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1, h2 { text-align: center; font-family: Calibri; }
		table.mytable {border-collapse: collapse;}
		table.mytable td, th {border: 1px solid grey; padding: 5px 15px 2px 7px;}
		th {background-color: #f2e4d5;}		
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
<form action= "<?php echo site_url ('main/compVenueCheck')?>" method = 'post'>
    <?php 
        $cardIDs = "";
        $swipeDate = "";
        $swipeVenue = "";
		$fixtureIDs = "";
		$compIDs = "";
        
        
        $cardList = mysql_query('select * from card');          // get the whole card list
        $dateList = "<input type = 'date' name = 'dateList'>";  // get a list of dates named dateList
        $venueList = mysql_query ('select * from venue');       // get a list of all venues
		$fixtureSel = mysql_query('SELECT * FROM fixture');
		$compSel = mysql_query('SELECT * FROM competitor');
        
            while ($row = mysql_fetch_array($cardList))                 // loop through card table
            {
                $cardIDs .= "<option>" . $row['cardID']. "</option>";    // add the row's card ID to cardIDs
            }
            
            //foreach (mysql_fetch_array($venueList) as $row)
            while ($row = mysql_fetch_array($venueList))                    //loop through the venue table
            {
                $swipeVenue .= "<option value=". $row['venueID'].">" . $row['venueName']. "</option>";  // add the row's venue name to swipeVenue
            }
			
			while ($row = mysql_fetch_array($fixtureSel))                    //loop through the venue table
            {
                $fixtureIDs .= "<option>". $row['fixtureID']. "</option>";  // add the row's venue name to swipeVenue
            }
			
			while ($row = mysql_fetch_array($compSel))                    //loop through the venue table
            {
                $compIDs .= "<option value =" . $row['competitorID'] . ">". $row['competitorFirstName']. " ". $row['competitorLastName'] .  "</option>";  // add the row's venue name to swipeVenue
            }
            
            
                echo ('CompetitorID: '.
                "<select name='compSelected'>
                    " . $compIDs . 
                "</select>");       //list of competitor IDs
                
                
                
                
                
            
    ?>
    <button type="submit">GOOOOO!!</button>
</form>;
</div>
</body>
</html>
