<?php session_start();

if(!empty($_GET['tela'])){
	require_once("models/Base.php");
	require_once("models/Cliente.php");
	require_once('models/Login.php');
}else{
	require_once("../../models/Base.php");
	require_once("../../models/Cliente.php");
	require_once('../../models/Login.php');
	$_GET['op'] = "Inserir";
}

$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){

	header("location:../../entrar.php");
	
}


$cliente = new Cliente();
if($_GET['op'] == 'Editar'){
	$atualCliente = $cliente->getCliente($cliente->anti_injection($_GET['i']),'id');
}
if(!empty($_POST['nome'])){
	?>
<script>
 		$(function(){
 			$("#nome").val("<?php echo $cliente->anti_injection($_POST['nome'])?>");	
 		});
 		
 	</script>

	<?php
}
?>


<script>


$(document).ready(function(){
	   // CONFIGURA A VALIDACAO DO FORMULARIO
	   $("#formCliente").validate({
	      rules: {
		    nome : {required: true},
		    sexo: "required",
		   	cpf: {cpf: true},
			rg : {required: true, digits:true},
			cep : {required: true, digits:true, minlength: 8},
			estado : {required: true},
			cidade : {required: true},
			endereco : {required: true},
			bairro : {required: true},
			celular: {required: true},			
			fone : {required: true},
			email : {required: true, email: true},
			senha : {required: true} 	
	      },
	      messages: {
		     nome: {required: 'Campo Obrigatório'},
		     sexo: "Informe o Sexo",
		     cpf: {cpf: 'CPF inválido'},
		     rg: {required: 'Campo Obrigatório', digits: 'Digite apenas Números'},
		     cep: {required: 'Campo Obrigatório', digits: 'Digite apenas Números', minlength: 'Favor Informar o Cep com 8 Dígitos'},	         
		     estado: {required: 'Campo Obrigatório'},
	         cidade: {required: 'Campo Obrigatório'},
	         endereco: {required: 'Campo Obrigatório'},
	         bairro: {required: 'Campo Obrigatório'},
	         celular: {required: 'Campo Obrigatório'},	         
	         fone: {required: 'Campo Obrigatório'},
	         email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
	         senha: {required: 'Campo Obrigatório'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });
	   
		$("#fone").mask("(99) 9999-9999");
		$("#celular").mask("(99) 9999-9999");
		$("#cpf").mask("999.999.999-99");
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
});
	
</script>
<h3 class="titulo"><?php echo $_GET['op']." ". "Clientes";?></h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?></span>
<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formCliente" method="post" action="controllers/Cliente.php">
<table align="center">
	<tr>
		<td align="right">
			<input type="hidden" name="id"	value="<?php echo $atualCliente['id'];?>" /> 
			<input type="hidden" name="pac" value="cliente" /> 
			<input type="hidden" name="tela" value="cliente" /> 
			<input type="hidden" name="op" value="<?php echo $_GET['op'];?>" /> 
				<label class="label">Nome:*</label>
		</td>
		<td align="left"><input type="text" id="nome" name="nome"
			class="input" value="<?php echo $atualCliente['nome']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">CEP:*</label></td>
		<td align="left"><input type="text" id="cep" name="cep" maxlength="8"
			class="input" value="<?php echo $atualCliente['cep']?>" /></td>
		<td><label class="label">Estado:*</label></td>
		<td align="left"><input type="text" id="estado" name="estado"
			class="input" value="<?php echo $atualCliente['estado']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">Cidade:*</label></td>
		<td align="left"><input type="text" id="cidade" name="cidade"
			class="input" value="<?php echo $atualCliente['cidade']?>" /></td>
		<td><label class="label">Endereco:*</label></td>
		<td align="left"><input type="text" id="endereco" name="endereco"
			class="input" value="<?php echo $atualCliente['endereco']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">Bairro:*</label></td>
		<td align="left"><input type="text" id="bairro" name="bairro"
			class="input" value="<?php echo $atualCliente['bairro']?>" /></td>
		<td><label class="label">Complemento:</label></td>
		<td align="left"><input type="text" id="complemento"
			name="complemento" class="input"
			value="<?php echo $atualCliente['complemento']?>" /></td>
	</tr>

	<tr align="right">
		<td><label class="label">Celular:*</label></td>
		<td align="left"><input type="text" id="celular" name="celular"
			maxlength="14" class="input" value="<?php echo $atualCliente['celular']?>" />
		</td>
		<td colspan="2"> 
			<input type="checkbox" id="okcelular" name="sms" value="sim" checked="checked"> Desejo receber SMS das promoções em meu Celular
		</td>
	</tr>

	<tr align="right">
		<td><label class="label">E-mail:*</label></td>
		<td align="left"><input type="text" id="email" name="email"
			class="input" value="<?php echo $atualCliente['email']?>" /></td>
		<td colspan="2" align="left"> 
			<input type="checkbox" id="okmeio" name="newsletter" value="sim" checked="checked"> Desejo receber as Promoções no e-mail
		</td>
	</tr>
	<tr>	
		<td align="right"><label class="label">Senha:*</label></td>
		<td align="left"><input type="password" id="senha" name="senha"
			class="input" maxlength="30" value="<?php echo $atualCliente['senha']?>" /></td>
	</tr>
	<tr>
		<td align="center" colspan="4"><input type="submit" name="cadastrar"
			id="cadastrar" value="Cadastrar" /></td>
	</tr>
</table>
</form>

</div>
