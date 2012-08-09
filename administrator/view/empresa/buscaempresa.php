<?php

require_once("../../models/Base.php");
require_once("../../models/Empresa.php");

$empresa = new Empresa();
$empresa->conectar();

$nome = $empresa->anti_injection($_POST['nome']);
$sql = "select * from empresa where nome like '%".utf8_decode($nome)."%' order by nome";
$query = mysql_query($sql);

if($dados = mysql_num_rows($query) > 0){ 
?>
<table class="table">
	<tr class="column1_titulo">
		<th><input type="checkbox" name="selecionatodos" id="selecionatodos" />
		</th>

		<th>Nome</th>
		<th>Endere&ccedil;o</th>
		<th>Telefone</th>
		<th>A&ccedil;&atilde;o</th>
	</tr>
	<?php while($dados = mysql_fetch_array($query)){ ?>
	<tr>
		<td><input type="checkbox" name="id[]" class="checkbox"
			value="<?php echo $dados['id'];?>" /></td>
		<td><?php echo utf8_encode(ucwords(strtolower($dados['nome'])));?></td>
		<td><?php echo utf8_encode(ucwords(strtolower($dados['endereco'])));?></td>
		<td><?php echo utf8_encode($dados['fone']);?></td>
		<td><a
			href="?pac=empresa&tela=empresaForm&op=Editar&i=<?php echo $dados['id'];?>"
			id="edit"><img title="Editar" src="img/editar.png" width="31"
			height="35" border="0"></a></td>
	</tr>
	<?php } ?>
</table>
<?php
 	}else{ echo "N&atilde;o Existem nenhum Registro Cadastrado, para sua Pesquisa !";}?>