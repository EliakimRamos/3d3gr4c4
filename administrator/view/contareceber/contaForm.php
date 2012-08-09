<?php
/*
 * Created on 07/05/2010
 */
 session_start();
 require_once("models/Base.php");
 require_once("models/Contareceber.php");
 require_once("models/Login.php");
 
 $login = new Login();
	$confirmacao = $login->verificar();
	if($confirmacao == false){
?>
		<script language="JavaScript" type="text/javascript">
  			window.location="./entrar.php";
		</script>
		
 <?php
	}
	$conta = new Conta();
	if($_GET['op']== 'Editar'){
		$resposta = $conta->getConta($_GET['i'],'id_conta');
	}
	$ordenarpor = new ordenar();
 ?>
 
<!-- Pesquisa de Cliente --->

<?php 

		$consultacliente=MYSQL_QUERY("SELECT id,nome from cliente order by nome asc");
        	echo mysql_error();


?>

<!-- Fim da pesquisa -->

<script language="JavaScript">

				$(function () {
	           		$("#cliente").change(function () {
						$.post("view/agenda/clienteslista.php",{ //essa lista será dos pedidos, ainda não foi feito o arq.
							cliente:$("#cliente").val()
						   	},
							function(data){
								$("#resultado").html(data);
							});
							if($("#cliente").val() != ""){
								$("#item").removeAttr('disabled');
							}else{
								$("#item").attr("disabled","disabled");
							}
						});//fim change cliente
	           		});//fim cliente
	           		
</script>

<html>
<head>
<title>:::::: Sistema de Gerenciamento Jungle Kids  ::::::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<body>  
 
<h3 class="titulo"><?php echo $_GET['tela'];?></h3><br/>
<div class="corpo" >

<span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
  <form class="form_login" id="formConta" method="post" action="controllers/contareceber/contareceber.php" >
  <input type="hidden" name="id_conta" value="<?php echo $resposta['id_conta'];?>"/>
  		<input type="hidden" name="pacote" value="<?php echo $_GET['pac'];?>"/>
  		<input type="hidden" name="tela" value="conta"/> 
   		<label class="label">Ordenar por:</label><?php $ordenarpor->gera_combo_ordenar($resposta['ordenar']);?>
   		<label class="label">Selecionar Cliente:</label>
   			<select name="cliente" id="cliente">
	   			<option value=""> |------- Selecione um Cliente -------|</option>
		          <?php while($dados=MYSQL_FETCH_ASSOC($consultacliente)){?>
		          <option value="<?php echo $dados['id']?>"><?php echo $dados['nome']?></option>
		          <?php  } ?>
        	</select>
        	<div id="resultado">
        	</div>
        <label class="label">Data da Emissão</label><label class="label"><input type="text" readonly id="datepicker" name="data" value="<?php echo $Agenda->date_transform($resposta['data']);?>" /></label>	
  
  
</div>
</body>
</html>