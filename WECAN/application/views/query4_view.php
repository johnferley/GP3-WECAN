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

    
  
</div>
<h2>Swipe Simulator</h2>
<div align='center'>







<form action= "<?php echo site_url ('main/fixtureSwipe')?>" method = 'post'>
    <?php 
        $cardIDs = "";
        $swipeDate = "";
        $swipeVenue = "";
        
        
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
    ?>
    <td><button type="submit">SWIIPE!!</button></td>
</form>;
<!-->
    Error when date is empty, 
	Cannot add 0 rows
    
</-->
    
</div>
</body>
</html>
