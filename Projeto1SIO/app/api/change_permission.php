<?php
	include('functions.php');
	include('../config.php');
	check_login();
	//check_admin_permission();
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if( !($json != NULL &&  key_exists("id", $json) &&  key_exists("new_permission", $json)) ) {
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(!(is_numeric($new_permission) && ($new_permission == "1" ||$new_permission == "2" )) ){
			echo json_encode(array("result" => 0, "result_text" => "As únicas permissões válidas são a \"1\" e a \"2\"!"));
			die();
		}else if(!(is_numeric($id) && (int)$id > 0)){
			echo json_encode(array("result" => 0, "result_text" => "ID tem de ser inteiro e maior que zero!"));
			die();
		}else{
			$id = (int)$json["id"];
			$new_permission = $json["new_permission"];
			$sql = "SELECT * FROM users WHERE id='$id'";
			$result = $conn -> query($sql) -> fetchAll();
			if(count($result) == 1){
				$sql = "UPDATE users SET permission_level = '$new_permission' WHERE id = '$id'";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetchAll();
				echo json_encode(array("result" => 1, "result_text" => "Permissões alteradas com sucesso!"));
			}else{
				echo json_encode(array("result" => 0, "result_text" => "Utilizador não encontrado!"));
			}
		}
	}
?>
