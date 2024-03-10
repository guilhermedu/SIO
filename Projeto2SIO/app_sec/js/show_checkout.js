$(document).ready(function() {
	$.ajax({
		type: "POST",
		dataType : "json",
		url: "api/show_checkout.php",
		success: function(response) {
			var div = document.getElementById('container');
			for (var i = 0; i < response.length; i++){
				var obj = response[i];
				var produtoDiv = document.createElement("div");
				produtoDiv.id = "produto";
				produtoDiv.innerHTML += "<p><strong>ID do Utilizador: </strong>" + obj.id_user + "</p>"
				produtoDiv.innerHTML += "<p><strong>Utilizador: </strong>" + obj.username + "</p>";
				produtoDiv.innerHTML += "<p><strong>Data de Compra: </strong>" + obj.time + "</p>";
				produtoDiv.innerHTML += "<p><strong>Compras Realizadas: </strong></p><bt>";
				var lista = obj.cart;
				for (var c = 0; c < lista.length; c++){
					produtoDiv.innerHTML += "<br><p><strong>Nome do Produto: </strong>" + lista[c].name + "</p>";
					produtoDiv.innerHTML += "<p><strong>Preço Base: </strong>" + lista[c].price + "</p>";
					produtoDiv.innerHTML += "<p><strong>Quantidade: </strong>" + lista[c].quantity + "</p>";
					produtoDiv.innerHTML += "<p><strong>Subtotal: </strong>" + lista[c].subtotal + "</p><br>";
				}
				produtoDiv.innerHTML += "<br><p><strong>Total: </strong>" + obj.total + "</p>";
				div.appendChild(produtoDiv);
			}
		}
	});
});
