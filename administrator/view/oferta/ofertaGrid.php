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

if($_GET['id_posicao']){
	$filtro .= " and o.posicao = ".$oferta->anti_injection($_GET['id_posicao']);
}

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
		
		<title>Listagem Administradores</title>	
		<script type="text/javascript" charset="utf-8"> 			
		$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );	
			
  	$(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=oferta&tela=ofertaForm&op=Inserir";
  	 });
  	 
  
  	 $("#selecionatodos").click(function(){
  	 		
  	 		if(this.checked == true){
  	 			$(":checkbox").attr("checked","checked");
  	 		}else{
  	 			$(":checkbox").attr("checked","");
  	 		}
  	 });
  	 
  	$("#botaoExcluir").click(function(){	 		
  	 	if($("input[type=checkbox]:checked").length != 0){
  	 			if(confirm("Deseja realmente excluir essa oferta?")){
  	 				$("#formOferta").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione uma oferta para ser excluida");
  	 		}  	 	
  	 });  	
 	 	
  	$("#botaoDesativar").click(function(){	 		
  	 	if($("input[type=checkbox]:checked").length != 0){
  	 			if(confirm("Deseja realmente alterar essa oferta?")){
  	 				$("#op").val('desativar');
  	 				$("#formOferta").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione uma oferta para ser Alterada");
  	 		}  	 	
  	 });  	
  });
</script>
</head>
<body>
<div class="titulo">Listagem das Ofertas</div>
	<div class="corpo">
		
		<div id="btns-editores">
			
			<a class="dcontexto">
				<div id="botaoInserir" class="btn-inserir" title="Inserir"></div>
			</a> 
			<?php if($_SESSION['nivelAdmin'] == 1){?>
				<a class="dcontexto">
					<div id="botaoDesativar" title="Desativar"><span>Desativar</span></div>
				</a>
				<a class="dcontexto">
					<div id="botaoExcluir" class="btn-apagar" title="Excluir"><span>Excluir</span></div>
				</a>
			<?php }?>
		</div>
		
		<span style="color: red; margin-top: 19px;" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
	
		<form action="?pac=oferta&tela=ofertaGrid" name="filtros" method="get">
			<table align="center">
				<tr>
				<td>
					<input type="hidden" name="pac" value="oferta"/>
					<input type="hidden" name="tela" value="ofertaGrid"/>			
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
					Posição de Exibição:
					<select name="id_posicao" id="id_posicao" style="width: 130px;">
						<option value="" selected="selected"> Selecione a Posição</option>
	  					<option value="1"> Posição Destaque </option>
	  					<option value="2"> Bônus 1</option>
	  					<option value="3"> Bônus 2</option>
	  					<option value="4"> Bônus 3</option>  				
	  					<option value="5"> Bônus 4</option>  				
	  					<option value="6"> Bônus 5</option>  				
	  					<option value="7"> Bônus 6</option>  				
	  					<option value="8"> Bônus 7</option>  				
	  					<option value="9"> Bônus 8</option>  				
	  					<option value="10"> Bônus 9</option>  				
	  					<option value="11"> Bônus 10</option>  				
	  					<option value="12"> Bônus 11</option>  				
	  					<option value="13"> Bônus 12</option>  				
					</select>
				</td>			
				<td>
					<input name="submit" type="submit" value="Pesquisar"/>
				</td>
			</tr>
		</table>
	</form>



	<form action="controllers/Oferta.php" method="post"	id="formOferta">		
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    		<thead>
					<tr>		
						<th width="5%">
							<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
		  					<input type="hidden" name="op" id="op" value="Deletar" />
							<input type="hidden" name="tela" value="oferta" /> 
							<input type="hidden" name="pac" value="oferta" />
						</th>
						<th width="30%">Título</th>
						<th width="14%">Empresa</th>
						<th width="10%">Cidades</th>
						<th width="7%">Valor Real</th>
						<th width="5%">Desconto</th>	
						<th width="7%">Valor Promoção</th>
						<th width="7%">Inicio</th>
						<th width="7%">Final</th>
						<th width="7%">Status</th>
						<th width="6%">Posição</th>	
						<th width="5%">Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($info)){
						foreach($info as $dados){
							$achar_empresa = $empresa->getEmpresa($dados['id_empresa'], "id");
							$achar_admin = $admin->getAdministrador($_SESSION['id'],"id");
							$cidade = $oferta->CidadeOferta($dados['id_cidade_oferta']);
							?>
						<tr>
							<td>
								<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id'];?>" />
							</td>
							<td align="left"><?php echo substr($dados['titulo'], 0, 40)?></td>
							<td align="left"><?php echo ucwords(strtolower(substr($achar_empresa['nome'], 0, 22)));?></td>
							<td><?php
									
																			
									$CidadesOferta = $objCidades->listarCidades(" and id_oferta=".$dados['id']);
									foreach ($CidadesOferta as $NomeCidades){
											$cidade = $oferta->CidadeOferta($NomeCidades['id_cidade']);
											echo $cidade['descricao']."<br>";
									}
								?>
							</td>
							<td><?php echo "R$ ". number_format($dados['valor'],2,',','.')?></td>
							<td><?php echo $dados['desconto']." %"?></td>
							<td><?php echo "R$ ". number_format($dados['valorpromocao'],2,',','.')?></td>
							<td><?php echo $funcao->formata_data_BR($dados['data_inicio'])?></td>
							<td><?php echo $funcao->formata_data_BR($dados['data_final'])?></td>
							<td>	<?php
									switch ($dados['ativa']){
										case 0:
											echo "Desativada";
											break;
										case 1:
											echo "Ativa";
											break;	
										
										case 2:
											echo "Cadastrada";
											break;
									}
									?>
							</td>			
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
										case 7:
											echo "Bônus 6";
											break;
										case 8:
											echo "Bônus 7";
											break;
										case 9:
											echo "Bônus 8";
											break;
										case 10:
											echo "Bônus 9";
											break;
										case 11:
											echo "Bônus 10";
											break;
										case 12:
											echo "Bônus 11";
											break;
										case 13:
											echo "Bônus 12";
											break;
									}
									?>
							
							</td>
							<td>
								<a href="?pac=oferta&tela=ofertaForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"> 
									<img title="Editar" src="img/editar.png" width="15"	height="17" border="0"> 
								</a>
								<a href="?pac=oferta&tela=CopiarOferta&i=<?php echo $dados['id'];?>" id="edit"> 
									<img title="Editar" src="img/copiar.png" width="15"	height="17" border="0"> 
								</a>
						</td>
					</tr>
					<?php } }?>			
				</tbody>
			</table>
		</form>
</div>
</body>
</html>