<html lang="pt-PT">
<head>
	<link rel="stylesheet" href="css/default.css">
	<meta charset="ISO-8859-1">
	<title>Produtos da Loja do DETI</title>
</head>
<body>
	<?php
		include ("config.php");
		include ("api/functions.php");
		include ("topbar.php");
	?>
	<h1>Produtos do Departamento de Engenharia de Tecnologias e Informação (DETI)</h1>
	<?php
		$file = $_GET['file'];
		$arquivos_disponiveis = array("contactos.txt");
		if(isset($file) && in_array($file, $arquivos_disponiveis)){
			include("$file");
   		}else{
			header('Location: index.php');
		}
	?>
</body>
</html>
