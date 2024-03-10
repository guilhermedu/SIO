Projeto desenvolvido no âmbito da UC, Segurança Informática e nas Organizações.<br>

Foi criada uma aplicação web para uma loja do DETI, existem dois códigos fonte, no /app encontra-se aquele que foi desenvolvido com as vulnerabilidades expostas e no /app_sec aquele que as corrige.<br>
No /analysis está o pdf com toda a documentação realizada de suporte à exploração das vulnerabilidades e à correção das mesmas.<br>

Vulnerabilidades Implementadas:<br>
CWE-79 - XSS<br>
CWE-89 - SQL Injection<br>
CWE-22 - Path Traversal<br>
CWE-352 - CSRF<br>
CWE-434 - Unrestricted Upload of File with Dangerous Type<br>
CWE-521 - Weak Password Requirements<br>
CWE-530 - Exposure of Backup File to an Unauthorized Control Sphere<br>
​ 

Autores:<br>
André Miragaia 108412<br>
João Rodrigues 108214<br>
Guilherme Duarte 107766<br>
André Cruz 110554<br>
Guilherme Andrade 107696 <br>

Para utilizar as apps desenvolvidas é necessario importar o arquivo app.sql para o mysql e é necessario a configuraçao dum utilizador com as seguintes caracteristicas:<br>
$username = "root";<br>
$password = "SDAs2123@_122";<br>
Além disso é necessário o uso de uma ferramenta para dar display da informação web (no nosso caso usamos o apache).<br>
Por ultimo tambem temos um utilizador já criado com as permissões de administrador.<br>
user= admin<br>
pass= admin<br>
