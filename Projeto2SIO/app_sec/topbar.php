	<div class="topnav">
	<?php
		if(check_login_boolean()){
			if(check_admin_permission_boolean()){
				echo "<a href=\"adicionar.php\">Adicionar Produto</a>";
				echo "<a href=\"checkout_list.php\">Ver Compras Realizadas</a>";
				echo "<a href=\"profile.php\">Perfil</a>";
				echo "<a href=\"logout.php\">Logout</a>";
			}
			else{
				echo "<a href=\"index.php\">Produtos</a>";
				echo "<a href=\"contactos.php?file=contactos.txt\">Contactos</a>";
				echo "<a href=\"cart.php\">Carrinho</a>";
				echo "<a href=\"profile.php\">Perfil</a>";
				echo "<a href=\"logout.php\">Logout</a>";
				echo "<div class=\"topnav-right\">";
				echo "<input class=\"search\" id=\"search\" type=\"text\" placeholder=\"Procurar...\">";
				echo "</div>";
			}
		}else{
			echo "<a href=\"index.php\">Produtos</a>";
			echo "<a href=\"contactos.php?file=contactos.txt\">Contactos</a>";
			echo "<a href=\"login.php\">Login</a>";
			echo "<a href=\"signup.php\">Registar</a>";
			echo "<div class=\"topnav-right\">";
			echo "<input class=\"search\" id=\"search\" type=\"text\" placeholder=\"Procurar...\">";
			echo "</div>";
		}
	?>
	</div>
<br>
<br>
