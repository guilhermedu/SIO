$(document).ready(function() {
    
    $('#form-change').submit(function (e){
        e.preventDefault();
        var result = { };
        $.each($(this).serializeArray(), function() {
			result[this.name] = this.value;
		});
		result = JSON.stringify(result);
		$.ajax({
			type: 'POST',
			url: 'api/change_password.php',
       		        dataType: "json",
        	        data: result,
			success: function(response) {
				alert(response.result_text);
				if(response.result == 1){
					window.location.href = "logout.php";
				}
				else if(response.result == 0){
					window.location.href = "profile.php";
				}
			}
		});
	});

});