<?php


/*
 * Created on 20/07/2010
 */

require_once ("../../models/Base.php");
require_once ("../../models/Cliente.php");
require_once ("../../models/Paginacao.php");

$cliente = new Cliente();
$cliente->conectar();

$nomecliente = $cliente->anti_injection($_POST['nome']);
$sql = "select * from cliente where nome like '%" . utf8_decode($nomecliente) . "%' order by nome";
$retorno['paginacao'] = $paginacao = new Paginacao('10', 'pag', $sql);
$sql = $sql . " LIMIT $paginacao->Inicial, $paginacao->Final";
$query = mysql_query($sql);

if (mysql_num_rows($query) > 0) {
?>
 <form action="controllers/Cliente.php" method="post" id="formCliente" >
	  <input type="hidden" name="op" value="Deletar"/>
	  <input type="hidden" name="tela" value="cliente" />
	  <input type="hidden" name="pac" value="cliente" />
  <table class="table">
  	
    <tr class="column1_titulo">
      <th>
  			<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
  	  </th>
  
 		 <th>Nome</th>
 		 <th>SMS</th>
 		 <th>Newsletter</th>
 		 <th>E-mail</th>
 		 <th>Celular</th>
		 <th>A&ccedil;&atilde;o</th>
    </tr>
 	<?php while($dados = mysql_fetch_array($query)){ ?>
    <tr>
    	<td>
  			<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id'];?>"/>  
 	    </td>
        <td><?php echo utf8_encode(ucwords(strtolower($dados['nome'])));?></td>
        <td>
        	<?php if($dados['receber_sms'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "N&atilde;o";
 			}?>
	 	</td>
	  	<td>
	  		<?php if($dados['receber_news'] == 0){
	  			echo "Sim";
	  		}else{
	  			echo "N&atilde;o";
 			}?>
	  	</td>	 
        <td><?php echo $dados['email'];?></td>
		<td><?php echo utf8_encode($dados['celular']);?></td>
		<td>
  			<a href="?pac=cliente&tela=clienteForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit">
  				<img title="Editar" src="img/editar.png" width="31" height="35" border="0">
  			</a> 
  	    </td>
    </tr>
   <?php } ?>
   
</table>
</form>
 <?php


} else {
	echo "N&atilde;o Existem nenhum Registro Cadastrado, para sua Pesquisa !";
}
?>