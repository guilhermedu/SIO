<?php
	include("functions.php");
	include("../config.php");

	$path = '../uploads/';
	$img = basename($_FILES['image']['name']);
	$tmp = $_FILES['image']['tmp_name'];
	$final_image = rand(1000, 1000000) . "_" . $img;
	$path = $path . strtolower($final_image);
	$image = "uploads/" . strtolower($final_image);
	$allowed = array('gif', 'png', 'jpg', 'jpeg');
	$filename = $_FILES['image']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if (!in_array($ext, $allowed)) {
		echo json_encode(array("result" => 0, "result_text" => "Imagem não foi adicionada com sucesso!"));
	}
	else {
		if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
			echo json_encode(array("result" => 1, "result_text" => $image));
		}else{
			echo json_encode(array("result" => 0, "result_text" => "Imagem não foi adicionada com sucesso!"));
		}
	}
?>
