<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 { font-size: 5em; text-align: center; margin: 0 0 0px 0;	font-family: Calibri; }
		p.p-centre { text-align: center; font-family: Calibri; }
		p { font-family: Calibri; margin: 0 0 0px 0; }
		h5 { font-family: Calibri; color: #666666; }
		#cogs { display: block; padding-top: 20px; margin-left: auto; margin-right: auto; }
		body {margin:0; }
		button { border-radius: 12px 12px 12px 12px; margin: 0 3px 0 0; font-size: 15px; display: block; padding: 8px 15px; font-weight: bold; text-decoration: none; color: #000; background-color: #f69d0e; border: 1px solid #c1c1c1;}
		button:hover {background-color: #ba1f1c;}
	</style>
	</style>
</head>
<body>

<h1>Account Management</h1>

<div align="center">
<form action="<?php echo site_url('main/update_login')?>" method="post">
    <table align="center">
        <tr>
            <td><p style="text-align: right">Name:</p></td>
            <td><input name="name" type="text" id="name" size="30" maxlength="50" value="<?php echo $name; ?>"></td>
        </tr>
        <tr>
            <td><p style="text-align: right">Password: </p></td>
            <td><input name="password1" type="password" id="password1" size="30" maxlength="32"></td>
        </tr>
        <tr>
            <td><p style="text-align: right">Confirm Password: </p></td>
            <td><input name="password2" type="password" id="password2" size="30" maxlength="32"></td>
        </tr>
    </table>
    <div align="center">
        <button type="submit" name="update" id="update">Update</button>
    </div>
</form>
</div>
    
</body>
</html>
