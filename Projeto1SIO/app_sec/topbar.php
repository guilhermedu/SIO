	<div class="topnav"><a href="index.php">Produtos</a>
	<a href="contactos.php?file=contactos.txt">Contactos</a>
	<?php
		if(check_login_boolean()){
			echo "<a href=\"cart.php\">Carrinho</a>";
			echo "<a href=\"profile.php\">Perfil</a>";
			echo "<a href=\"logout.php\">Logout</a>";
		}else{
			echo "<a href=\"login.php\">Login</a>";
			echo "<a href=\"signup.php\">Registar</a>";
		}
	?>
	<div class="topnav-right">
	<input class="search" id="search" type="text" placeholder="Procurar...">
	</div>
	</div>
<br>
<br>
