<?php
include("../config.php");
include("functions.php");

check_login();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
            $data = file_get_contents('php://input');
        $json = json_decode($data, true);
        if(!($json != NULL && key_exists("new_password", $json) && key_exists("new_password1", $json) && key_exists("password", $json))){
            throw new Exception("JSON inválido!");
        }
            $id = $_SESSION["id"];
            $sql = "SELECT * FROM users WHERE id= :id ";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $hashedPassword = $row["password"];
            //$password = hash("sha256",$json["password"]);
        $password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 1<<10, 'time_cost' => 4, 'threads' => 2]);
        if( isPasswordBreached($json["password"]) ){
            throw new Exception("A palavra-passe já foi comprometida, por favor escolha outra!");
            }
            if($json["password"] == $json["new_password"]){
                throw new Exception("A nova palavra-passe não pode ser igual à atual!");
            }else if (password_verify($password, $hashedPassword)) {
                throw new Exception("Palavra-passe não coincide com a atual");
            }else if($json["new_password"] != $json["new_password1"]){
                throw new Exception("As palavras-passe novas não são iguais!");
            }else if(!(validateDoubleSpaces($json["new_password"]))){
                throw new Exception("A palavra-passe não pode ter multiplos espaços!");
            }else if(!(validatePassword($json["new_password"]))){
                throw new Exception("A palavra-passe necessita de ter mais que 12 e menos que 128 caracteres");
            }else{
                $new_password = password_hash($json["new_password"], PASSWORD_ARGON2ID, ['memory_cost' => 1<<10, 'time_cost' => 4, 'threads' => 2]);
                $sql = "UPDATE users set password= :new_password WHERE id = :id ";
                $updateStmt = $conn->prepare($sql);
                $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $updateStmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                $updateStmt->execute();
                echo json_encode(array("result" => 1, "result_text" => "Palavra-passe alterada com sucesso!"));
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
