<?php
require_once("../../models/Base.php");
require_once("../../models/Paginacao.php");
require_once("../../models/Contareceber.php");
require_once("../../models/Cliente.php");

$contareceber = new Contareceber;
$cliente = new Cliente();

$filtro="";
 if (($_GET["inicial"]!="") and ($_GET["final"]!="")){
 $filtro= $filtro. "and vencimento>='".$contareceber->date_transform($_GET['inicial'])."' and vencimento<='".$contareceber->date_transform($_GET['final'])."'";
 //echo $filtro;
 }
 if ($_GET[id_situacao]!=""){
 $filtro= $filtro. "and id_situacao=".$_GET[id_situacao]." ";
 }
 if ($_GET[id_formapg]!=""){
 $filtro= $filtro. "and id_formapg=".$_GET[id_formapg]." ";
 }
 if ($_GET[id_filial] != ""){
 $filtro = $filtro. "and id_filial=".$_GET[id_filial]." ";
 }

$pesqcontarecebe = $contareceber->listarContareceber($filtro,9999);
$pesqcontarecebe = $pesqcontarecebe['contareceber'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" media="screen" href="../../style/imprimir_receber.css" />
</head>
<body>
<div class="titulo">Contas a Receber</div><br>
  		<table  border="0" cellpadding="0" cellspacing="8" align="center">
        <th>Cliente</th><th>Nº do Documento</th><th>Vencimento</th><th>Forma de Pagamento</th><th>Situação</th><th>Valor Cobrado</th>
        <?php  
 $total=0;
 foreach($pesqcontarecebe as $dados){?>
    <tr>
	      <td><?php  $respcliente = $cliente->getCliente($dados['id_cliente'],'id'); echo $respcliente['nome']?></td>
	      <td><?php echo $dados['numdoc'];?></td>
	      <td><?php echo $contareceber->date_transform($dados['vencimento']);?></td>
	      <td><?php $respformapg = $contareceber->getFormapg($dados['id_formapg'],'id_formapg'); echo $respformapg['descricao'];?></td>
	      <!--<td><?php echo $contareceber->date_transform($dados['data_cad']);?></td>-->
	      <td><?php $respsituacao = $contareceber->getSituacao($dados['id_situacao'],'id_situacao'); echo $respsituacao['descricao']?></td>
	      <td>R$ <?php echo number_format($dados['valorareceber'],2,',','.');?>
          <?php $total=$total+$dados['valorareceber'];?>
          </td>
   </tr>
<?php }?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><b>Total:</b></td>
      <td>R$&nbsp;<?php echo number_format($total,2,',','.');?></td>
    </tr>
  	</table>  	
</body>
</html>