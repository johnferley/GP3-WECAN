<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 {text-align: center; font-family: Calibri;}
		body {margin:0; }
	</style>
</head>
<body>

<h1>Queries</h1>
<div align='center'>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query1')?>'">Search by card for authorisation to access venue for match</button>
	<button type="submit" onclick="location.href='<?php echo site_url('main/query2')?>'">All competitors who have access to venue for match</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query3')?>'">All venues accessible by a given competitor</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query4')?>'">Allow card to enter venue because they have match authorisation</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query2')?>'">prevent unorthorised or invalid cards from entering match</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query_entryAttempts')?>'">display entry attempts</button>
    <button type="submit" onclick="location.href='<?php echo site_url('main/query_entryLog')?>'">Display log of all entries</button>
</div>
    
</body>
</html>
