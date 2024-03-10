const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
if(urlParams.has('id')){
	const product = urlParams.get('id');
	var json = {};
	json["id"] = product;
	json = JSON.stringify(json);
	$.ajax({
		type: "POST",
		url: "api/show_products.php",
       	        dataType: "json",
                data: json,
		success: function(response) {
			if(response.result == 1){
				const obj = JSON.parse(response.result_text);
				document.getElementById("name").value = obj.name;
				document.getElementById("description").value = obj.description;
				document.getElementById("price").value = obj.price;
				document.getElementById("categories").value = obj.categories;
				document.getElementById("quantity").value = obj.quantity;
				var div = document.getElementById('imagee');
				div.innerHTML += '<input type="hidden" name="product_id" id="product_id" value="' + obj.id + '">';
				const image = document.createElement("img");
				image.id = "imageeee";
				image.src = obj.images;
				image.width = 400;
				div.appendChild(image);
			}else{
				alert(response.result_text);
				document.location.href = "admin.php";
			}
		}
	});
}else{
	alert("ID não definido!");
	document.location.href = "admin.php";
}
