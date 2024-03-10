<?php
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$request = file_get_contents('php://input');
		$json = json_decode($request, true);
		if(!($json != NULL && key_exists("id", $json))){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0) ){
			echo json_encode(array("result" => 0, "result_text" => "O ID é inválido!"));
			die();
		}else{
			$id = (int)$json["id"];
			$query = "SELECT * FROM products WHERE id='$id'";
			$row = $conn->query($query)->fetchAll();
			$rows = [];
			if(count($row) > 0){
				$query = "SELECT * FROM comments WHERE id='$id'";
				$qq = $conn->query($query);
				foreach($qq -> fetchAll() as $row){
					$rows[] = [
						"id" => $row["id"],
						"stars" => $row["stars"],
						"comment" => $row["comment"],
						"username" => $row["username"],
						];
				}
				echo json_encode(array("result" => 1, "result_text" => json_encode($rows)));
			}else{
				echo json_encode(array("result" => 0, "result_text" => "Produto não encontrado na base de dados!"));
			}
		}
	}
?>
