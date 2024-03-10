<?php
    include("../config.php");
    include("functions.php");
    check_login();
    if($_SERVER['REQUEST_METHOD']=== "POST"){
        $data = file_get_contents('php://input');
	$json = json_decode($data, true);
	if(!($json != NULL && key_exists("new_password", $json) && key_exists("new_password1", $json) && key_exists("password", $json))){
		echo json_encode(array("result" => 0, "result_text" => "JSON inválido"));
		die();
	}
        $uppercase = preg_match('@[A-Z]@',$json["new_password"]);
	$number = preg_match('@[0-9]@',$json["new_password"]);
	$specialChars = preg_match('@[^\W]@',$json["new_password"]);
	$specialChars1 = preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$json["new_password"]);
        // vai receber var password e new_password
        $id = $_SESSION["id"];
        $sql="SELECT * FROM users WHERE id= :id ";
        $statement= $conn->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $hashedPassword = $row["password"];
        $password = hash("sha256",$json["password"]);
        if ($password == $hashedPassword) {
            if($json["new_password"] == $json["new_password1"]){
                if( !(strlen($json["new_password"]) >= 8 && $uppercase && $number && $specialChars && $specialChars1)){
                    echo json_encode(array("result" => 0, "result_text" => "A palavra-passe necessita de ter mais que 8 caracteres, conter pelo menos uma maiúscula, um símbolo e um número"));
                    die();
                }
                $new_password = hash("sha256",$json["new_password"]);
                $sql = "UPDATE users set password= :new_password WHERE id = :id ";
                $updateStmt = $conn->prepare($sql);
                $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $updateStmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                $updateStmt->execute();
                echo json_encode(array("result" => 1, "result_text" => "Palavra-passe alterada com sucesso!"));
            } else {
                echo json_encode(array("result" => 0, "result_text" => "Palavras-passe novas não são iguais"));
            }
        } else {
            echo json_encode(array("result" => 0, "result_text" => "Palavra-passe não coincide com a atual"));

        }
            
    }

?>
