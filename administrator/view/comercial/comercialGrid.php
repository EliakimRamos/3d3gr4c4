<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Comercial.php");

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
}

$comercialistrador = new Comercial();

$resposta = $comercialistrador->listarComercial2();
$comercial = $resposta['comercial'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem Representantes Comerciais</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		
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
			
  $(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=comercial&tela=comercialForm&op=Inserir";
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
  	 			if(confirm("Deseja realmente excluir esse registro?")){
  	 				$("#formComercial").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 });
  });
</script>
</head>
<body>
<div class="titulo">Listagem Representantes Comerciais</div>
<div class="corpo">
	
	<div id="btns-editores">
			<div id="botaoInserir" class="btn-inserir" title="Inserir"></div> 
		<?php if($_SESSION['nivelAdmin'] == 1){?>
				<div id="botaoExcluir" class="btn-apagar" title="Excluir"></div>
		<?php }?>
	</div>
	
	<span style="color: red; margin-top: 19px;" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>

	<form action="controllers/ComercialForm.php" method="post" id="formComercial">		
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	    		<thead>
					<tr>		
						<td width="5%" class="topoTabela">
							<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
		  					<input type="hidden" name="op" value="Deletar" />
							<input type="hidden" name="tela" value="comercial" /> 
							<input type="hidden" name="pac" value="comercial" />
						</td>
						<th>Nome </th>
						<th>Email</th>
						<th>Telefone</th>
						<td class="topoTabela">Ação</td>
					</tr>
				</thead>
				<tbody>
				<?php if($comercial){
					foreach($comercial as $dados){?>
				<tr>
					<td> 
						<input type="checkbox" name="id[]" class="checkbox"	value="<?php echo $dados['id'];?>" />
					</td>
					<td><?php echo ucwords(strtolower($dados['nome']));?></td>
					<td><?php echo $dados['email'];?></td>
					<td><?php echo $dados['fone'];?></td>
					<td>
						<?php if($_SESSION['nivelAdmin'] == 1){?>			
							<a href="?pac=comercial&tela=comercialForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"> 
								<img title="Editar" src="img/editar.png" width="15"	height="17" border="0"> 
							</a>
						<?php }?>
				   </td>
				</tr>
				<?php }	}?>
				</tbody>
		 </table>
	</form>
</div>
</body>
</html>