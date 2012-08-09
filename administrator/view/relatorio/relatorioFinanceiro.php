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

$data_inicio = $oferta->anti_injection($_GET["data_inicio"]);
$data_final = $oferta->anti_injection($_GET["data_final"]); 
$idOferta = $oferta->anti_injection($_GET['id_oferta']);

if (!empty($data_inicio) && !empty($data_final)){
	$filtro_pagseguro= $filtro_pagseguro. "and date between '".$funcao->formata_data($data_inicio)."' and '".$funcao->formata_data($data_final)."'";
}else{
	$data_hoje = date ("Y-m-d");
	if(!empty($data_inicio) && empty($idOferta)){
		$filtro_pagseguro= $filtro_pagseguro. "and date between '".$funcao->formata_data($data_inicio)."' and '".$data_hoje."'";				
	}else{
		if(!empty($idOferta)){
			$filtro_pagseguro = "";
		}else{
			$filtro_pagseguro= $filtro_pagseguro. "and date between '".$data_hoje."' and '".$data_hoje."'";
		}
	}
}

if (!empty($idOferta)){
	$filtro_pagseguro= $filtro_pagseguro. "and items_id LIKE  '".$idOferta." %' ";
	$filtro = $filtro. " and o.id =".$idOferta;
}


$filtro_pagseguro= $filtro_pagseguro." and status_code in (3,4)";

$resposta = $oferta->listarOfertaFinanceiro($filtro, $qtd);
$todasOfertas = $resposta['oferta'];
$paginacao = $resposta['paginacao'];
$oferta->conectar();

$ofertasGeral = $oferta->OfertasFinanceiro("");

$TOTAL = count($ofertasGeral);
$temp = $oferta->listarOfertaFinanceiro($filtro, $TOTAL);
$TempOfertasGeral = $temp['oferta'];

if($TempOfertasGeral){
		foreach($TempOfertasGeral as $dados){
			$qtdBoleto = 0;
			$qtdCartao = 0;
			$aprovadoBoleto = 0;			
			$aprovadoCartao = 0;
			
				$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");				
				$pagSeguro = $oferta->listarOfertaPagSeguro($filtro_pagseguro);
				
				if($pagSeguro){
					foreach ($pagSeguro as $todosPagamentos){	
						$aux = explode(" ", $todosPagamentos['items_id']);
						$id_oferta = $aux[0];
											
						if( $id_oferta == $dados['id']){							
							switch ($todosPagamentos['type']){
								case '2':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];			
									break;
								
								case '1':
									++$aprovadoCartao;
									$qtdCartao += $todosPagamentos['item_qtd'];
									break;
									
								case '3':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];
									break;
									
								case '4':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];
									break;
							}
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

<script language="javascript" src="js/Utils.js"></script>
<script language="javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script>
 $(function(){ 
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
<table class="table">
	<tr>
		<td colspan="6"> </td>
		<td> <strong><?php echo "R$ ". number_format($TotalGeral,2,',','.');?></strong> </td>					
		<td class="vermelho"> <strong><?php echo "R$ ". number_format($TotalRepasse,2,',','.');?></strong> </td>					
		<td class="vermelho"><?php echo "R$ ". number_format($TotalCartao,2,',','.');?></td>
		<td class="vermelho"><?php echo "R$ ". number_format($TotalBoleto,2,',','.');?></td>			
		<td class="azul"><?php echo "R$ ". number_format($TotalBruto,2,',','.');?></td>			
		<td class="verde"><?php echo "R$ ". number_format($TotalLiquido,2,',','.');?></td>	
	</tr>
	<tr class="column1_titulo">
		<th width="6%"> ID </th>
		<th width="20%">Oferta</th>

		<th width="5%">Data Final</th>		
		<th width="5%">Data Repasse</th>	
			
		<th width="5%">Qtd Vendida</th>
		<th width="5%">Qtd Transações</th>	
			
		<th width="9%">Recebidos</th>	
		<th width="9%">Repasse</th>			
		<th width="9%">Taxa Cartão</th>		
		<th width="9%">Taxa OnLine</th>
		<th width="9%">Bruto</th>
		<th width="9%">Liquído</th>
	</tr>
	<?php
	if($todasOfertas){
		foreach($todasOfertas as $dados){
			$qtdBoleto = 0;
			$qtdCartao = 0;
			$aprovadoBoleto = 0;			
			$aprovadoCartao = 0;
			
			$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");				
				$pagSeguro = $oferta->listarOfertaPagSeguro($filtro_pagseguro);
				if($pagSeguro){
					foreach ($pagSeguro as $todosPagamentos){	
						$aux = explode(" ", $todosPagamentos['items_id']);
						$id_oferta = $aux[0];
											
						if( $id_oferta == $dados['id']){							
							switch ($todosPagamentos['type']){
								case '2':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];			
									break;
								
								case '1':
									++$aprovadoCartao;
									$qtdCartao += $todosPagamentos['item_qtd'];
									break;
									
								case '3':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];
									break;
									
								case '4':
									++$aprovadoBoleto;
									$qtdBoleto += $todosPagamentos['item_qtd'];
									break;
							}
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
			<td><?php echo $dados['id'];?></td>
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
	<?php } } ?>
		<tr>
			<td colspan="6"> </td>
			<td> <strong><?php echo "R$ ". number_format($ParcialGeral,2,',','.');?></strong> </td>					
			<td class="vermelho"> <strong><?php echo "R$ ". number_format($ParcialRepasse,2,',','.');?></strong> </td>					
			<td class="vermelho"><?php echo "R$ ". number_format($ParcialCartao,2,',','.');?></td>
			<td class="vermelho"><?php echo "R$ ". number_format($ParcialBoleto,2,',','.');?></td>			
			<td class="azul"><?php echo "R$ ". number_format($ParcialBruto,2,',','.');?></td>			
			<td class="verde"><?php echo "R$ ". number_format($ParcialLiquido,2,',','.');?></td>	
		</tr>
	<?php }	?>
</table>
</div>
</body>