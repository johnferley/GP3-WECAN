<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, caption {
			margin: 0;
			padding: 0;
			border: 0;
			outline: 0;
			vertical-align: baseline;
			background: transparent;
		}
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
		<li><a id='home' href='<?php echo site_url('main/home')?>'>Home</a></li>
		<?php if ($level <> "2") { ?>
		<li><a id='competitor' href='<?php echo site_url('main/competitor')?>'>Competitors</a></li>
		<li><a id='card' href='<?php echo site_url('main/card')?>'>Cards</a></li>
		<?php } ?>
		<?php if ($level <> "3") { ?>
		<li><a id='venue' href='<?php echo site_url('main/venue')?>'>Venues</a></li>
		<li><a id='fixture' href='<?php echo site_url('main/fixture')?>'>Fixtures</a></li>
		<li><a id='nfa' href='<?php echo site_url('main/nfa')?>'>NFAs</a></li>
		<li><a id='card_access_log' href='<?php echo site_url('main/card_access_log')?>'>Card Access Logs</a></li>
		<?php } ?>
		<li><a id='issue_log' href='<?php echo site_url('main/issue_log')?>'>Issue Logs</a></li>
		<li><a id='team' href='<?php echo site_url('main/team')?>'>Teams</a></li>
			<ul id="rightnav">
			<li><a id='logout' onclick="return confirm('Are you sure?');" href='<?php echo site_url('main/logout')?>'>Logout</a></li>
			<li><a id='account' href='<?php echo site_url('main/account')?>'>Account</a></li>
			</ul>
		</ul>
	</div>
	
</body>
</html>

