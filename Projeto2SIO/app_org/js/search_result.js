const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
if(urlParams.has('name')){
        const product = urlParams.get('name');
        var json = {};
        json["keyword"] = product;
        json = JSON.stringify(json);
        $.ajax({
                type: "POST",
                url: "api/search_products.php",
                dataType: "json",
                data: json,
                success: function(response) {
                        var div = document.getElementById('container');
                        div.innerHTML += "<h2> Produto procurado: " + response.keyword + "</h2>";
                        console.log(product);
                        if(response.result == 1){
                                var res = response.result_text;
                                //var div = document.getElementById('container');
                                for (var i = 0; i < res.length; i++){
                                        var obj = res[i];
                                        var produtoDiv = document.createElement("form");
                                        produtoDiv.method = "post";
                                        produtoDiv.id = 'produto';
                                        produtoDiv.className = 'produto-form';
                                        produtoDiv.action = 'api/add_to_cart.php';
                                        produtoDiv.innerHTML += "<h2>" + obj.name + "</h2>";
                                        produtoDiv.innerHTML += "<p><strong>Descrição:</strong> " + obj.description + "</p>";
                                        produtoDiv.innerHTML += "<p><strong>Preço:</strong> " + obj.price + "€</p>";
                                        produtoDiv.innerHTML += "<p><strong>Quantidade disponivel:</strong> " + obj.quantity + "</p>";
                                        produtoDiv.innerHTML += '<input type="hidden" name="product_id" value="' + obj.id + '">';
                                        produtoDiv.innerHTML += '<img width=500px src="' + obj.images + '">';
                                        produtoDiv.innerHTML += '<br><input type="number" name="quantity" />';
                                        produtoDiv.innerHTML += '<button class="comprar-button">Comprar</button>';
                                        div.appendChild(produtoDiv);
                                }
                        }else{
                                alert(response.result_text);
                        }
                }
        });
}else{
        alert("Nada para procurar!");
        document.location.href = "index.php";
}