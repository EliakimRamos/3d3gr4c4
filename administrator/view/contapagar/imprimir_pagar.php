<?php session_start();
/*
 * Created on 01/09/2010
 *
 */
 require_once("../../models/Base.php");
 require_once("../../models/Paginacao.php");
 require_once("../../models/Contapagar.php");
 
 
 $filtro = " ";

 $contapagar = new Contapagar();
 if (($contapagar->anti_injection($_GET["inicial"])!="") and ($contapagar->anti_injection($_GET["final"])!="")){
	$filtro = $filtro. " and vencimento between '".$contapagar->date_transform($contapagar->anti_injection($_GET['inicial']))."' and '".$contapagar->date_transform($contapagar->anti_injection($_GET['final']));
}

if ($contapagar->anti_injection($_GET['id_formapg'])!=""){
	$filtro= $filtro. " and id_formapg=".$contapagar->anti_injection($_GET['id_formapg'])." ";
}

if($contapagar->anti_injection($_GET["status"])){
	$filtro = $filtro. " and status='".$contapagar->anti_injection($_GET['status'])."'";
}

$resposta = $contapagar->listarContapagarpag($filtro, "99999");
$contapg = $resposta['contapagar'];
$paginacao = $resposta['paginacao'];
$respformapg = $contapagar->listarFormasdePagamento($filtro2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" media="screen" href="../../style/imprimir_receber.css" />
<link rel="stylesheet" type="text/css" media="print" href="../../style/imprimir_receber.css" />
</head>
<body>
<div id="alinha_logo">
	<div id="logo"><img src="../../img/logo_preta.png" /></div>
	<div id="alinha_titulo">
	<div class="titulo">Relatório de contas a pagar</div>
	
     </div>  		
</div>
	<div id="linha"></div>
	<div id="tabela">
  		<table class="table">
	<form action="controllers/contapagar/contapagar.php" method="post"
		id="formContapagar"><input type="hidden" name="op" value="Deletar" />
	<input type="hidden" name="tela" value="contapagar" /> <input
		type="hidden" name="pacote" value="contapagar" />

	<tr class="column1_titulo">
		<th>N&deg; documento</th>
		<th>Descrição</th>
		<th>Beneficiado</th>
		<th>Emissão</th>
		<th>Situação</th>
		<th>Vencimento</th>
		<th>Parcela</th>
		<th>Forma de Pagamento</th>
		<th>Valor Parcela</th>
		<th>Valor total Cobrado</th>
		
	</tr>
		
	</tr>
	<?php
	$total=0;
	if($contapg){
		foreach($contapg as $dados){?>
	<tr>
		<td><?php echo $dados['documento'];?></td>
		<td><?php echo $dados['descricao'];?></td>
		<td><?php  echo $dados['beneficiado'];?></td>
		<td><?php echo $contapagar->date_transform($dados['emissao']);?></td>
		<td><?php echo $dados['status'];?></td>
		<td><?php echo $contapagar->date_transform($dados['vencimento']);?></td>
		<td><?php echo $dados['numParcela']."/".$dados['parcelas'];?></td>
		<td><?php $respformapg = $contapagar->getFormapg($dados['id_formapg'],'id_formapg'); 
		echo $respformapg['descricao'];?></td>

		<?php
		 	$valorParcela = $dados['valorparcela'];
		 	$total += $valorParcela;  
		?>
		<td>
			R$ <?php echo number_format($valorParcela,2,',','.');?> <?php  	$valor = $dados['valorareceber']; ?>
		</td>
		<td>
			R$ <?php echo number_format($dados['valor'],2,',','.');?> 
		</td>
			
	</tr>
	<?php }}?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><b>Total:</b></td>
		<td>R$&nbsp;<?php echo number_format($total,2,',','.');?></td>
		<td>&nbsp;</td>
	</tr>

</table>
    </div>
</body>
	<script type="text/javascript">
		window.print();
	</script>
</html>