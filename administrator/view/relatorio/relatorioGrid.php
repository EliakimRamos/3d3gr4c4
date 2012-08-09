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
	header("location: ./index.php");
}

$funcao = new Funcoes();
$oferta = new Oferta();
$empresa = new Empresa();
	
$filtro = "";

$idCidade = $oferta->anti_injection($_GET['id_cidade']) ;

if(!empty($idCidade)){
	$filtro .= " and c.id_cidade = ".$idCidade;
}

$idSatus = $oferta->anti_injection($_GET['id_status']);
switch ($idSatus){
	
	case 1:
		$filtro .= " and o.ativa = 1";
		break;
	
	case 2:
		$filtro .= " and o.ativa = 0";
		break;
	
	case 3:
		$filtro .= "";
		break;
	
	default:
		$filtro .= " and o.ativa = 1";
}

$resposta = $oferta->listarOferta($filtro);
$todasOfertas = $resposta['oferta'];

$oferta->conectar();

$cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem Administradores</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		
		<style type="text/css">

			#container {
				display: none;			
			}
		</style>
		
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

<div class="titulo">Relatório Vendas</div>
	
<div class="corpo">		
	
		<form action="?pac=relatorio&tela=relatorioGrid" name="filtros" method="get">
			<table align="center">
				<tr>
				<td>
					<input type="hidden" name="pac" value="relatorio"/>
					<input type="hidden" name="tela" value="relatorioGrid"/>			
				</td>
				<td>
					Filtrar por Cidade:
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
					Status
					<select name="id_status" id="id_status" style="width: 300px;">
						<option value="3" selected="selected"> Todas Ofertas</option>
						<option value="1"> Ofertas Ativas</option>
						<option value="2"> Ofertas Anteriores</option>						
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
						<th> ID </th>
						<th>Pechincha</th>
								
						<th class="aguardando">Boleto</th>		
						<th class="aguardando">Cartão</th>		
						<th class="aguardando">OnLine</th>
						<th>Total</th>	
							
						<th class="aprovados">Boleto</th>		
						<th class="aprovados">Cart&atilde;o</th>		
						<th class="aprovados">OnLine</th>
						<th>Total</th>
						
						<th class="cancelado">Boleto</th>		
						<th class="cancelado">Cartão</th>		
						<th class="cancelado">OnLine</th>
						<th>Total</th>
							
						<th>Geral</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if($todasOfertas){
							foreach($todasOfertas as $dados){ 
								$canceladoCartao = 0;
								$canceladoBoleto = 0;
								$canceladoOnline = 0;
								
								$aguardandoCartao = 0;
								$aguardandoBoleto = 0;
								$aguardandoOnLine = 0;
								
								$aprovadoBoleto = 0;
								$aprovadoCartao = 0;
								$aprovadoOnLine = 0;
								
					
								$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");
									$sql = mysql_query("SELECT status as status,items_id as id_pag, item_qtd as qtd_pag, type as tipo FROM transpagseguro");
									while ($todosPagamentos = mysql_fetch_array($sql)){	
										$aux = explode(" ", $todosPagamentos['id_pag']);
										$id_oferta = $aux[0];
										
										if( $id_oferta == $dados['id']){					
											switch ($todosPagamentos['status']){
												case '7':									
														switch ($todosPagamentos['tipo']){
															case '2':
																$canceladoBoleto += $todosPagamentos['qtd_pag'];			
																break;
															
															case '1':
																$canceladoCartao += $todosPagamentos['qtd_pag'];
																break;
																
															case '3':
																$canceladoOnline += $todosPagamentos['qtd_pag'];
																break;
														}
													break;
												case '1':
														switch ($todosPagamentos['tipo']){
																case '2':
																$aguardandoBoleto += $todosPagamentos['qtd_pag'];			
																break;
																									
															case '3':
																$aguardandoOnLine += $todosPagamentos['qtd_pag'];
																break;
														}
													break;
												case '2':
													$aguardandoCartao += $todosPagamentos['qtd_pag'];
													break;
													
											
												case '4':
														switch ($todosPagamentos['tipo']){
															case '2':
																$aprovadoBoleto += $todosPagamentos['qtd_pag'];			
																break;
															
															case '1':
																$aprovadoCartao += $todosPagamentos['qtd_pag'];
																break;
																
															case '3':
																$aprovadoOnLine += $todosPagamentos['qtd_pag'];
																break;
															
															case '4':
																$aprovadoOnLine += $todosPagamentos['qtd_pag'];
																break;
														}
													break; 
											
												case '3':
														switch ($todosPagamentos['tipo']){
															case '2':
																$aprovadoBoleto += $todosPagamentos['qtd_pag'];			
																break;
															
															case '1':
																$aprovadoCartao += $todosPagamentos['qtd_pag'];
																break;
																
															case '3':
																$aprovadoOnLine += $todosPagamentos['qtd_pag'];
																break;
															
															case '4':
																$aprovadoOnLine += $todosPagamentos['qtd_pag'];
																break;
														}
													break; 
											}
											
										}
									}
									$aprovado = $aprovadoBoleto + $aprovadoCartao + $aprovadoOnLine;
									$cancelados = $canceladoBoleto + $canceladoCartao + $canceladoOnline;
									$aguardando = $aguardandoBoleto + $aguardandoCartao + $aguardandoOnLine;
									
									$totalGeral = $aprovado + $cancelados + $aguardando;
									
									if($aguardando > 0){
									//if($aguardandoOnLine > 0 || $aguardandoCartao > 0){
								?>			
						<tr>						
							<td><?php echo $dados['id'];?></td>
							<td><?php echo substr($dados['titulo'], 0, 40);?></td>
							
							<!-- Em análise -->
							<td class="aguardando"><?php echo $aguardandoBoleto;?></td>
							<td class="aguardando"><?php echo $aguardandoCartao;?></td>
							<td class="aguardando"><?php echo $aguardandoOnLine;?></td>
							<td><?php echo "<b>".$aguardando."</b>";?></td>
							
							<!-- Aprovados -->
							<td class="aprovados"><?php echo $aprovadoBoleto;?></td>
							<td class="aprovados"><?php echo $aprovadoCartao;?></td>
							<td class="aprovados"><?php echo $aprovadoOnLine;?></td>
							<td><?php echo "<b>".$oferta->qtdVendida($dados['id'])."</b>";?></td>
							
							<!-- Cancelados -->
							<td class="cancelado"><?php echo $canceladoBoleto;?></td>
							<td class="cancelado"><?php echo $canceladoCartao;?></td>
							<td class="cancelado"><?php echo $canceladoOnline;?></td>
							<td><?php echo "<b>".$cancelados."</b>";?></td>
							
							<td><?php echo $totalGeral?></td>
						</tr>
				<?php } }	} ?>
				</tbody>
			</table>
		</div>
	</body>
</html>