<?php

session_start();
require_once("models/Base.php");
require_once("models/Contapagar.php");
require_once("models/Login.php");

$login = new Login();
$login->conectar();
$confirmacao = $login->verificar();
if($confirmacao == false){
	?>
<script language="JavaScript" type="text/javascript">
	window.location="./entrar.php";
</script>

	<?php
}
$qtd_parcela = "";
$contapagar = new Contapagar();

if($_GET['op']== 'Editar'){
	$resposta = $contapagar->getContapagar($contapagar->anti_injection($_GET['i']),'id_contapagar');
}


?>

<script type="text/javascript">
	function voltarContapagar(){
		window.location = "?pac=contapagar&tela=contapagarGrid";
	}
	
	$(document).ready(function(){
		$("#valor").maskMoney({symbol:"R$",decimal:",",thousands:""});
		$("#formapg").attr("disabled", "disabled");
        
	   // CONFIGURA A VALIDACAO DO FORMULARIO
	   $("#formContapagar").validate({
	      rules: {		    
		    beneficiado : {required: true},
		    valor : {required: true},	   	
			datepicker : {required: true},   	
			datepicker2 : {required: true}
	      },
	      messages: {
			beneficiado : {required: 'Campo Obrigatório'},
			valor : {required: 'Campo Obrigatório'},	   	
			datepicker : {required: 'Campo Obrigatório'},   	
			datepicker2 : {required: 'Campo Obrigatório'}   	
	      }
	      ,submitHandler:function(form) {
	    	  form.submit();		      
	      }
	   });	   
	});
	
	$(function(){ 
		$(".datepicker").datepicker({
			 showButtonPanel: true
		}); 
	});	
</script>


<h3 class="titulo">
	<?php echo $_GET['op']." "."Conta a pagar";?>
</h3>
<div class="corpo">
	<span class="mensagem" id="mensagem"> 
	<?php if($_SESSION['alert'] != ""){echo $_SESSION['alert']; $_SESSION['alert'] = ""; ?>
		<script type="text/javascript">window.setTimeout("voltarContapagar()",1500);</script>
	<?php }?></span>
	
<form class="form_login" id="formContapagar" method="post" action="controllers/contapagar.php">
	<input type="hidden" name="id_contapagar" value="<?php echo $resposta['id_contapagar'];?>" />
	<input type="hidden" name="pacote" value="<?php echo $_GET['pac'];?>" />
	<input type="hidden" name="tela" value="contapagar" />
	<input type="hidden" name="op" value="<?php echo $_GET['op']?>" /> 
<table align="center" class="tabela_form">	
	<tr>
		<td align="right"><label class="label">Beneficiado:</label></td>
		<td align="left"><input type="text" name="beneficiado"
			id="beneficiado" class="input"
			value="<?php echo $resposta['beneficiado']?>" /></td>
		<td align="right"><label class="label">Valor:</label></td>
		<td align="left"><input type="text" name="valor" id="valor"
			class="input"
			value="<?php echo number_format($resposta['valor'],2,',','.');?>" />
		</td>

	</tr>

	<tr id="datas">
		<td align="right"><label class="label">Data de emissão:</label></td>
		<td align="left">
			<input type="text" name="emissao" class="input datepicker" readonly="readonly"
			value="<?php echo $contapagar->date_transform($resposta['emissao']);?>" />
		</td>
		<td id="lab_vencimento" align="right"><label class="label">Data de
		Vencimento:</label></td>
		<td align="left">
			<input type="text" name="vencimento"  class="input datepicker" readonly="readonly" value="<?php echo $contapagar->date_transform($resposta['vencimento']);?>" />
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<input type="submit" name="op" id="op"	value="<?php echo $_GET['op']?>" /> 
			<input type="button" name="voltar" id="voltar" value="Voltar" onClick="javaScript:voltarContapagar();" />
		</td>
	</tr>
</table>
</form>

</div>
</body>
</html>

