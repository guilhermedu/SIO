<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	check_login();
	check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		try{
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if( !($json != NULL && key_exists("id", $json)) ){
				throw new Exception("JSON inválido!");
			}else if(empty($json["id"])){
				throw new Exception("ID vazio! Produto não editado!");
			}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0)){
				throw new Exception("O ID é inválido! Produto não editado!");
			}else{
				$id = (int)$json["id"];
				$sql = "SELECT * FROM products WHERE id='$id'";
				$row = $conn->prepare($sql)->execute();
				$row = $row->fetchAll();
				if(count($row) > 0){
					$sql = "DELETE FROM products WHERE id='$id'";
					$conn->prepare($sql)->execute();
					echo json_encode(array("result" => 1, "result_text" => "Produto elimido com sucesso!"));
				}else{
					throw new Exception("Produto não encontrado na base de dados! Produto não editado!");
				}
			}
	}
	catch (Exception $e) {
		$errorId = uniqid();
		error_log("Error ID: $errorId - " . $e->getMessage());
		$message = $e->getMessage();
		echo json_encode(array("result" => 0, "result_text" => $message . " Por favor, entre em contato com o suporte e forneça o ID do erro: $errorId"));
	}
}
?>
