<?php session_start();

 require_once("models/Base.php");
 require_once("models/Paginacao.php");
 require_once("models/Cliente.php");
 require_once('models/Login.php');
 
 	$login = new Login();
	$confirmacao = $login->verificar();
	if($confirmacao == false){

		header("location:../../entrar.php");
	
	}

 $cliente = new Cliente();
 $filtro = "";
 
 $resposta = $cliente->listarClientes2($filtro);
 $clientes = $resposta;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">  

<html>
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		
		<title>Listagem Cliente</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/preloader/Preloader.js"></script>

		<style type="text/css">

			#container {
				display: none;
				width: 800px;
				margin: 0 auto 0 auto;
				margin-top: 80px;
			}

		</style>

	
		<style type="text/css" title="currentStyle"> 
			@import "../js/tabela/page.css";
			@import "../js/tabela/table_jui.css";
			@import "../js/tabela/jquery-ui-1.8.4.custom.css";
		</style>
		
		<!--  
			<script type="text/javascript" language="javascript" src="../js/tabela/jquery.js"></script>
		 --> 
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
	  	 		window.location="?pac=cliente&tela=clienteForm&op=Inserir";
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
  	 				$("#formCliente").submit();  	 			
  	 			}
  	 		}else{
  	 			alert("Selecione um registro para ser excluido");
  	 		}  	 	
  	 })

  	$("#pesquisacliente").keyup(function(){
  	 	$.post("view/cliente/buscacliente.php",{nome:$("#pesquisacliente").val()}, 
  	 		function(data){
  	 			$("#consultaCliente").html(data);
  	 	})
  	 });
  });
</script>
	</head>

	<body>

		<div id="container">

			
<div class="titulo">Listagem de Clientes</div>
	<div class="corpo">
		<div id="botoes">
		    <a class="dcontexto"><div id="botaoInserir" title="Inserir"><span>Inserir</span></div></a>
		    <a class="dcontexto"><div id="botaoExcluir" title="Excluir"><span>Excluir</span></div></a>
		</div>
		<span style="color:red; margin-top:19px;"id="mensagem"><?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
	
	
	
			<form action="controllers/Cliente.php" method="post" id="formCliente" >
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	    		<thead>
					<tr>		
						<th width="5%">
							<input type="checkbox" name="selecionatodos"  id="selecionatodos"  />
		  					<input type="hidden" name="op" value="Deletar"/>
							<input type="hidden" name="tela" value="cliente" />
							<input type="hidden" name="pac" value="cliente" />
						</th>
						<th width="30%"><strong>Nome</strong></th>
						<th width="5%"><strong>SMS</strong></th>
						<th width="5%"><strong>Newsletter</strong></th>
						<th width="30%"><strong>E-mail</strong></th>					
						<th width="15%"><strong>Celular</strong></th>					
						<th width="5%"><strong>Ação</strong></th>
					</tr>
				</thead>
				<tbody>
 					<?php 
 						if($clientes){
 							foreach($clientes as $dados){ 		
 					?>
    				<tr class="gradeA">
      					<td>
  							<input type="checkbox" name="id[]" class="checkbox" value="<?php echo $dados['id'];?>"/>  
 	 					</td>
      					
      					<td><?php echo ucwords(strtolower($dados['nome']));?></td>
	  					
	  					<td>
	  					<?php if($dados['receber_sms'] == 0){
					  			echo "Sim";
					  		}else{
					  			echo "Não";
				 			}?>
					  </td>
					  
	  				  <td>
	  				  <?php if($dados['receber_news'] == 0){
				  			echo "Sim";
				  		}else{
				  			echo "Não";
			 			}?>
					  </td>
					  	  
	  				  <td><?php echo $dados['email'];?></td>
	  					
	  				  <td><?php echo $dados['celular'];?></td>
	  				  
					  <td>			
				  			<a href="?pac=cliente&tela=clienteForm&op=Editar&i=<?php echo $dados['id'];?>" id="edit"><img title="Editar" src="img/editar.png" width="31" height="35" border="0"></a> 
				  	  </td>
			  	  </tr>
   				<?php } } ?>
   			</tbody>
		</table>
	</form>
</div>

		</div>

		<script type="text/javascript">

			$.Preloader(
				{
					barColor     : "#fff",
					overlayColor : "#000",
					barHeight    : "10px",
					siteHolder   : "#container"	
				}
			);

		</script>

	</body>

</html>