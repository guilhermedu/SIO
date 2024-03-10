$(document).ready(function(){

    $('#form-checkout').submit(function (e){
        e.preventDefault();
        $.post('api/checkout.php',function(response){
            response = JSON.parse(response);
            alert(response.result_text);
            if(response.result==1){
                window.location.href = "index.php";
            } else if (response.result == 0){
                window.location.href = "cart.php";
            }
        })
    })
})