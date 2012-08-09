<?php session_start();
require_once("models/Base.php");
require_once("models/Login.php");
require_once("models/Oferta.php");
require_once("models/Funcoes.php");
require_once("models/Empresa.php"); 

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	header("location:../../entrar.php");	
}

$objFuncao = new Funcoes();
$objOferta = new Oferta();
$objEmpresa = new Empresa();

$aux = explode("-",date("Y-m-d"));
$ano = $aux[0];
$mes = $aux[1];
$dia = $aux[2];
				
$data_aux = date("d/m/Y", mktime(0, 0, 0, $mes, $dia + 1, $ano));

$data = $objFuncao->formata_data($data_aux);


$ofertasAtivas = $objOferta->listarOferta2("and ativa = 1");
$ofertasCadatradas = $objOferta->listarOferta2("and ativa = 2 and data_inicio>='".$data."'");
?>

<script>
	function Alterar(id){
		if(confirm("Deseja alterar a Oferta?")){
		 	$.post("view/oferta/AgendarOferta.php",{ id:id })	 		
			setTimeout("location.reload(true)", 100);
		}
	 }
</script>

<?php if($ofertasCadatradas){?>
<div class="titulo">Ofertas Cadastradas</div>
<div class="corpo">
	<div id="resuloferta">	
			<table class="table">	
				<tr class="column1_titulo">
					<th> Data Inicio </th>
					<th> Oferta </th>
					<th> Imagem </th>
					<th> Empresa</th>
				</tr>			
					<?php foreach ($ofertasCadatradas as $dados){
					 	$contador = 0;
					 	$fotoOferta = $objOferta->listarOfertaImagem("and id_oferta =".$dados['id']);					 
					 	$empresaOferta = $objEmpresa->getEmpresa($dados['id_empresa'], "id");
					 	?>
					 	<tr>
						 	<td> <?php echo $objFuncao->formata_data_BR($dados['data_inicio'])?></td>			 	
						 	<td> <?php echo $dados['titulo'] ?></td>
						 	<td> <img src="uploads/<?php echo $fotoOferta['0']['image']?>" width="174" height="110" border="0"/></td>
						 	<td> <?php echo $empresaOferta['nome'] ?></td>
						</tr>				
					<?php }?>
			</table>		
	</div>
</div>	
<?php }else{?>
			<h2>Não existe Ofertas Cadastradas !</h2>
<?php }?>	


<div class="titulo">Programar Remoção de Ofertas</div>
<div class="corpo">
	<div id="resuloferta">
		<?php if($ofertasAtivas){?>
			<table class="table">	
				<tr class="column1_titulo">
					<th> Informação</th>
					<th> Data Final </th>
					<th> Oferta </th>
					<th> Imagem </th>
					<th> Empresa</th>
				</tr>			
					<?php foreach ($ofertasAtivas as $dados){
					 	$contador = 0;
					 	$fotoOferta = $objOferta->listarOfertaImagem("and id_oferta =".$dados['id']);					 
					 	$empresaOferta = $objEmpresa->getEmpresa($dados['id_empresa'], "id");
					 	?>
					 	<tr>
						 	<td> <?php if($dados['agendado'] == 1){?>
						 			<a href=javascript:Alterar(<?php echo $dados['id']?>)>
						 				<img alt="Exclusão Agendada" id="alterar" src="img/excluir.png">
						 			</a>
						 		<?php }else{?>
						 			<a href=javascript:Alterar(<?php echo $dados['id']?>)>
						 				<img alt="Oferta Ativa" id="alterar" src="img/confirmado.gif">
						 			</a>
						 		<?php }?>						 		
						 	</td>		
						 	<td> <?php echo $objFuncao->formata_data_BR($dados['data_final'])?></td>			 	
						 	<td> <?php echo $dados['titulo']?></td>
						 	<td> <img src="uploads/<?php echo $fotoOferta['0']['image']?>" width="174" height="110" border="0"/></td>
						 	<td> <?php echo $empresaOferta['nome']?></td>
						</tr>				
					<?php }?>
			</table>
		<?php }else{?>
			<h2>Não foi encontrado nenhum registro !</h2>
		<?php }?>
	</div>
</div>