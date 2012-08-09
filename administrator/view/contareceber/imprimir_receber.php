<?php session_start();
/*
 * Created on 19/07/2010
 *
 */
 require_once("../../models/Base.php");
 require_once("../../models/Paginacao.php");
 require_once("../../models/Contareceber.php");
 require_once('../../models/Cliente.php');


 $contareceber = new Contareceber();
 $cliente = new Cliente();
 
 	
 
 $filtro="";
 if (($_GET["inicial"]!="") and ($_GET["final"]!="")){
 $filtro = $filtro . " and c.vencimento between '" . $contareceber->date_transform($_GET['inicial']) . "' and '" . $contareceber->date_transform($_GET['final']) . "'";
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

 $respcontarecebe = $contareceber->listarContareceber($filtro,9999);
 $respsituacao = $contareceber->getSituacao($_GET['id_situacao'],"id_situacao");
 $respformapg = $contareceber->getFormapg($_GET['id_formapg'],"id_formapg");
 $respcontarecebe = $respcontarecebe['contareceber'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" media="screen" href="../../style/css_page.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../../style/imprimir_receber.css" />
<link rel="stylesheet" type="text/css" media="print" href="../../style/imprimir_receber.css" />
</head>
<body>
<div id="alinha_logo">
	<div id="logo"><img src="../../img/logo_preta.png" /></div>
	<div id="alinha_titulo">
	<div class="titulo">Relatório de contas a receber</div>
	<div id="relatorio"><?php 
		if($_GET['inicial'] and $_GET['final']){echo "Período"." ".$_GET['inicial']." a"." ".$_GET['final']."<br>";}
			 if($_GET[id_situacao]){ echo "Situação ".strtolower($respsituacao['descricao'])."<br>";}
			 if($_GET[id_formapg]){ echo "Forma de Pagamento ".$respformapg['descricao']."<br>";}
			
		?>
	 </div>	
     </div>  		
</div>
	<div id="linha"></div>
	<div id="tabela">
  	<table class="table">
  		<tr class="column1_titulo">
     		
  		<th>N&deg; documento</th>	
 		 <th>Cliente</th>
 		 <th>Vencimento</th>
 		 <th>Parcela</th>
 		 <th>Forma de Pagamento</th> 		 
 		 <th>Situa&ccedil;&atilde;o</th>
 		 <th>Valor Parcela</th>
 		 <th>Valor total Cobrado</th>
 		 
    </tr>
 <?php


$total = 0;
foreach ($respcontarecebe as $dados) {
	
?>
    <tr>
     
	      <td><?php echo $dados['numdoc'];?></td>
	      <td><?php  $respcliente = $cliente->getCliente($dados['id_cliente'],'id_cliente'); echo $respcliente['nome']?></td>
	      <?php

	if (empty ($dados['vencimentoC']) || $dados['vencimentoC'] == "0000-00-00" || !empty ($dados['vencimentP'])) {
		$data_vencimento = $contareceber->date_transform($dados['vencimentP']);
	} else
		if ( !empty ($dados['vencimentoC'])) {
			$data_vencimento = $contareceber->date_transform($dados['vencimentoC']);
		} else {
			$data_vencimento = "Error na data";
		}
?>
		<td><?php echo $data_vencimento;?></td>
		<td><?php echo $dados['numParcela']."/".$dados['qtd_parcela'];?></td>
	      <td><?php $respformapg = $contareceber->getFormapg($dados['id_formapg'],'id_formapg'); echo $respformapg['descricao'];?></td>
	      <?php if(empty($dados['statusC'])){
				$status = "0000-00-00";
			  }else {
			  	$status = $dados['statusC'];
			  }?>
	      <td><?php $respsituacao = $contareceber->getSituacao($status,'id_situacao'); echo $respsituacao['descricao']?></td>
	      <?php  	$valorParcela = $dados['valorparcela']; ?>
	      <td>R$ <?php echo number_format($valorParcela,2,',','.');?>
	      <?php  	$valor = $dados['valorareceber']; ?>
	      <td>R$ <?php echo number_format($valor,2,',','.');?>
          <?php $total=$total+$valorParcela;?>
          </td><td>
  			
  			<a href="?pac=contareceber&tela=contareceberForm&op=Editar&i=<?php echo $dados['id_contareceber'];?>" id="edit"><img title="Editar" src="img/editar.png" width="31" height="35" border="0"></a> 
  	</td>
   </tr>
<?php }?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td height="35"><b>Total:</b></td>
      <td>R$ <?php echo number_format($total,2,',','.');?></td>
      <td>&nbsp;</td>
    </tr>
</form>
  </table>
    </div>
</body>
	<script type="text/javascript">
		 window.print();
	</script>
</html>