<?php
include("../config.php");
include("functions.php");
	//user_id, user_name, product_id, review_rate, message
	// {product_id: "id", review_rate:"", message: ""}
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if(check_login_boolean()){
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if(!($json != NULL && key_exists("product_id", $json) && key_exists("review_rate", $json) && key_exists("message", $json))){
				echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			}else {
				$id = (int)$json["id"];
				
			}
		}else{
			echo json_encode(array("result" => 0, "result_text" => "Para fazer reviews é necessário fazer login!"));
		}
	}
?>
