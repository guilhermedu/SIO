$(document).ready(function() {
	$(document).on("click", '.feedback-button', function (e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var product_id = form.find('input[name="product_id"]').val();
		window.location.href = "comentario.php?id=" + product_id;
	});

});
