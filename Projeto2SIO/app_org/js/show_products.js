$(document).ready(function() {
	$.ajax({
		type: "POST",
		dataType : "json",
		url: "api/show_products.php",
		success: function(response) {
			var div = document.getElementById('container');
			for (var i = 0; i < response.length; i++){
				var obj = response[i];
				var produtoDiv = document.createElement("form");
				produtoDiv.method = "post";
				produtoDiv.id = 'produto';
				produtoDiv.className = 'produto-form';
				produtoDiv.action = 'api/add_to_cart.php';
				produtoDiv.innerHTML += "<h2>" + obj.name + "</h2>";
				produtoDiv.innerHTML += "<p><strong>Descrição:</strong> " + obj.description + "</p>";
				produtoDiv.innerHTML += "<p><strong>Preço:</strong> " + obj.price + "€</p>";
				produtoDiv.innerHTML += "<p><strong>Quantidade disponivel:</strong> " + obj.quantity + "</p>";
				produtoDiv.innerHTML += '<input type="hidden" name="product_id" value="' + obj.id + '">';
				produtoDiv.innerHTML += '<img width=500px src="' + obj.images + '">';
				produtoDiv.innerHTML += "<p><strong>Deixe o seu feedback!</strong></p>";
				produtoDiv.innerHTML += '<button class="feedback-button">Adicionar feedback</button><br>';
				produtoDiv.innerHTML += '<br><input type="number" name="quantity" />';
				produtoDiv.innerHTML += '<button class="comprar-button">Comprar</button>';
				div.appendChild(produtoDiv);
			}
		}
	});
});
