$(document).ready(function() {
	$('#form-signup').submit(function (e) {
		e.preventDefault();
		var result = { };
		$.each($(this).serializeArray(), function() {
			result[this.name] = this.value;
		});
		result = JSON.stringify(result);
		var sendto = $(this).attr("action");
		$.ajax({
			type: "POST",
			url: sendto,
       		        dataType: "json",
        	        data: result,
			success: function(response) {
				alert(response.result_text);
				if(response.result == 1){
					window.location.href = "signup.php";
				}
			}
		});
	});
});
