<?php session_start();

if(!empty($_GET['tela'])){
	require_once("models/Base.php");
	require_once("models/Comercial.php");
	require_once('models/Login.php');
}else{
	require_once("../../models/Base.php");
	require_once("../../models/Comercial.php");
	require_once('../../models/Login.php');
	$_GET['op'] = "Inserir";
}

$login = new Login();
$confirmacao = $login->verificar();


	if($confirmacao == false){

		header("location:../../entrar.php");
	
	}


$comercial = new Comercial();
if($_GET['op'] == 'Editar'){
	$resposta = $comercial->getComercial($comercial->anti_injection($_GET['i']), "id");
}
if(!empty($_POST['nome'])){
	?>
<script>
 		$(function(){
 			$("#nome").val("<?php echo $comercial->anti_injection($_POST['nome'])?>");	
 		});
 		
 	</script>

	<?php
}
?>
<script>


$(document).ready(function(){ 
	   $("#formComercial").validate({
	      rules: {
		    nome : {required: true},
		   	email : {required: true, email: true},
		    fone: {required: true},
			senha : {required: true} 	
	      },
	      messages: {
		     nome: {required: 'Campo Obrigatório'},
		     email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
		     fone: {required: 'Campo Obrigatório'},
	         senha: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });	
	   $("#fone").mask("(99) 9999-9999");	
	});
	
</script>
<h3 class="titulo"><?php echo $_GET['op']." ". "Comercial";?></h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?>
</span>
<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formComercial" method="post"
	action="controllers/ComercialForm.php">
<table align="center">
	<tr>
		<td align="right">
			<input type="hidden" name="id"	value="<?php echo $resposta['id'];?>" />
			<input type="hidden" name="pac" value="comercial" /> 
			<input type="hidden" name="tela" value="comercial" /> 
			<label class="label">Nome:*</label>
		</td>
		<td align="left">
			<input type="text" id="nome" name="nome" class="input" value="<?php echo $resposta['nome']?>" />
		</td>
			
	</tr>
	
	<tr>
		<td><label class="label">Fone:*</label></td>
		<td align="left">
			<input type="text" id="fone" name="fone"
			class="input" value="<?php echo $resposta['fone']?>" />
		</td>
	</tr>
	
	<tr>
		<td><label class="label">E-mail:*</label></td>
		<td align="left"><input type="text" id="email" name="email"
			class="input" value="<?php echo $resposta['email']?>" /></td>
	</tr>
	
	<tr align="right">
		
		<td align="right"><label class="label">Senha:*</label></td>
		<td align="left"><input type="password" id="senha" name="senha"
			class="input" maxlength="30" value="<?php echo $resposta['senha']?>" /></td>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<input type="submit" name="op" id="op"	value="<?php echo $_GET['op']?>" />
	    </td>
	</tr>
</table>
</form>
</div>