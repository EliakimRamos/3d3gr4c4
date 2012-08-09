<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Oferta.php");
require_once("models/Funcoes.php");
require_once("models/Empresa.php"); 
require_once("models/Comercial.php"); 

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	header("location:../../entrar.php");	
}

$funcao = new Funcoes();
$oferta = new Oferta();
$empresa = new Empresa();
$ObjComercial = new Comercial();

$pagseguroBoleto = 2.6;
$pagseguroCartao = 6.1;
$tarifaPagseguro = 0.40;

$filtro = " and ativa <> 2";
$filtro_pagseguro = "";

$data_inicio = $oferta->anti_injection($_GET["data_inicio"]);
$data_final = $oferta->anti_injection($_GET["data_final"]); 
$idOferta = $oferta->anti_injection($_GET['id_oferta']);
$id_vendedor = $oferta->anti_injection($_GET['id_comercial']);

$TempVendedor= $ObjComercial->listarComercial2();
$vendedores = $TempVendedor['comercial'];

if (!empty($data_inicio) && !empty($data_final)){
	$filtro_pagseguro= $filtro_pagseguro. "and data between '".$funcao->formata_data($data_inicio)."' and '".$funcao->formata_data($data_final)."'";
}else{
	$data_hoje = date ("Y-m-d");
	if(!empty($data_inicio) && empty($idOferta)){
		$filtro_pagseguro= $filtro_pagseguro. "and data between '".$funcao->formata_data($data_inicio)."' and '".$data_hoje."'";				
	}else{
		if(!empty($idOferta)){
			$filtro_pagseguro = "";
		}else{
			$filtro_pagseguro= $filtro_pagseguro. "and data between '".$data_hoje."' and '".$data_hoje."'";
		}
	}
}

if (!empty($idOferta)){
	$filtro_pagseguro= $filtro_pagseguro. "and ProdID LIKE  '".$idOferta." %' ";
	$filtro = $filtro. " and o.id =".$idOferta;
}


if (!empty($id_vendedor)){
	$filtro = $filtro. " and o.id_comercial =".$id_vendedor;
}

$filtro_pagseguro= $filtro_pagseguro." and StatusTransacao in ('Completo','Aprovado')";

$resposta = $oferta->listarOfertaFinanceiro($filtro);
$todasOfertas = $resposta['oferta'];

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
				}
				
				$qtdVendidos = $qtdBoleto + $qtdCartao;
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
				
				$valorRepasse = $valorRecebido - $valorBruto;
												
				for ($i=0; $i <=count($vendedores); $i++){
					if($vendedores[$i]['id'] == $dados['id_comercial']){
					   $vendedores[$i]['recebido'] += $valorRecebido;
					   $vendedores[$i]['valorRepasse'] += $valorRepasse;
					   $vendedores[$i]['valorBruto'] += $valorBruto;
					   $vendedores[$i]['valorLiquido'] += $valorLiquido;	
					   $vendeu = true;						
					}					
				}
		}
	}
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relátorio Financeiro</title>
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
<form action="?pac=relatorio&tela=comissao" name="filtros" method="get">
	<table align="center">
		<tr>
			<td>
				<input type="hidden" name="pac" value="relatorio"/>
				<input type="hidden" name="tela" value="comissao"/>
				<span class="label">Data Início:</span>			
				<input type="text" name="data_inicio" readonly="readonly" class="datepicker" value="" style="width: 100px;" />
			</td>
			<td>
				<span class="label">Data Final:</span>			
				<input type="text" name="data_final" readonly="readonly" class="datepicker" value="" style="width: 100px;" />
			</td>
				
			<td>
				<span>Oferta:</span>			
				<select name="id_oferta" id="id_oferta" style="width: 300px;">
					<option value="">Todas Ofertas</option>
					<?php foreach($ofertasGeral as $dados){?>
					<option value="<?php echo $dados['id']?>"><?php echo substr($dados['titulo'], 0, 55) ?></option>
					<?php  } ?>
				</select>
			</td>			
			
			<td>
				<span>Vendedor:</span>			
				<select name="id_comercial" id="id_comercial" style="width: 300px;">
					<option value="">Todos Vendedores</option>
					<?php foreach($vendedores as $info){?>
						<option value="<?php echo $info['id']?>"><?php echo $info['nome']; ?></option>
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
	<tr class="column1_titulo">		
		<th width="20%">Vendedor</th>			
		<th width="10%">Recebidos</th>	
		<th width="10%">Repasse</th>
		<th width="10%">Bruto</th>
		<th width="10%">Liquído</th>
	</tr>
		<!--  Foreach para listar os vendedores e os valores -->
		
		<?php 
			if($vendeu){
				foreach ($vendedores as $dados_vend){
					if($dados_vend['recebido'] > 0){
					?>
				<tr>	
					<td><?php echo $dados_vend['nome']; ?> </td>							
					<td> <strong><?php echo "R$ ". number_format($dados_vend['recebido'],2,',','.')?></strong></td>			
					<td class="vermelho"><?php echo "R$ ". number_format($dados_vend['valorRepasse'],2,',','.')?></td>								
					<td class="azul"><?php echo "R$ ". number_format($dados_vend['valorBruto'],2,',','.');?></td>			
					<td class="verde"><strong><?php echo "R$ ". number_format($dados_vend['valorLiquido'],2,',','.');?></strong></td>			
				</tr>
			<?php } } }else{?>
				<tr>
					<td colspan="5">
						<h2> Nenhuma venda encontrada.</h2>
					</td>			
				</tr>
			<?php }?>
</table>
</div>
</body>
</html>