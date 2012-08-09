<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Oferta.php");
require_once("models/Funcoes.php");
require_once("models/Empresa.php"); 
require_once("models/Administrador.php");
require_once("models/CidadesOferta.php");

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
	
}
$funcao = new Funcoes();
$oferta = new Oferta();
$empresa = new Empresa();
$admin = new Administrador();

$filtro = "";

if($_GET['id_cidade']){
	$filtro .= " and c.id_cidade = ".$oferta->anti_injection($_GET['id_cidade']);
}

$filtro .= " and ativa >= 1";
$objCidades = new CidadesOferta();
$resposta = $oferta->listarOferta($filtro);
$info = $resposta['oferta'];
$oferta->conectar();

$cidades = mysql_query("SELECT * FROM cidade_oferta order by descricao");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Agendamento de Ofertas</title>			
		
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/jquery-ui-1.8.4.custom.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/page.css" />
		<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/table_jui.css" />
		
		<script type="text/javascript" charset="utf-8"> 		
			$(function(){ 
				$(".datepicker").datepicker({
					 showButtonPanel: true
					  });	
				});	
		</script>
<script>

function Agendar(id){

	var ok = true;

	if($("#nova_posicao_"+id).val() == "" || $("#data_"+id).val() == "") {
		ok = false;
	} 
	
	
	if(ok){
		$.post("view/oferta/ConfirmarAgendamento.php",{
			posicao : $("#nova_posicao_"+id).val(),
			data : $("#data_"+id).val(),
			id: id		
			},  	 
			function(data){
				setTimeout("location.reload(true)", 300);  
			});
		}else{
			alert("Preencha corretamente a Posição e a Data do Agendamento...");
		}
}

function Cancelar(id){
		$.post("view/oferta/CancelarAgendamento.php",{
			id: id		
			},  	 
			function(data){
			 	setTimeout("location.reload(true)", 300);
			});
}
</script>
</head>
<body>
<div class="titulo">Listagem das Ofertas</div>
	<div class="corpo">
		<span style="color: red; margin-top: 19px;" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
		
		<form action="?pac=oferta&tela=Agendar" name="filtros" method="get">
			<table align="center">
				<tr>
				<td>
					<input type="hidden" name="pac" value="oferta"/>
					<input type="hidden" name="tela" value="Agendar"/>			
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
					<input name="submit" type="submit" value="Pesquisar"/>
				</td>
			</tr>
		</table>
	</form>


		
			
	<form action="controllers/Oferta.php" method="post"	id="formOferta">		
			<table cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
	    		<thead>
					<tr>	
						<td class="topoTabela">Título</td>						
						<td class="topoTabela">Cidades</td>							
						<td class="topoTabela">Valor Promoção</td>
						<td class="topoTabela">Inicio</td>
						<td class="topoTabela">Final</td>
						<td class="topoTabela">Qtd Vendida</td>	
						<td class="topoTabela">Posição Atual</td>
						<td class="topoTabela">Nova Posição</td>
						<td class="topoTabela">Data Agendamento</td>			
						<td class="topoTabela" width="5%"></td>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($info)){
						foreach($info as $dados){
							$cidade = $oferta->CidadeOferta($dados['id_cidade_oferta']);
							?>
						<tr>
							<td><?php echo substr($dados['titulo'], 0, 25)?></td>
							<td><?php								
									$CidadesOferta = $objCidades->listarCidades(" and id_oferta=".$dados['id']);
									foreach ($CidadesOferta as $NomeCidades){
											$cidade = $oferta->CidadeOferta($NomeCidades['id_cidade']);
											echo $cidade['descricao']."<br>";
									}
								?>
							</td>
							<td><?php echo "R$ ". number_format($dados['valorpromocao'],2,',','.')?></td>
							<td><?php echo $funcao->formata_data_BR($dados['data_inicio'])?></td>
							<td><?php echo $funcao->formata_data_BR($dados['data_final'])?></td>							
							<td><?php echo $oferta->qtdVendida($dados['id']);?></td>
							<td>
								<?php
									switch ($dados['posicao']){
										case 1:
											echo "Destaque";
											break;
										case 2:
											echo "Bônus 1";
											break;	
										
										case 3:
											echo "Bônus 2";
											break;
											
										case 4:
											echo "Bônus 3";
											break;
										
										case 5:
											echo "Bônus 4";
											break;
										
										case 6:
											echo "Bônus 5";
											break;
									}
									?>							
							</td>
							<td>
								<?php if($dados['agendado'] == 0){?>
									<select name="nova_posicao" id="nova_posicao_<?php echo $dados['id'];?>" style="width: 130px;">
					  					<option value="" selected="selected"> Selecione a Posição</option>
					  					<option value="1" <?php if($dados['nova_posicao'] == 1){ echo 'selected="selected"';}?>> Destaque </option>
					  					<option value="2" <?php if($dados['nova_posicao'] == 2){ echo 'selected="selected"';}?>> Bônus 1</option>
					  					<option value="3" <?php if($dados['nova_posicao'] == 3){ echo 'selected="selected"';}?>> Bônus 2</option>
					  					<option value="4" <?php if($dados['nova_posicao'] == 4){ echo 'selected="selected"';}?>> Bônus 3</option>  				
					  					<option value="5" <?php if($dados['nova_posicao'] == 5){ echo 'selected="selected"';}?>> Bônus 4</option>  				
					  					<option value="6" <?php if($dados['nova_posicao'] == 6){ echo 'selected="selected"';}?>> Bônus 5</option>  					  				
					  				</select>
					  			<?php }else{
										switch ($dados['novaposicao']){
											case 1:
												echo "Destaque";
												break;
											case 2:
												echo "Bônus 1";
												break;	
											
											case 3:
												echo "Bônus 2";
												break;
												
											case 4:
												echo "Bônus 3";
												break;
											
											case 5:
												echo "Bônus 4";
												break;
											
											case 6:
												echo "Bônus 5";
												break;
										}
									}?>					  			
							</td>
							<td>								
								<input type="text" name="data_agendamento" id="data_<?php echo $dados['id'];?>" readonly="readonly" class="datepicker" <?php if($dados['agendado'] == 1){?> value="<?php echo $funcao->formata_data_BR($dados['data_agendamento'])?>" <?php }?> style="width: 80px;" />
							</td>
							<td>		
								<?php if($dados['agendado'] == 0){?>					
									<a href=javascript:Agendar(<?php echo $dados['id'];?>)>
										<img title="Confirmar Agendamento" src="img/confirmar_agendamento.png" border="0" style="cursor: pointer;">
									</a>
								<?php }else{?>
									<a href=javascript:Cancelar(<?php echo $dados['id'];?>)>
										<img title="Excluir Agendamento" src="img/excluir_agendamento.png" border="0" style="cursor: pointer;">
									</a>
								<?php }?> 								
						</td>
					</tr>
					<?php } }?>			
				</tbody>
			</table>
		</form>
</div>
</body>
</html>