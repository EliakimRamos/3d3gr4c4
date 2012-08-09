<?php session_start();

if(!empty($_GET['tela'])){
	require_once("models/Base.php");
	require_once("models/Administrador.php");
	require_once('models/Login.php');
}else{
	require_once("../../models/Base.php");
	require_once("../../models/Administrador.php");
	require_once('../../models/Login.php');
	$_GET['op'] = "Inserir";
}

$login = new Login();
$confirmacao = $login->verificar();


	if($confirmacao == false){

		header("location:../../entrar.php");
	
	}


$administrador = new Administrador();
if($_GET['op'] == 'Editar'){
	$resposta = $administrador->getAdministrador($administrador->anti_injection($_GET['i']), "id");
}
$nome = $administrador->anti_injection($_POST['nome']);
if(!empty($nome)){
	?>
<script>
 		$(function(){
 			$("#nome").val("<?php echo $_POST['nome']?>");	
 		});
 		
 	</script>

	<?php
}
?>
<script>


$(document).ready(function(){ 
	   $("#formAdministrador").validate({
	      rules: {
		    nome : {required: true},
		   	email : {required: true, email: true},
			senha : {required: true} 	
	      },
	      messages: {
		     nome: {required: 'Campo Obrigatório'},
		     email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
	         senha: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });		
	});
	
</script>
<h3 class="titulo"><?php echo $_GET['op']." ". "Administrador";?></h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?>
</span>
<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formAdministrador" method="post"
	action="controllers/Administrador.php">
<table align="center">
	<tr>
		<td align="right">
			<input type="hidden" name="id"	value="<?php echo $resposta['id'];?>" />
			<input type="hidden" name="pac" value="admin" /> 
			<input type="hidden" name="tela" value="admin" /> 
			<label class="label">Nome:*</label>
		</td>
		<td align="left">
			<input type="text" id="nome" name="nome" class="input" value="<?php echo $resposta['nome']?>" />
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
	<?php if($_SESSION['nivel'] == 1){?>
		<tr align="right">
			
			<td align="right"><label class="label">Nivel Admin:*</label></td>
			<td align="left">
						<select id="nivel" name="nivel">
							<option value='0' <?php if($resposta['nivel'] == 0){echo"selected = selected";}?>>User Normal</option>
							<option value='1' <?php if($resposta['nivel'] == 1){echo"selected = selected";}?>>Admin Geral</option>
							<option value='2' <?php if($resposta['nivel'] == 2){echo"selected = selected";}?>>Sub-admin</option>
						</select>
							
			</td>
		</tr>
	<?php } ?>
	<tr>
		<td align="center" colspan="4">
			<input type="submit" name="op" id="op"	value="<?php echo $_GET['op']?>" />
	    </td>
	</tr>
</table>
</form>
</div>