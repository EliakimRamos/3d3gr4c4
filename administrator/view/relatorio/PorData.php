<?php	
require_once("models/Base.php");
require_once("models/Funcoes.php");
require_once("models/Oferta.php"); 

$funcao = new Funcoes();
$ObjOferta = new Oferta();


$filtro="";

if (($ObjOferta->anti_injection($_GET["data_inicio"])!="")&& ($ObjOferta->anti_injection($_GET["data_final"])!="")){
	$filtro= $filtro. "and data between '".$funcao->formata_data($ObjOferta->anti_injection($_GET['data_inicio']))."' and '".$funcao->formata_data($ObjOferta->anti_injection($_GET['data_final']))."'";
}

if ($ObjOferta->anti_injection($_GET['id_oferta'])!=""){
	$filtro= $filtro. "and ProdID LIKE  '".$ObjOferta->anti_injection($_GET['id_oferta'])." %' ";
}

$filtro= $filtro." and StatusTransacao in ('Completo','Aprovado')";
$pagSeguro = $ObjOferta->listarOfertaPagSeguro($filtro);
$todasOfertas = $ObjOferta->listarOferta2("");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relátorio de Vendas por Datas</title>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
<script language="javascript" src="js/jquery.ui.core.js"></script>
<script language="javascript" src="js/jquery/jquery.ui.core.js"></script>
<script language="javascript" src="js/Utils.js"></script>
<script language="javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script>
 $(function(){ 
		$(".datepicker").datepicker({
			 showButtonPanel: true
			  }); 
		});	
</script>
</head>
<body>
<form action="?pac=relatorio&tela=PorData" name="filtros" method="get">
	<table align="center">
		<tr>
			<td>
				<input type="hidden" name="pac" value="relatorio"/>
				<input type="hidden" name="tela" value="PorData"/>
				<span class="label">Data Início:</span>
			</td>
			<td>
				<input type="text" name="data_inicio" readonly="readonly" class="datepicker" value="" style="width: 80px;" />
			</td>
			<td>
				<span class="label">Data Final:</span>
			</td>
			<td>
				<input type="text" name="data_final" readonly="readonly" class="datepicker" value="" style="width: 80px;" /></td>
			<td>
				<span>Oferta:</span></td>
			<td>
				<select name="id_oferta" id="id_oferta" style="width: 300px;">
					<option value="">Selecione</option>
					<?php foreach($todasOfertas as $dados){?>
					<option value="<?php echo $dados['id']?>"><?php echo substr($dados['titulo'], 0, 55) ?></option>
					<?php  } ?>
				</select>
			</td>
			<td>
				<input name="submit" type="submit" value="Pesquisar"/>
			</td>
		</tr>
	</table>
</form>

	<?php if($pagSeguro){?>	  
	 	<table align="center">
	 		<tr>
	 			<th>Promoção</th>
	 			<th>Valor</th>
	 			<th>Quantidade</th>
	 			<th>Valor Compra</th>
	 			<th>Data</th>
	 		</tr>
	 		<?php foreach ($pagSeguro as $dados){?>
	 			<tr>
		 			<td align="left"> 
		 				<?php echo substr($dados['ProdDescricao'], 0, 40) ?> 
		 			</td>
		 			<td> 
		 				<?php $preco = str_replace(",", ".", $dados['ProdValor']);
		 					  echo "R$ ". number_format($preco,2,',','.')?></td>
		 			<td> 
		 				<?php echo $dados['ProdQuantidade']?>
		 			</td>
		 			<td> 
		 				<?php $valor_compra = $preco * $dados['ProdQuantidade'];
		 				      echo "R$ ". number_format($valor_compra,2,',','.')?>
		 			</td>
		 			<td>	
		 				<?php echo $funcao->formata_data_BR($dados['data']);?>
		 			</td>
	 			</tr>
			<?php 
	 			$valor_geral += $valor_compra;
	 		}?> 
	 		<tr>
	 			<td colspan="5" align="right"> Valor Geral R$ <strong><?php echo number_format($valor_geral,2,',','.') ?></strong></td>
	 		</tr>		
	 	</table>
	<?php }?>
</body>
</html>   			 