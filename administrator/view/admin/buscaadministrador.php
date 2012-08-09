<?php

require_once("../../models/Base.php");
require_once("../../models/Administrador.php");

$administrador = new Administrador();
$administrador->conectar();

$nome = $_POST['nome'];
$sql = "select * from administrador where nome like '%".utf8_decode($nome)."%' order by nome";
$query = mysql_query($sql);

if($dados = mysql_num_rows($query) > 0){
	?>

<table class="table">
	<tr class="column1_titulo">
		<th><input type="checkbox" name="selecionatodos" id="selecionatodos" />
		</th>

		<th>Nome</th>
		<th>Email</th>
		<th>A&ccedil;&atilde;o</th>
	</tr>
	<?php while($dados = mysql_fetch_array($query)){ ?>
	<tr>
		<td><?php if($dados['id'] != 1){?> <input type="checkbox" name="id[]"
			class="checkbox" value="<?php echo $dados['id'];?>" /><?php } ?></td>
		<td><?php echo utf8_encode(ucwords(strtolower($dados['nome'])));?></td>
		<td><?php echo utf8_encode(ucwords(strtolower($dados['email'])));?></td>
		<td>
			<a	href="?pac=admin&tela=adminForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"> <img title="Editar" src="img/editar.png" width="31"
				height="35" border="0"> 
			</a>			
		</td>
	</tr>
	<?php } ?>
</table>
	<?php }else{ echo "N&atilde;o Existem nenhum Registro Cadastrado, para sua Pesquisa !";}?>