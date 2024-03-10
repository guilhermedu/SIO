<!DOCTYPE html>
<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/login.js"></script>
	<title>Sistema de Login</title>
</head>
<body>
	<?php
		include ("api/functions.php");
		include ("topbar.php");
	?>
	<div id="box">
		<form method="post" id="form-login" action="api/login.php">
			<label>Utilizador</label>
			<input id="text" type="text" name="user_name"><br><br>
			<label>Palavra-passe</label>
			<input id="text" type="password" name="password"><br><br>
			<input id="button" type="submit" onsubmit="$('#from-login').submit()" name="login" value="Autenticar"><br><br>
			<a href="signup.php">Click to Signup</a><br><br>
		</form>
	</div>
</body>
</html>

