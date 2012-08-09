<?php session_start();
require_once("../administrator/models/Base.php");
require_once("../administrator/models/Empresa.php");

$empresa = new Empresa();
$resposta = $empresa->getEmpresa($empresa->anti_injection($_GET['id']), "id");
?>

<html>
<head>

<link href="../sis/style.css" rel="stylesheet" type="text/css" />
<script language="Javascript" type="text/javascript" src="../administrator/js/jquery-1.4.2.min.js"></script>
<script language="Javascript" type="text/javascript" src="../administrator/js/jquery.validate.js"></script>
<script language="Javascript" type="text/javascript" src="../administrator/js/jquery.maskedinput-1.1.2.pack.js"></script>


<!--  jquery -->
<script language="javascript" type="text/javascript">
$(document).ready(function(){ 
	   $("#formEmpresa").validate({
	      rules: {
		    nome : {required: true},		   	
			cep : {required: true, digits:true, minlength: 8},
			estado : {required: true},
			cidade : {required: true},
			endereco : {required: true},
			bairro : {required: true},			
			num: {required: true},			
			fone : {required: true},
			senha : {required: true},
			email : {required: true, email: true},
			descricao : {required: true} 	
	      },
	      messages: {
		     nome: {required: 'Campo Obrigat�rio'},
		     cep: {required: 'Campo Obrigat�rio', digits: 'Digite apenas N�meros', minlength: 'Favor Informar o Cep com 8 D�gitos'},	         
		     estado: {required: 'Campo Obrigat�rio'},
	         cidade: {required: 'Campo Obrigat�rio'},
	         endereco: {required: 'Campo Obrigat�rio'},
	         bairro: {required: 'Campo Obrigat�rio'},	         
	         num: {required: 'Campo Obrigat�rio'},	         
	         fone: {required: 'Campo Obrigat�rio'},	         
	         senha: {required: 'Campo Obrigat�rio'},	         
	         email: {required: 'Campo Obrigat�rio', email: 'E-mail Inv�lido'},	         
	         descricao: {required: 'Campo Obrigat�rio'}
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });
		$("#fone").mask("(99) 9999-9999");		
		$("#cnpj").mask("99.999.999/9999-99");
	});

$(function () {	
	$("#cep").keyup(function(){
		var cep = $("#cep").val();
		
		if(cep.length == 8){
			$.post("../sis/view/vercep.php",{
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
</head>
<body>
<h3 class="titulo"> Editar Informa��es </h3>
<div class="corpo"><span class="mensagem" id="mensagem"> <?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = "";}?>
</span>
<div id='buscarcep' style="display: none"></div>
<form class="form_login" id="formEmpresa" method="post"	action="../sis/controllers/Empresa.php">
<table align="center">
	<tr>
		<td align="right">
			<input type="hidden" name="id" value="<?php echo $resposta['id'];?>" />
			<input type="hidden" name="pac" value="empresa" /> 
			<input type="hidden" name="tela" value="empresa" /> 
			<label class="label">Nome:*</label>
		</td>
		<td align="left">
			<input type="text" id="nome" name="nome" class="input" value="<?php echo $resposta['nome']?>" />
		</td>
		<td align="right"><label class="label">CNPJ:*</label></td>
		<td align="left" colspan="3"><input type="text" id="cnpj" name="cnpj" maxlength="20"
			class="input" value="<?php echo $resposta['cnpj']?>" readonly="readonly" />
		</td>	
	</tr>

	<tr>
		<td align="right"><label class="label">CEP:*</label></td>
		<td align="left">
			<input type="text" id="cep" name="cep" maxlength="8" class="input" value="<?php echo $resposta['cep']?>" />
		</td>
		<td align="right"><label class="label">Estado:*</label></td>
		<td align="left">
			<input type="text" id="estado" name="estado" class="input" value="<?php echo $resposta['estado']?>" />
		</td>		
	</tr>

	<tr align="right">
		<td>
			<label class="label">Cidade:*</label>
		</td>
		<td align="left">
			<input type="text" id="cidade" name="cidade" class="input" value="<?php echo $resposta['cidade']?>" />
		</td>
		<td>
			<label class="label">Endereco:*</label>
		</td>
		<td align="left">
			<input type="text" id="endereco" name="endereco" class="input" value="<?php echo $resposta['endereco']?>" />
		</td>
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
		<td><label class="label">N�mero:*</label></td>
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
			<input type="submit" name="op" id="op"	value="Editar" />
	    </td>
	</tr>
</table>
</form>
</div>
</body>
</html>