<?php session_start();
$headers = 'From: '.$_POST['email'].'' . "\r\n" .
    								'Reply-To: '.$_POST['email'].'' . "\r\n" .
    								'X-Mailer: PHP/' . phpversion();

if(!empty($_POST)){
	$mensagemfaleconosco = "Nome :".$_POST['nome']."\n" .
						   "email:".$_POST['email']."\n" .
						   "Tipo de mensagem:".$_POST['tipo']."\n" .
						   "Mensagem:".$_POST['mensagem'];
	if(mail("falecom@edegraca.com.br","Fale conosco",$mensagemfaleconosco,$headers)){
		$_SESSION['alert']= "Enviado com sucesso";
	}else{
		$_SESSION['alert']="Erro ao enviar";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>&Eacute; de Gra&ccedil;a</title>
	<link rel="stylesheet" type="text/css" href="css/edegraga.css"/>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"	charset="iso-8859-1"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.readonly.js"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.maskedinput-1.1.2.pack.js"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.validate.js"></script>
	<script language="JavaScript" type="text/javascript">
  		$(document).ready(function(){
				// CONFIGURA A VALIDACAO DO FORMULARIO
				$("#cadastro").validate({
					rules: {
						nome : {required: true},
						email : {required: true, email: true},
						telefone:{required: true},
						tipo : {required: true},
						mensagem : {required: true}
					},
					messages: {
						nome: {required: 'Campo Obrigatório'},
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
						telefone: { required:"Campo Obrigatório"},
						tipo: {required: 'Campo Obrigatório'},
						mensagem: {required: 'Campo Obrigatório'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				
				$("#btncadastrar").click(function(){
					$("#cadastro").submit();
				});
				
			});
  		
	</script>  
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div class="main">
<div class="padding10">
<h1 style="color:#fff">FALE CONOSCO:<br />
  <br />
</h1>
<span style="color: #FFFFFF; display: block; font-size: 12px; padding: 0 0 5px;">
<?php echo $_SESSION['alert']; $_SESSION['alert']="";?> 
</span>
  <form action="faleconosco.php" method="post" name="formfaleconosco" id="cadastro">
  <input type="hidden" name="pac" value="cliente" /> 
  <input type="hidden" name="op" id="op" value="Inserir" /> 
  <input type="hidden" name="tela" value="cliente" />
  <input type="hidden" name="id" id="id" value="" />
  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  					<tbody><tr>
    					<td><legend>Nome:</legend>
							<input tabindex="1" name="nome" id="nome" type="text" class="textfield"> 
						</td>
    					<td>
    						<legend>E-mail:</legend>
							<input tabindex="2" name="email" id="email" type="text" class="textfield">
						</td>
  					</tr>
  					  <tr>
  					    <td><legend>Telefone:</legend>  					      
				        <input tabindex="1" name="telefone" id="telefone" type="text" class="textfield" /></td>
  					    <td>
  					      <legend>Tipo de mensagem:</legend>
				        <select name="Tipo" id="Tipo" class="selects">
				          <option value="Dúvida" selected="selected">Dúvida</option>
				          <option value="Crítica">Crítica</option>
				          <option value="Sugestão">Sugestão</option>
			            </select></td>
				      </tr>
  					  <tr>
  					    <td colspan="2"><label for="mensagem"></label>
				          <legend>Mensagem:</legend>
			            <textarea name="mensagem" cols="45" rows="5" class="textarea" id="mensagem"></textarea></td>
				      </tr>
		        </tbody>
</table>
  

<div class="btn-enviar" id="btncadastrar" style="margin:10px auto"><a href="#"></a></div>
</form>
</div>
</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>