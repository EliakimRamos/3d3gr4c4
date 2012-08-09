<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Oferta.php");
require_once("models/Funcoes.php");
require_once("models/Empresa.php"); 

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	header("location:../../entrar.php");	
}

$funcao = new Funcoes();
$oferta = new Oferta();
$empresa = new Empresa();

$pagseguroBoleto = 2.6;
$pagseguroCartao = 6.1;
$tarifaPagseguro = 0.40;

$filtro = " and ativa <> 2";
$filtro_pagseguro = "";
$qtd = 10;

if (($_GET["data_inicio"]!="")&& ($_GET["data_final"]!="")){
	$filtro_pagseguro= $filtro_pagseguro. "and data between '".$funcao->formata_data($_GET['data_inicio'])."' and '".$funcao->formata_data($_GET['data_final'])."'";
}else{
	$data_hoje = date ("Y-m-d");
	$filtro_pagseguro= $filtro_pagseguro. "and data between '".$data_hoje."' and '".$data_hoje."'";
}

if ($_GET['id_oferta']!=""){
	$filtro_pagseguro= $filtro_pagseguro. "and ProdID LIKE  '".$_GET['id_oferta']." %' ";
	$filtro = $filtro. " and id =".$_GET['id_oferta'];
}


$filtro_pagseguro= $filtro_pagseguro." and StatusTransacao in ('Completo','Aprovado')";

$resposta = $oferta->listarOfertaFinanceiroTodas($filtro);
$todasOfertas = $resposta['oferta'];
$paginacao = $resposta['paginacao'];
$oferta->conectar();

$temp = $oferta->listarOfertaFinanceiroTodas($filtro);
$TempOfertasGeral = $temp['oferta'];

if($TempOfertasGeral){
		foreach($TempOfertasGeral as $dados){
			$qtdBoleto = 0;
			$qtdCartao = 0;
			$aprovadoBoleto = 0;			
			$aprovadoCartao = 0;
			
				$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");				
				$pagSeguro = $oferta->listarOfertaPagSeguro($filtro_pagseguro);
				foreach ($pagSeguro as $todosPagamentos){	
					$aux = explode(" ", $todosPagamentos['ProdID']);
					$id_oferta = $aux[0];
										
					if( $id_oferta == $dados['id']){							
						switch ($todosPagamentos['TipoPagamento']){
							case 'Boleto':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];			
								break;
							
							case 'Cartão de Crédito':
								++$aprovadoCartao;
								$qtdCartao += $todosPagamentos['ProdQuantidade'];
								break;
								
							case 'Pagamento Online':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];
								break;
								
							case 'Pagamento':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];
								break;
						}
					}
				}
				
				$qtdVendidos = $qtdBoleto + $qtdCartao;
				//$qtdVendidos = $oferta->qtdVendida($dados['id']);
				$qtdTransacoes = $aprovadoBoleto + $aprovadoCartao;
				
				
				
				$valorPromocao = str_replace(",", ".", $dados['valorpromocao']);
				
				$valorRecebido = $qtdVendidos * $valorPromocao;
				
				$TaxaCartao = ($valorPromocao * $pagseguroCartao) / 100;
				$TaxaBoleto = ($valorPromocao * $pagseguroBoleto) / 100;
				
				$transacoesCartao = $tarifaPagseguro * $aprovadoCartao;
				$transacoesBoleto = $tarifaPagseguro * $aprovadoBoleto;
				
				
								
				$valorCartao = ($TaxaCartao * $qtdCartao) + $transacoesCartao;
				$valorBoleto = ($TaxaBoleto * $qtdBoleto) + $transacoesBoleto;
				
				
				$valorBruto = ($valorRecebido * $dados['lucro']) / 100 ;
				
				$valorLiquido = ($valorBruto - ($valorCartao + $valorBoleto));
				

				$aux = explode("-",$dados['data_final']);
				
				$ano = $aux[0];
				$mes = $aux[1];
				$dia = $aux[2];
				
				$novaData = date("d/m/Y", mktime(0, 0, 0, $mes, $dia + 30, $ano));
				$valorRepasse = $valorRecebido - $valorBruto;
				
				$TotalGeral += $valorRecebido;
				$TotalRepasse += $valorRepasse;
				$TotalCartao += $valorCartao;
				$TotalBoleto += $valorBoleto;
				$TotalBruto += $valorBruto;
				$TotalLiquido += $valorLiquido;
			}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relátorio Financeiro</title>
<script language="javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
<script language="javascript" src="js/jquery.ui.core.js"></script>
<script language="javascript" src="js/jquery.ui.core.js"></script>
<script language="javascript" src="js/Utils.js"></script>
<script language="javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>

<!-- CSS e JQuery das tabelas -->
<style type="text/css" title="currentStyle"> 
	@import "../js/tabela/page.css";
	@import "../js/tabela/table_jui.css";
	@import "../js/tabela/jquery-ui-1.8.4.custom.css";
</style> 
<script type="text/javascript" language="javascript" src="../js/tabela/jquery.js"></script> 
<script type="text/javascript" language="javascript" src="../js/tabela/jquery.dataTables.min.js"></script> 	

<script>
	$(document).ready(function() {
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
		
	 	
		$(".datepicker").datepicker({
			 showButtonPanel: true
			  }); 
		});	
</script>
<style>
.vermelho {
	color: red;
}

.azul {
	color: blue;
}

.verde{
	color: green;
}

</style>
</head>
<body>
<div class="titulo"> Relatório Financeiro</div>

<div class="corpo">
<form action="?pac=relatorio&tela=relatorioFinanceiro" name="filtros" method="get">
	<table align="center">
		<tr>
			<td>
				<input type="hidden" name="pac" value="relatorio"/>
				<input type="hidden" name="tela" value="relatorioFinanceiro"/>
				<span class="label">Data Início:</span>
			</td>
			<td>
				<input type="text" name="data_inicio" readonly="readonly" class="datepicker" value="" style="width: 100px;" />
			</td>
			<td>
				<span class="label">Data Final:</span>
			</td>
			<td>
				<input type="text" name="data_final" readonly="readonly" class="datepicker" value="" style="width: 100px;" /></td>
			<td>
				<span>Oferta:</span></td>
			<td>
				<select name="id_oferta" id="id_oferta" style="width: 300px;">
					<option value="">Todas Ofertas</option>
					<?php foreach($ofertasGeral as $dados){?>
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

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	    	<thead>
				<tr>		
					<th><strong>Pechincha</strong></th>
					<th><strong>Data Final</strong></th>
					<th><strong>Data Repasse</strong></th>
					<th><strong>Qtd Vendida</strong></th>					
					<th><strong>Qtd Transações</strong></th>					
					<th><strong>Recebidos</strong></th>
					<th><strong>Repasse</strong></th>
					<th><strong>Taxa Cartão</strong></th>
					<th><strong>Taxa OnLine</strong></th>
					<th><strong>Bruto</strong></th>
					<th><strong>Liquído</strong></th>
				</tr>
			</thead>
			
			<tbody>				
				
		<?php
	if($todasOfertas){
		foreach($todasOfertas as $dados){
			$qtdBoleto = 0;
			$qtdCartao = 0;
			$aprovadoBoleto = 0;			
			$aprovadoCartao = 0;
			
			$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");				
				$pagSeguro = $oferta->listarOfertaPagSeguro($filtro_pagseguro);
				foreach ($pagSeguro as $todosPagamentos){	
					$aux = explode(" ", $todosPagamentos['ProdID']);
					$id_oferta = $aux[0];
										
					if( $id_oferta == $dados['id']){							
						switch ($todosPagamentos['TipoPagamento']){
							case 'Boleto':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];			
								break;
							
							case 'Cartão de Crédito':
								++$aprovadoCartao;
								$qtdCartao += $todosPagamentos['ProdQuantidade'];
								break;
								
							case 'Pagamento Online':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];
								break;
								
							case 'Pagamento':
								++$aprovadoBoleto;
								$qtdBoleto += $todosPagamentos['ProdQuantidade'];
								break;
						}
					}
				}
				
				$qtdVendidos = $qtdBoleto + $qtdCartao;
				//$qtdVendidos = $oferta->qtdVendida($dados['id']);
				$qtdTransacoes = $aprovadoBoleto + $aprovadoCartao;
				
				
				
				$valorPromocao = str_replace(",", ".", $dados['valorpromocao']);
				
				$valorRecebido = $qtdVendidos * $valorPromocao;
				
				$TaxaCartao = ($valorPromocao * $pagseguroCartao) / 100;
				$TaxaBoleto = ($valorPromocao * $pagseguroBoleto) / 100;
				
				$transacoesCartao = $tarifaPagseguro * $aprovadoCartao;
				$transacoesBoleto = $tarifaPagseguro * $aprovadoBoleto;
				
				
								
				$valorCartao = ($TaxaCartao * $qtdCartao) + $transacoesCartao;
				$valorBoleto = ($TaxaBoleto * $qtdBoleto) + $transacoesBoleto;
				
				
				$valorBruto = ($valorRecebido * $dados['lucro']) / 100 ;
				
				$valorLiquido = ($valorBruto - ($valorCartao + $valorBoleto));
				

				$aux = explode("-",$dados['data_final']);
				
				$ano = $aux[0];
				$mes = $aux[1];
				$dia = $aux[2];
				
				$novaData = date("d/m/Y", mktime(0, 0, 0, $mes, $dia + 30, $ano));
				$valorRepasse = $valorRecebido - $valorBruto;
				
				$ParcialGeral += $valorRecebido;
				$ParcialRepasse += $valorRepasse;
				$ParcialCartao += $valorCartao;
				$ParcialBoleto += $valorBoleto;
				$ParcialBruto += $valorBruto;
				$ParcialLiquido += $valorLiquido;
				
			if($qtdTransacoes){	
		?>
			<tr>
				<td><?php echo substr($dados['titulo'], 0, 40);?></td>
				
				<!-- Datas -->			
				<td><?php echo $funcao->formata_data_BR($dados['data_final'])?></td>
				<td><?php echo $novaData?></td>			
				
				<td><?php echo $qtdVendidos;?></td>
				<td><?php echo $qtdTransacoes;?></td>				
				<td><?php echo "R$ ". number_format($valorRecebido,2,',','.')?></td>			
				<td><?php echo "R$ ". number_format($valorRepasse,2,',','.')?></td>			
				<td><?php echo "R$ ". number_format($valorCartao,2,',','.');?></td>
				<td><?php echo "R$ ". number_format($valorBoleto,2,',','.');?></td>			
				<td><?php echo "R$ ". number_format($valorBruto,2,',','.');?></td>			
				<td><?php echo "R$ ". number_format($valorLiquido,2,',','.');?></td>			
			</tr>
	<?php } } }	?>
	</tbody>
</table>
</div>
</body>