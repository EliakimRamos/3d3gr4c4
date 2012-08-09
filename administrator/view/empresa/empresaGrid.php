<?php session_start();

require_once("models/Base.php");
require_once("models/Paginacao.php");
require_once("models/Login.php");
require_once("models/Empresa.php");

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
	
}

$empresa = new Empresa();
$filtro = "";
$qtd = 10;

$resposta = $empresa->listarEmpresa2();
$AchouEmpresa = $resposta['empresa'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>  
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem das Empresas</title>
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
			
  $(function (){
  	 $("#botaoInserir").click(function(){
  	 	window.location="?pac=empresa&tela=empresaForm&op=Inserir";
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
  	 				$("#formEmpresa").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 })

  	$("#pesquisaempresa").keyup(function(){
  	 	$.post("view/empresa/buscaempresa.php",{
  	  	 		nome:$("#pesquisaempresa").val()}, 
  	 		function(data){
  	 			$("#resulempresa").html(data);
  	 	})
  	 });
  });
</script>
</head>
<body>
<div class="titulo">Listagem das Empresa</div>
<div class="corpo">
	
	<div id="botoes">
		<a class="dcontexto">
			<div id="botaoInserir" title="Inserir"><span>Inserir</span></div>
		</a> 
		<?php if($_SESSION['nivel'] == 1){?>
			<a class="dcontexto">
				<div id="botaoExcluir" title="Excluir"><span>Excluir</span></div>
			</a>
		<?php }?>
	</div>
	
	<span style="color: red; margin-top: 19px;" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>

	<form action="controllers/Empresa.php" method="post" id="formEmpresa">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
    		<thead>
				<tr>		
					<td width="5%" class="topoTabela">
						<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
	  					<input type="hidden" name="op" value="Deletar"/>
						<input type="hidden" name="tela" value="empresa" /> 
						<input type="hidden" name="pac" value="empresa" />
					</td>
					<th>Nome</th>
					<th>Endereço</th>
					<th>Telefone</th>
					<td class="topoTabela">Ação</td>
				</tr>
			</thead>
			<tbody>
				<?php if($AchouEmpresa){
					foreach($AchouEmpresa as $dados){
				?>
				<tr>
					<td><input type="checkbox" name="id[]" class="checkbox"
						value="<?php echo $dados['id'];?>" /></td>
					<td><?php echo ucwords(strtolower($dados['nome']));?></td>
					<td><?php echo ucwords(strtolower($dados['endereco']));?></td>
					<td><?php echo ucwords(strtolower($dados['fone']));?></td>
					<td>
						<a href="?pac=empresa&tela=empresaForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit">
								<img title="Editar" src="img/editar.png" width="15"	height="17" border="0">
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