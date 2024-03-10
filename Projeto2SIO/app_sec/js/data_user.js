$(document).ready(function() {
	$('input[name="apagar"]').click(function() {
		var result = { };
		result["action"] = 1;
		result = JSON.stringify(result);
		$.ajax({
			type: "POST",
			url: "/api/data_user.php",
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
	$('input[name="baixar"]').click(function() {
		var result = { };
		result["action"] = 2;
		result = JSON.stringify(result);
  		$.ajax({
  			type: "POST",
 			url: "/api/data_user.php",
  			data: result,
  			xhrFields: {
    			responseType: 'text'
  			},
  			success: function(response, status, xhr) {
  				var lines = response.split(/\r\n|\n/);
  				var jsonData = JSON.parse(lines[0]);
  				alert(jsonData.result_text);
  				if(jsonData.result == 1){
  			    	var disposition = xhr.getResponseHeader('Content-Disposition');
    				var matches = /"([^"]*)"/.exec(disposition);
    				var filename = (matches != null && matches[1] ? matches[1] : 'dados.txt');
    				var lines = response.split(/\r\n|\n/);
    				var jsonData = JSON.parse(lines[0]);
    				lines.shift();
    				var restText = lines.join('\n');
    				var blob = new Blob([restText], { type: 'text/plain' });
    				var link = document.createElement('a');
    				link.href = window.URL.createObjectURL(blob);
    				link.download = filename;
    				document.body.appendChild(link);
    				link.click();
    				document.body.removeChild(link);
    			}
  			}
		});
	});
});
