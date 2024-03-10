<?php
	include("../config.php");
	include("functions.php");
	check_login();
	//check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if( !($json != NULL && key_exists("id", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(empty($json["id"])){
			echo json_encode(array("result" => 0, "result_text" => "Um dos campos está vazio! Produto não editado!"));
			die();
		}else {
			$id = (int)$json["id"];
			$sql = "DELETE FROM products WHERE id='$id'";
			$conn->prepare($sql)->execute();
			echo json_encode(array("result" => 1, "result_text" => "Produto elimido com sucesso!"));
		}
	}
?>
