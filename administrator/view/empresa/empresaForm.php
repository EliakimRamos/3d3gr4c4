<?php session_start();

if(!empty($_GET['tela'])){
	require_once("models/Base.php");
	require_once("models/Empresa.php");
	require_once('models/Login.php');
}else{
	require_once("../../models/Base.php");
	require_once("../../models/Empresa.php");
	require_once('../../models/Login.php');
	$_GET['op'] = "Inserir";
}

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
	
}

$empresa = new Empresa();
if($_GET['op'] == 'Editar'){
	$resposta = $empresa->getEmpresa($empresa->anti_injection($_GET['i']), "id");
	$_SESSION['idempresa'] = $resposta['id'];
}
if(!empty($_POST['nome'])){
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
	   $("#formEmpresa").validate({
	      rules: {
		    nome : {required: true},
		    cnpj: {remote: 'view/empresa/cnpjEmpresa.php'},		   	
			fone : {required: true},
			senha : {required: true},
			email : {required: true, email: true},
			mapa : {required: true},
			descricao : {required: true} 	
	      },
	      messages: {
		     nome: {required: 'Campo Obrigatório'},
		     cnpj:{remote: 'CPNJ já está em uso'}, 
	         fone: {required: 'Campo Obrigatório'},	         
	         senha: {required: 'Campo Obrigatório'},	         
	         mapa: {required: 'Campo Obrigatório'},	         
	         email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},	         
	         descricao: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });
		$("#fone").mask("(99) 9999-9999");		
		$("#cnpj").mask("99.999.999/9999-99");
		$("#cpftxt").mask("999.999.999-99");
		
	});

$(function () {	
	$("#cep").keyup(function(){
		var cep = $("#cep").val();
		
		if(cep.length == 8){
			$.post("view/vercep.php",{
					cep : cep
					},
		 		function(data){
					$("#buscarcep").html(data);		
		 			$("#estado").val($("#estado1").val());
		 			$("#cidade").val($("#cidade1").val());
		 			$("#bairro").val($("#bairro1").val());
		 			$("#endereco").val($("#endereco1").val());
		 			$("#buscarcep").html("");
		 		});
		}
	});
	$("#cpf").click(function(){
		$("#cpftxt").show();
		$("#cnpj").hide();
	});
	$("#cnpjr").click(function(){
		$("#cpftxt").hide();
		$("#cnpj").show();
	});
	
});
	
</script>
<h3 class="titulo"><?php echo $_GET['op']." ". "Empresa";?></h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?>
</span>
<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formEmpresa" method="post"	action="controllers/Empresa.php">

  cnpj<input type="radio" name="documento" checked="checked" id="cnpjr" value="cnpj"/>
  cpf<input type="radio" name="documento"  id="cpf" value="cpf"/>
  
  
<table align="center">
	<tr>
		<td align="right">
			<input type="hidden" name="id"	value="<?php echo $resposta['id'];?>" />
			<input type="hidden" name="pac" value="empresa" /> 
			<input type="hidden" name="tela" value="empresa" /> 
			<label class="label">Nome:*</label>
		</td>
		<td align="left">
			<input type="text" id="nome" name="nome" class="input" value="<?php echo $resposta['nome']?>" />
		</td>
		<td align="right"><label class="label">CNPJ / CPF:*</label></td>
		<td align="left" colspan="3"><input type="text" id="cnpj" name="cnpj" maxlength="20"
			class="input" value="<?php echo $resposta['cnpj']?>" />
			<input type="text" id="cpftxt" name="cnpj" maxlength="20"
			class="input" style="display:none;" value="<?php echo $resposta['cnpj']?>" />
			
		</td>	
	</tr>
   <tr>
   		<td>
   			<label class="label">Nome Fantasia:</label>
   		</td>
   		<td align="left">
			<input type="text" id="nome_fantasia" name="nome_fantasia" class="input" value="<?php echo $resposta['nome_fantasia']?>" />
		</td>
   		
   </tr>
	<tr>
		<td align="right"><label class="label">CEP:*</label></td>
		<td align="left"><input type="text" id="cep" name="cep" maxlength="8" class="input"
			value="<?php echo $resposta['cep']?>" /></td>
		<td align="right"><label class="label">Estado:*</label></td>
		<td align="left"><input type="text" id="estado" name="estado"
			class="input" value="<?php echo $resposta['estado']?>" /></td>		
	</tr>

	<tr align="right">
		<td><label class="label">Cidade:*</label></td>
		<td align="left"><input type="text" id="cidade" name="cidade"
			class="input" value="<?php echo $resposta['cidade']?>" /></td>
		<td><label class="label">Endereco:*</label></td>
		<td align="left"><input type="text" id="endereco" name="endereco"
			class="input" value="<?php echo $resposta['endereco']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">Bairro:*</label></td>
		<td align="left"><input type="text" id="bairro" name="bairro"
			class="input" value="<?php echo $resposta['bairro']?>" /></td>
		<td><label class="label">Complemento:</label></td>
		<td align="left"><input type="text" id="complemento"
			name="complemento" class="input"
			value="<?php echo $resposta['complemento']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">Número:*</label></td>
		<td align="left">
			<input type="text" id="num" name="num" class="input" value="<?php echo $resposta['num']?>" />
		</td>
		<td><label class="label">Fone:*</label></td>
		<td align="left">
			<input type="text" id="fone" name="fone" maxlength="14" class="input" value="<?php echo $resposta['fone']?>" />
		</td>
	</tr>

	<tr align="right">
		<td><label class="label">E-mail:*</label></td>
		<td align="left">
			<input type="text" id="email" name="email"  class="input" value="<?php echo $resposta['email']?>" />
		</td>
		<td><label class="label">Senha:*</label></td>
		<td align="left">
			<input type="password" id="senha" name="senha" class="input" value="<?php echo $resposta['senha']?>" />
		</td>
	</tr>
	<tr align="right">
	  <td><label class="label">Latitude:</label></td>
	  <td align="left"><input type="text" id="latitude" name="latitude" class="input" value="<?php echo $resposta['latitude']?>" /></td>
	  <td><label class="label">Longitude:</label></td>
	  <td align="left"><input type="text" id="longitude" name="longitude" class="input" value="<?php echo $resposta['longitude']?>" /></td>
	 </tr>
	 
	 <tr>
	 	<td><label class="label">Mapa:</label></td>
	 	<td align="left" colspan="3">
	 		<input type="text" id="mapa" name="mapa" class="input" style="width: 451px;" value="<?php echo $resposta['mapa']?>" />
	 	</td>
	 </tr>
	 <tr>
	 	<td><label class="label">Site:</label></td>
	 	<td align="left" colspan="3">
	 		<input type="text" id="site" name="site" class="input" style="width: 451px;" value="<?php echo $resposta['site']?>" />
	 	</td>
	 </tr>

	<tr align="right">
		<td>
			<label class="label">Descricao:*</label>
		</td>
		<td align="left" colspan="3">
			<textarea rows="10" cols="59" id="descricao" name="descricao"><?php echo ltrim($resposta['descricao'])?></textarea>			
		</td>
		
	</tr>
	<tr>
		<td align="center" colspan="4">
			<input type="submit" name="op" id="op"	value="<?php echo $_GET['op']?>" />
	    </td>
	</tr>
</table>
</form>
</div>