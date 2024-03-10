$(document).ready(function() {
	$('#search').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			var abc = document.getElementById("search").value;
			document.location.href="search.php?name=" + abc;
		}
	});
});
