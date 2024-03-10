<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("functions.php");
	include("../config.php");

	try {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			throw new Exception("Invalid request method");
		}
	
		$path = '../uploads/';
		$allowedExtensions = array('gif', 'png', 'jpg', 'jpeg');
		
		if (!isset($_FILES['image'])) {
			throw new Exception("Image file not provided");
		}
	
		$maxFileSize = 5 * 1024 * 1024; // 5MB
		if ($_FILES['image']['size'] > $maxFileSize) {
			throw new Exception("Imagem não foi adicionada com sucesso! O arquivo é muito grande.");
		}
	
		$img = basename($_FILES['image']['name']);
		$tmp = $_FILES['image']['tmp_name'];
		$finalImage = rand(1000, 1000000) . "_" . $img;
		$path = $path . strtolower($finalImage);
		$imagePath = "uploads/" . strtolower($finalImage);
	
		$filename = $_FILES['image']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
		if (!in_array($ext, $allowedExtensions)) {
			throw new Exception("Imagem não foi adicionada com sucesso! Formato de arquivo não suportado.");
		}
	
		if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
			echo json_encode(array("result" => 1, "result_text" => $imagePath));
		} else {
			throw new Exception("Imagem não foi adicionada com sucesso! Falha ao mover o arquivo para o diretório de destino.");
		}
	} catch (Exception $e) {
		$errorId = uniqid();
		error_log("Error ID: $errorId - " . $e->getMessage());
		$message = $e->getMessage();
		echo json_encode(array("result" => 0, "result_text" => $message . " Por favor, entre em contato com o suporte e forneça o ID do erro: $errorId"));
	}
?>
