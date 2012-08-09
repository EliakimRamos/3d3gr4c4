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

$filtro_pagseguro = "";
$filtro = "";

if (($_GET["data_inicio"]!="")&& ($_GET["data_final"]!="")){
	$filtro_pagseguro= $filtro_pagseguro. "and data between '".$funcao->formata_data($_GET['data_inicio'])."' and '".$funcao->formata_data($_GET['data_final'])."'";
}else{
	$data_hoje = date ("Y-m-d");
	$filtro_pagseguro= $filtro_pagseguro. "and data between '".$data_hoje."' and '".$data_hoje."'";
}

if ($_GET['id_oferta']){
	//$filtro_pagseguro= $filtro_pagseguro. "and ProdID LIKE  '".$_GET['id_oferta']." %' ";
	$filtro = $filtro. " and o.id =".$_GET['id_oferta'];
}

if($_GET['id_cidade']){
	$filtro .= " and c.id_cidade = ".$_GET['id_cidade'];
}

$filtro_pagseguro= $filtro_pagseguro." and StatusTransacao in ('Completo','Aprovado')";
$resposta = $oferta->listarOfertaFinanceiro($filtro);
$todasOfertas = $resposta['oferta'];
$oferta->conectar();
$ofertasGeral = $oferta->OfertasFinanceiro("");

$cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem Financeiro</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/preloader/Preloader.js"></script>
				
		<script language="javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
		<style type="text/css">
			#container {
				display: none;			
			}
		</style>
			
		<script type="text/javascript">
			$.Preloader(
				{
					barColor     : "#fff",
					overlayColor : "#000",
					barHeight    : "10px",
					siteHolder   : "#container"	
				}
			);			
			
			$(function(){ 
					$(".datepicker").datepicker({
						 showButtonPanel: true
						  }); 
					});	
		</script>
		
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/jquery-ui-1.8.4.custom.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/page.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/table_jui.css" />
		
		<script type="text/javascript" language="javascript" src="../js/tabela/jquery.dataTables.min.js"></script> 
		<script type="text/javascript" charset="utf-8"> 			
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );
		</script>

<style>
.cancelado{
	background: #8EBAFF;
}

.aprovados{
	background: #5CFF66;
}

.aguardando{
	background: #FFFD7C;
}

</style>
</head>
<body>

<div class="titulo"> Relat&oacute;rio Financeiro</div>

<div class="corpo">
	<form action="?pac=relatorio&tela=relatorioFinanceiro" name="filtros" method="get">
		<table align="center">
			<tr>
				<td>
					<input type="hidden" name="pac" value="relatorio"/>
					<input type="hidden" name="tela" value="relatorioFinanceiro"/>
					<span class="label">Data In&iacute;cio:</span>
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
					<span>Cidade:</span>
				</td>				
				<td>
					<select name="id_cidade" id="id_cidade" style="width: 300px;">
						<option value="" selected="selected"> Todas Cidades </option>			
						<?php while ($lista_cidades = mysql_fetch_assoc($cidades)) { ?>
							<option value="<?php echo $lista_cidades['id']?>">
								<?php echo $lista_cidades['descricao']?>							
							</option>
						<?php  } ?>
					</select>
				</td>					
				<td>
					<input name="submit" type="submit" value="Pesquisar"/>
				</td>
			</tr>
		</table>
	</form>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    		<thead>	    			
					<tr>								
						<th width="20%">Pechincha</th>

						<th width="5%">Data Final</th>		
						<th width="5%">Data Repasse</th>	
							
						<th width="5%">Vendida</th>
						<th width="5%">Transa&ccedil;&otilde;es</th>	
							
						<th width="10%">Recebidos</th>	
						<th width="10%">Repasse</th>			
						<th width="10%">Taxa Cart&atilde;o</th>		
						<th width="10%">Taxa OnLine</th>
						<th width="10%">Bruto</th>
						<th width="10%">Liqu&iacute;do</th>
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
									
								$filtro_pagseguro= $filtro_pagseguro. "and ProdID LIKE  '".$dados['id']." %' ";
								var_dump($oferta->listarOfertaPagSeguro($filtro_pagseguro));
								$pagSeguro = $oferta->listarOfertaPagSeguro($filtro_pagseguro);
								var_dump($pagSeguro);								
								if($pagSeguro){																		
									foreach ($pagSeguro as $todosPagamentos){
										echo $todosPagamentos['TipoPagamento']." quantidade ".$todosPagamentos['ProdQuantidade']."<br>";	
																	
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
										//	}
										
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
					<?php
						$TotalGeral += $valorRecebido;
						$TotalRepasse += $valorRepasse;
						$TotalCartao += $valorCartao;
						$TotalBoleto += $valorBoleto;
						$TotalBruto += $valorBruto;
						$TotalLiquido += $valorLiquido;
						
						} } }}?>
				</tbody>
				
				<tfoot>
				    <tr>
						<td colspan="5"> </td>
						<td> <strong><?php echo "R$ ". number_format($TotalGeral,2,',','.');?></strong> </td>					
						<td class="vermelho"> <strong><?php echo "R$ ". number_format($TotalRepasse,2,',','.');?></strong> </td>					
						<td class="vermelho"><?php echo "R$ ". number_format($TotalCartao,2,',','.');?></td>
						<td class="vermelho"><?php echo "R$ ". number_format($TotalBoleto,2,',','.');?></td>			
						<td class="azul"><?php echo "R$ ". number_format($TotalBruto,2,',','.');?></td>			
						<td class="verde"><?php echo "R$ ". number_format($TotalLiquido,2,',','.');?></td>	
					</tr> 
			  </tfoot>
			</table>
		</div>
	</body>
</html>				