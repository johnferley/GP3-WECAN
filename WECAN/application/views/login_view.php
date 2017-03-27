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
	</style>
</head>
<body>

<h1>WECAN</h1>



<div align="center">
	<img id="cogs" src="http:\\localhost:8080\WECAN\assets\images\logo.png" alt="WECAN Logo" height="260" width="380">
</div>

<div align="center">
<form action="<?php echo site_url('login/handle_login')?>" method="post">
<td width="168" height="125">&nbsp;</td>
                      <td width="303">&nbsp;</td>
                      <td width="203">&nbsp;</td>
                  
                    <p> Please enter your Username and Password: </p>
                    <tr>
                      <td height="162">&nbsp;</td>
                      <td valign="top">
                      <table width="303" height="133" border="0">
                        <tr>
                          <td width="105" height="40"> <p>Username:</p></td>
                          <td width="182">
                            <label for="Username"></label>
                            <input name="username" type="text" id="username" size="30" maxlength="50">
                          </td>
                        </tr>
                        <tr>
                          <td height="44"><p>Password: </p></td>
                          <td>
                            <label for="Password"></label>
                            <input name="password" type="text" id="password" size="30" maxlength="32">
                          </td>
                        </tr>
                        <tr>
                          <td height="39">&nbsp;</td>
                          <td>
                            <h5>
                              <input type="submit" name="Login" id="Login" value="    Login    ">
                              Forgot password?
                            </h5>
                          </td>
                        </tr>
                      </table>                        <p>&nbsp;</p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
</form>
</div>

</body>
</html>
