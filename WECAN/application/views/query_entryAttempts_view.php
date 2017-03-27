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
    <button type="submit" onclick="location.href='<?php echo site_url('main/query_entryAttempts')?>'">display entry attempts</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query_entryLog')?>'">Display log of all entries</button>
</div>
<h2>Entry Log</h2>
<div align='center'>
<?php
	$tmpl = array ('table_open' => '<table class="mytable">');
	$this->table->set_template($tmpl); 
	
	$this->db->query('drop table if exists temp');
	$this->db->query('create temporary table temp as (SELECT * from card_access_log)');
	$query = $this->db->query('select * from temp');
	echo $this->table->generate($query);
?>
</div>
</body>
</html>
