$(document).ready(function() {
    $('#form-signup').submit(function(e) {
        e.preventDefault();
        var result = {};
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
            },
            error: function(xhr, status, error) {

            }
        });
    });

    // Password strength evaluation
    $('input[name="password"]').on('input', function() {
        var password = $(this).val();

        var strength = calculatePasswordStrength(password);

        $('#password-strength').text('Segurança da palavra-passe: ' + strength);
        
    });
});

function calculatePasswordStrength(password) {
    var entropy = 0;
    var poolSize = 0;

    if (password.match(/[a-z]/)) poolSize += 26; // Lowercase letters
    if (password.match(/[A-Z]/)) poolSize += 26; // Uppercase letters
    if (password.match(/[0-9]/)) poolSize += 10; // Digits
    if (password.match(/[\W]/)) poolSize += 32; // Special characters


    if (poolSize > 0) {
        entropy = Math.log2(poolSize) * password.length;
    }
    var strengthLevel;
    if (entropy < 28) {
        strengthLevel = "Muito Fraca";
    } else if (entropy < 36) {
        strengthLevel = "Fraca";
    } else if (entropy < 60) {
        strengthLevel = "Moderada";
    } else if (entropy < 128) {
        strengthLevel = "Forte";
    } else {
        strengthLevel = "Muito Forte";
    }

    return strengthLevel;
}


