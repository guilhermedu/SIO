
<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/search.js"></script>
	<script src="js/change_password.js"></script>
	<script src="js/data_user.js"></script>
	<title>Perfil</title>
</head>
<body>
	<?php
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Pragma: no-cache");
		header("Expires: 0");
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
                        <label>Palavra-passe antiga:</label>
			<input id="password" type="password" name="password"><br><br>
                        <label>Palavra-passe nova:</label>
			<input id="new_password" type="password" name="new_password"><br><br>
			<label>Repita a nova palavra-passe:</label>
			<input id="new_password" type="password" name="new_password1"><br><br>
			<div id="password-strength">Strength: </div><br>
			<center><input id="button" type="submit" onsubmit="$('#form-change').submit()" name="login" value="Mudar palavra-passe"></center><br><br>
			
		</form>
		<?php if($_SESSION["permission_level"] == "2"){echo "<center><input id=\"button\" type=\"submit\" name=\"baixar\" value=\"Baixar dados da conta\"><br><br><input id=\"button\" type=\"submit\" name=\"apagar\" value=\"Apagar a conta\"></center>";} ?>
	</div>
</body>
</html>
