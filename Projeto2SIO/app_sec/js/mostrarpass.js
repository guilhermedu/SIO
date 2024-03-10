
function toggleLastCharVisibility(passwordFieldId) {
    var input = document.getElementById(passwordFieldId);
    var isPassword = input.type === 'password';
    
    if (isPassword && input.value.length > 0) {
        input.type = 'text';
        var originalValue = input.value;
        input.value = '*'.repeat(input.value.length - 1) + originalValue.substr(-1);
        setTimeout(() => {
            input.type = 'password';
            input.value = originalValue;
        }, 1000);
    }
}



