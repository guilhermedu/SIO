$(document).ready(function() {
	$(document).on("click", '.adicionar-button', function (e) {
		window.location.href = "editor.php";
	});
	$(document).on("click", '.eliminar-button', function (e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var product_id = form.find('input[name="product_id"]').val();
		var json = {};
		json["id"] =product_id;
		json = JSON.stringify(json);
		$.ajax({
			type: "POST",
			url: "api/delete_product.php",
       		        dataType: "json",
        	        data: json,
			success: function(response) {
				alert(response.result_text);
				window.location.reload();
			}
		});
	});
	$(document).on("click", '.editar-button', function (e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var product_id = form.find('input[name="product_id"]').val();
		window.location.href = "editor.php?id=" + product_id;
	});

});
