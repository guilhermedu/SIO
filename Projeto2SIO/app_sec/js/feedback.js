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
			var div = document.getElementById('container');
			div.innerHTML +=  '<input type="hidden" name="product_id" value="' + product + '">';
			if(response.result != 1){
				alert(response.result_text);
				document.location.href = "index.php";
			}
		}
	});
	$.ajax({
		type: "POST",
		dataType : "json",
		data: json,
		url: "api/show_feedback.php",
		success: function(response) {
			if(response.result == 1){
				var div = document.getElementById('container');
				response = JSON.parse(response.result_text);
				for (var i = 0; i < response.length; i++){
					var obj = response[i];
					var produtoDiv = document.createElement("div");
					var stars = parseInt(obj.stars);
					produtoDiv.innerHTML += "<br><h2>Utilizador: " + obj.username + "</h2>";
					for (var x = 0; x < stars; x++){
						if (stars > x){
							produtoDiv.innerHTML += '<label class="star_checked" title="text">★</label>';
						}else{
							produtoDiv.innerHTML += '<label class="star_notchecked" title="text">★</label>';
						}
					}
					//produtoDiv.innerHTML += "<br><br><h2>Utilizador: " + obj.username + "</h2>";
					produtoDiv.innerHTML += "<br><br><p>Comentario:</strong> " + obj.comment + "</p>";
					div.appendChild(produtoDiv);
					//window.location.reload();
				}
			}else{
				alert(response.result_text);
			}
		}
	});
}else{
	alert("ID não definido!");
	document.location.href = "index.php";
}
