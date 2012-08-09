<?php
require_once ("../administrator/models/Base.php");
require_once ("../administrator/models/Oferta.php");
require_once ("../administrator/models/Funcoes.php");
require_once ("../administrator/models/Cliente.php");
require_once ("../administrator/models/OfertaCliente.php");

$cliente = new Cliente();
$cliente->conectar();
$objOferta = new Oferta();
$nomecliente = $objOferta->anti_injection($_POST['voucher']);
$id = $_POST['id'];
 $sql = "select * from oferta_cliente where voucher like '". utf8_decode($nomecliente) . "%' and id_oferta=".$id." and ativo > 0 order by nome";
$query = mysql_query($sql)or die(mysql_error());

if (mysql_num_rows($query) > 0) {
?>

<table class="table" width="100%">
     
	     <tr class="column1_titulo">
	          <th width="70%">Cliente </th>
	          <th width="20%">Voucher</th>
	          <th width="10%"><?php echo "Ação";?></th>
	     </tr>
     <?php while($dados = mysql_fetch_array($query)){ ?>
	     <tr <?php if($dados['ativo'] == 1){
	     	 echo "class='ok'";
	     }else{
	     	echo "class='usou'";
	     }
	     	?>	     
	     >
	          <td><?php echo utf8_encode(ucwords(mb_strtolower($dados['nome'])));?></td>
	          <td><?php echo $dados['voucher']?></td>
	          <td>	          
	          	<?php if($dados['ativo'] == 1){?>
	          		<a href=javascript:confirmar(<?php echo $dados['id']?>)>
	          			<img src="../administrator/img/aberto.gif" alt="Confirmar Venda" title="Confirmar Venda" border="0">
	          		</a>
	          	<?php }else{?>
	          		<font size="2" face="arial"><?php echo $objOferta->date_transform($dados['data'])?></font>
	          	<?php }?>
	          </td>
	     </tr>
      <?php } ?>
     		<tr>
	         	<td colspan="3">Total de Clientes: <?php echo mysql_num_rows($query)?></td>
     		</tr>
		</table>
 <?php


} else {
	echo "N&atilde;o Existem nenhum Registro Cadastrado, para sua Pesquisa !";
}
?>