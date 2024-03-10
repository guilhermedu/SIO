<html lang="pt-PT">
<head>
	<meta charset="ISO-8859-1">
	<script src="js/jquery.js"></script>
	<script src="js/adicionar_produto.js"></script>
	<link rel="stylesheet" href="css/default.css">
	<title>Adicionar produto</title>
</head>
<body>
<?php
	include("api/functions.php");
	include("config.php");
	check_login();
?>
<form method="post" enctype="multipart/form-data">
	<p>
	<label for="name">Nome do produto:</label>
	<br>
	<input type="text" id="name" size="50" name="name">
	</p>
	<p>
	<label for="description">Descrição:</label>
	<br>
	<textarea id="description" rows="10" cols="60" name="description"></textarea>
	</p>
	<p>
	<label for="price">Preço:</label>
	<br>
	<input type="number" size="50" id="price" min="0.00" step="0.01" name="price" />
	</p>
	<p>
	<label for="image">Imagem:</label>
	<br>
	<input type="file" name="image" id="image">
	</p>
	<div id="imagee"></div>
	<p>
	<label for="categories">Categorias:</label>
	<br>
	<input type="text" size="50" id="categories" name="categories">
	</p>
	<p>
	<label for="quantity">Quantidade:</label>
	<br>
	<input type="number" size="50" min="0" step="0" name="quantity" id="quantity" />
	</p>
	<button class="exec" id="exec">Adicionar produto</button>
</form>

</body>

</html>
