<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <link rel="stylesheet" href="css/default.css">
    <meta charset="ISO-8859-1">
    <script src="js/jquery.js"></script>
    <script src="js/search.js"></script>
    <script src="js/signup.js"></script>
    <script src="js/mostrarpass.js"></script>
    <title>Sistema de Registo</title>
</head>
<body>
	<?php
		include ("api/functions.php");
		include ("topbar.php")
	?>
	<div id='box'>
		<form method="post" id="form-signup" action="api/signup.php">
            <div class="form-group">
                <label for="user_name">Utilizador</label>
                <input type="text" id="user_name" name="user_name" autocomplete="username">
            </div>
			
			<div class="form-group">
                <label for="password">Palavra-passe</label>
                <input type="password" id="password" name="password" autocomplete="new-password">
                <button type="button" onclick="toggleLastCharVisibility('password')">Mostar/Esconder Ultimo Caracter</button>
                <div id="password-strength">Segurança da palavra-passe: </div>
            </div>
			<div class="form-group">
                <label for="password1">Repita a palavra-passe</label>
                <input type="password" id="password1" name="password1" autocomplete="new-password">
                <button type="button" onclick="toggleLastCharVisibility('password1')">Mostar/Esconder Ultimo Caracter</button>
            </div>
			<input type="checkbox" name="terms">&nbsp;Concordo na compartilha e uso das minhas informações descritas nestes <a href="terms.php">termos</a>.<br><br>
			<input id="button" type="submit" name="signup" onsubmit="$('#form-signup').submit()" value="Registar"><br><br>
			<a href="login.php">Clique para efetuar o login</a><br><br>
		</form>
	</div>

