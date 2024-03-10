$(document).ready(function() {
	$(document).on("click", '.exec', function (e) {
		e.preventDefault();
		var fd = new FormData();
		var files = $('#image')[0].files[0];
		fd.append('image', files);
		if(files == null){
			var id = document.getElementById("product_id").value;
			var name = document.getElementById("name").value;
			var description = document.getElementById("name").value;
			var categories = document.getElementById("categories").value;
			var price =  document.getElementById("price").value;
			var quantity = document.getElementById("quantity").value;
			var json = {};
			json["id"] = id;
			json["name"] = name;
			json["description"] = description;
			json["categories"] = categories;
			json["price"] = price;
			json["quantity"] = quantity;
			json["images"] = "nochange";
			$.ajax({
				type: "POST",
				url: "api/edit_product.php",
 				dataType: "json",
        			data: JSON.stringify(json),
				success: function(res) {
				alert(res.result_text);
				if(res.result == 1){
					window.location.href = "admin.php";
				}
							}
			});
		}else{
			$.ajax({
				url: 'api/upload_image.php',
				type: 'post',
				data: fd,
				dataType: "json",
				contentType: false,
				processData: false,
				success: function(response){
					if(response.result == 0){
						alert(response.result_text);
					}else{
						var id = document.getElementById("product_id").value;
						var name = document.getElementById("name").value;
						var description = document.getElementById("name").value;
						var categories = document.getElementById("categories").value;
						var price =  document.getElementById("price").value;
						var quantity = document.getElementById("quantity").value;
						var json = {};
						json["id"] = id;
						json["name"] = name;
						json["description"] = description;
						json["categories"] = categories;
						json["price"] = price;
						json["quantity"] = quantity;
						json["images"] = response.result_text;
						$.ajax({
							type: "POST",
							url: "api/edit_product.php",
       						        dataType: "json",
        					        data: JSON.stringify(json),
							success: function(res) {
								alert(res.result_text);
								if(res.result == 1){
									window.location.href = "admin.php";
								}
							}
						});
					}
				}
			});
		}
	});
});
