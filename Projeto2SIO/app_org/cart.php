<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/search.js"></script>
	<script src="js/view_cart.js"></script>
	<script src="js/checkout.js"></script>
	<title>Carrinho</title>
</head>
<body>
	<?php
		include ("config.php");
		include ("api/functions.php");
		include ("topbar.php");
		check_login();
	?>
	<h1>Carrinho de compras</h1>
	<div id="container">
	</div>
	<form method="post" id="form-checkout">
		<input id="button" type="submit" onsubmit="$('#form-checkout').submit()" name="checkout" value="Finalizar Compra">
	</form>
</body>
</html>
