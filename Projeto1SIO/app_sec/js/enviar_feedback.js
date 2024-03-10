$(document).ready(function() {
	$(document).on("click", '.feedback-button', function (e) {
		e.preventDefault();
		var feedback;
		if($('#star1').is(':checked')){
			feedback = $('#star1').val();
		}else if($('#star2').is(':checked')){
			feedback = $('#star2').val();
		}else if($('#star3').is(':checked')){
			feedback = $('#star3').val();
		}else if($('#star4').is(':checked')){
			feedback = $('#star4').val();
		}else if($('#star5').is(':checked')){
			feedback = $('#star5').val();
		}
		var comentario = $('#comentario').val();
		var json = {};
		json["id"] = $('input[name="product_id"]').val();
		json["stars"] = feedback;
		json["comentario"] = comentario;
		$.ajax({
			type: "POST",
			url: "api/add_feedback.php",
 			dataType: "json",
        		data: JSON.stringify(json),
			success: function(res) {
				alert(res.result_text);
				location.reload();
			}
		});
	});
});
