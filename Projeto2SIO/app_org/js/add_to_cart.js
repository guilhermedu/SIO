$(document).ready(function() {
	$(document).on("click", '.comprar-button', function (e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var product_id = form.find('input[name="product_id"]').val();
		var quantity = form.find("input[name='quantity']").val();
		var json = {};
		json["id"] =product_id;
		json["quantity"]  = quantity;
		json = JSON.stringify(json);
		$.ajax({
			type: "POST",
			url: "api/add_to_cart.php",
       		        dataType: "json",
        	        data: json,
			success: function(response) {
				alert(response.result_text);
			}
		});
	});
});
