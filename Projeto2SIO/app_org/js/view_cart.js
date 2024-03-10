$(document).ready(function() {
	$.ajax({
		type: "POST",
		dataType : "json",
		url: "api/view_cart.php",
		success: function(response) {
			var div = document.getElementById('container');
			var products = response.cart_items;
			var total = response.total;
			for (var i = 0; i < products.length; i++){
				var obj = products[i];
				var produtoDiv = document.createElement("div");
				produtoDiv.id = 'produto';
				produtoDiv.innerHTML += "<h2>" + obj.name + "</h2>";
				produtoDiv.innerHTML += "<p><strong>Descrição:</strong> " + obj.description + "</p>";
				produtoDiv.innerHTML += "<p><strong>Preço:</strong>" + obj.price + "€</p>";
				produtoDiv.innerHTML += "<p><strong>Subtotal:</strong> " + obj.subtotal + "€</p>";
				produtoDiv.innerHTML += "<p><strong>Quantidade:</strong> " + obj.quantity + "</p>";
				produtoDiv.innerHTML += '<img width=500px src="' + obj.images + '">';
				div.appendChild(produtoDiv);
			}
			var produtoDiv = document.createElement("div");
			produtoDiv.id = 'produto';
			produtoDiv.innerHTML += "<h2>Total: " + total + "€</h2>";
			div.appendChild(produtoDiv);
		}
	});
});
