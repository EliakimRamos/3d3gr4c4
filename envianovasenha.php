<?php session_start();
require_once("administrator/models/Base.php");
require_once("administrator/models/Cliente.php");
$objCliente = new Cliente();
$headers = 'From: atendimento@edegraca.com.br' . "\r\n" .
    								'Reply-To: atendimento@edegraca.com.br' . "\r\n" .
    								'X-Mailer: PHP/' . phpversion();
    								
if(!empty($_POST['emailcadastrado'])){ 
	$verificaemailcadastrado = $objCliente->getCliente($objCliente->anti_injection($_POST['emailcadastrado']),"email");
	
	if(!empty($verificaemailcadastrado)){
		echo $novasenhadocliente = substr(md5($_POST['emailcadastrado']."edegraca"),0,6);
		 $arraycliente['senha'] = substr(md5($novasenhadocliente),0,30);
		 
		$retornodaedicao = $objCliente->editarCliente($arraycliente,$verificaemailcadastrado['id']);
		if($retornodaedicao){
			if(mail($verificaemailcadastrado['email'],"Solicitação de nova senha","Sua nova senha é:".$novasenhadocliente,$headers)){
				$_SESSION['alert'] = "Sua nova senha foi enviada pra seu e-mai :".$verificaemailcadastrado['email'];
			}else{
				$_SESSION['alert'] = "Erro ao enviar o e-mail";
			}
		}
	}else{
		$_SESSION['alert'] = "E-mail não cadastrado";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php /*include('inc/header.php')*/ ?>
<title>É de Graça</title>
	<link rel="stylesheet" type="text/css" href="css/edegraga.css"/>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"	charset="iso-8859-1"></script>
	<script language="JavaScript" type="text/javascript"	src="js/jquery.validate.js"></script>
	<script language="JavaScript" type="text/javascript">
  		$(function(){
				// CONFIGURA A VALIDACAO DO FORMULARIO
				$("#novasenha").validate({
					rules: {
						
						email : {required: true, email: true}
						
					},
					messages: {
						
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				
				$("#btnenviarnovasenha").click(function(){
					$("#novasenha").submit();
				});
				
			});
	</script>					
  
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
	<div class="main">
		<div class="padding10">
			<span style="color: #FFFFFF; display: block; font-size: 12px; padding: 0 0 5px;">
				<?php  echo $_SESSION['alert']; $_SESSION['alert'] = "";?>
			</span>
  			<form action="envianovasenha.php" method="post" name="novasenha" id="novasenha">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  					<tr>
    					<td><legend style="color: #FFFFFF;">E-mail:</legend>
							<input tabindex="2" name="emailcadastrado" id="email" type="text" class="textfield"/> 
						</td>
  					</tr>
				</table>
  				<div class="btn-enviar2" id="btnenviarnovasenha"></div>
			</form>	
			
			<legend style="color: #FFFFFF;display: block;font-size: 12px;padding: 0 0 5px 30px;float:left;">
			Se voc&ecirc; n&atilde;o tem cadastro click <a style="color:#AAF026;text-decoration:none;" href="cadastro.php">Aqui</a> </legend>
  			
	    </div>
	</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>