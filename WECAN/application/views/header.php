<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
	#nav { font-family: Arial; font-size: 14px; width: 100%; float: left; margin: 0 0 1em 0; padding: 0; list-style: none;}
	#nav {list-style: none; border:0;}
	#rightnav { list-style: none; }
	#nav li { float: left; }
	#rightnav li { float: right; }
	#nav li a { margin: 0 3px 0 0; font-size: 15px; display: block; padding: 8px 15px; font-weight: bold; text-decoration: none; color: #000; background-color: #f69d0e; border: 1px solid #c1c1c1;}
	#nav li a:hover {background-color: #ba1f1c;}
	#nav a:link, a:visited {border-radius: 12px 12px 12px 12px; }
	</style>
</head>
<body>
	<div>
		<ul id="nav">
		<li><a href='<?php echo site_url('')?>'>Home</a></li>
		<li><a href='<?php echo site_url('main/competitor')?>'>Competitors</a></li>
		<li><a href='<?php echo site_url('main/card')?>'>Cards</a></li>
		<li><a href='<?php echo site_url('main/venue')?>'>Venues</a></li>
		<li><a href='<?php echo site_url('main/fixture')?>'>Fixtures</a></li>
		<li><a href='<?php echo site_url('main/nfa')?>'>NFAs</a></li>
		<li><a href='<?php echo site_url('main/card_access_log')?>'>Card Access Logs</a></li>
		<li><a href='<?php echo site_url('main/issue_log')?>'>Issue Logs</a></li>
		<li><a href='<?php echo site_url('main/team')?>'>Teams</a></li>
			<ul id="rightnav">
			<li><a href='<?php echo site_url('main/blank')?>'>Logout</a></li>
			<li><a href='<?php echo site_url('main/blank')?>'>Account</a></li>
			<!--<li><a href='<?php echo site_url('main/querynav')?>'>Queries</a></li>-->
			</ul>
		</ul>
	</div>
</body>
</html>
