<?php
    include("../config.php");
    include("functions.php");
    check_login();

    if($_SERVER['REQUEST_METHOD']=== "POST"){
        $data = file_get_contents('php://input');
		$json = json_decode($data, true);
        $id = $_SESSION["id"];
        if($json["new_password"] == $json["new_password1"]){
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
            
    }

?>
