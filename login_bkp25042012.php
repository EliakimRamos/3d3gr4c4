<?php session_start();?>
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
				$("#cadastro").validate({
					rules: {
						
						email : {required: true, email: true},
						
						senha : {required: true}
					},
					messages: {
						
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
						
						senha: {required: 'Campo Obrigatório'}
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
			<span style="color: #FFFFFF; display: block; font-size: 12px; padding: 0 0 5px;">
				<?php  echo $_SESSION['alert']; $_SESSION['alert'] = "";?>
			</span>
  			<form action="logar.php" method="post" name="cadastro" id="cadastro">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  					<tr>
    					<td><legend>E-mail:</legend>
							<input tabindex="2" name="email" id="email" type="text" class="textfield"/> 
						</td>
    					<td>
    						<legend>Senha:</legend>
							<input tabindex="4" name="senha" id="senha" type="password" class="textfield"/>
						</td>
  					</tr>
				</table>
  				<div class="btn-enviar2" id="btncadastrar"></div>
			</form>	
			<legend style="color: #FFFFFF;display: block;font-size: 12px;padding: 0 0 5px;">
			Se voc&ecirc; n&atilde;o tem cadastro click <a style="color:#AAF026;text-decoration:none;" href="cadastro.php">Aqui</a> </legend>
  			
	    </div>
	</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>