<?php
require_once ("../../models/Base.php");
require_once ("../../models/Oferta.php");
require_once ("../../models/Funcoes.php");
require_once ("../../models/Cliente.php");
require_once ("../../models/OfertaCliente.php");

$cliente = new Cliente();
$cliente->conectar();

$nomecliente = $cliente->anti_injection($_POST['voucher']);
$id = $cliente->anti_injection($_POST['id']);
$sql = "select * from oferta_cliente where voucher like '%" . utf8_decode($nomecliente) . "%' and id_oferta=".$id." and ativo = 1 order by nome";
$query = mysql_query($sql)or die(mysql_error());

if (mysql_num_rows($query) > 0) {
?>

<table class="table">
     
	     <tr class="column1_titulo">
	          <th>Cliente </th>
	          <th>Voucher</th>
	          <th><?php echo utf8_encode("Ação");?></th>
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
	          		<img src="../sis/img/aberto.gif" alt="Confirmar Venda" title="Confirmar Venda" border="0">
	          	<?php }
	          		if($dados['ativo'] == 2){?>
	          		<font size="2" face="arial"><?php echo $objOferta->date_transform($dados['data'])?></font>
	          	<?php }?>
	          </td>
	     </tr>
      <?php } ?>
     		<tr>
	         	<td colspan="4">Total de Clientes: <?php echo mysql_num_rows($query)?></td>
     		</tr>
		</table>
 <?php


} else {
	echo "N&atilde;o Existem nenhum Registro Cadastrado, para sua Pesquisa !";
}
?>