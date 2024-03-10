<html lang="pt-PT">
<head>
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/show_products_admin.js"></script>
	<script src="js/admin.js"></script>
	<link rel="stylesheet" href="css/default.css">
	<title>Painel de Administração da Loja do DETI</title>
</head>
<body>
<?php
	include ("config.php");
	include ("api/functions.php");
	check_login();
	//check_admin_permission();
?>
	<div class="topnav">
		<a href="adicionar.php">Adicionar Produto</a>
		<a href="logout.php">Logout</a>
	</div>
	<h1>Painel de Administração da Loja do DETI</h1>
	<div id="container">
	</div>
</body>

</html>
