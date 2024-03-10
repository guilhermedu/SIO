<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/change_password.js"></script>
	<title>Perfil</title>
</head>
<body>
	<?php
		include ("config.php");
		include ("api/functions.php");
		include ("topbar.php");
		check_login();
	?>
	<br>
	<div id="container">
		<h2>Utilizador: <?php echo $_SESSION["username"]; ?></h2>
		<h2>Password: *********</h2>
		<h2>Tipo de utilizador: <?php if($_SESSION["permission_level"] == "1"){ echo "Administrador";}else{echo "Utilizador padrão";}?></h2>
		<form method="post" id="form-change">
			<h2>Alterar palavra-passe</h2>
            <label>Palavra-passe nova</label>
			<input id="text" type="password" name="new_password"><br><br>
			<label>Repita a nova palavra-passe</label>
			<input id="text" type="password" name="new_password1"><br><br>
			<input id="button" type="submit" onsubmit="$('#form-change').submit()" name="login" value="Mudar palavra-passe"><br><br>
		</form>
	</div>
</body>
</html>
