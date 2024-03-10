<!DOCTYPE html>
<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/search.js"></script>
	<script src="js/signup.js"></script>
	<title>Sistema de Registo</title>
</head>
<body>
	<?php
		include ("api/functions.php");
		include ("topbar.php")
	?>
	<div id='box'>
		<form method="post" id="form-signup" action="api/signup.php">
			<label>Utilizador</label>
			<input id="text" type="text" name="user_name"><br><br>
			<label>Palavra-passe</label>
			<input id="text" type="password" name="password"><br><br>
			<label>Repita a palavra-passe</label>
			<input id="text" type="password" name="password1"><br><br>
			<input id="button" type="submit" name="signup" onsubmit="$('#form-signup').submit()" value="Registar"><br><br>
			<a href="login.php">Click to login</a><br><br>
		</form>
	</div>
</body>
</html>
