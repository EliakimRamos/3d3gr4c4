<?php session_start();
require_once("administrator/models/Base.php");
require_once("administrator/models/Cliente.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="2;url=http://www.edegraca.com.br" />
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
						confemail:{required: true, email: true, equalTo:"#email"},
						senha : {required: true},
						confsenha : {required: true, equalTo: "#senha"},
						captcha : {required: true}
					},
					messages: {
						nome: {required: 'Campo Obrigatório'},
						email: {required: 'Campo Obrigatório', email: 'E-mail Inválido'},
						confemail: { required:"Campo Obrigatório", email: 'E-mail Inválido', equalTo:"Os E-mails tem que ser Identicos"},
						senha: {required: 'Campo Obrigatório'},
						confsenha: {required: 'Campo Obrigatório', equalTo: "As Senhas tem que ser Id&ecirc;nticas"},
						captcha: {required: 'Campo Obrigatório'}
					}
					,submitHandler:function(form) {
						form.submit();
					}
				});
				
				$("#btncadastrar").click(function(){
					$("#cadastro").submit();
				});
				
				$("#email").blur(function(){
					$.post("verificaemail.php",{email: $("#email").val()},
							function(date){
								
								if($.trim(date) != ""){
									$("#id").val(date);
									$("#op").val('Editar');
								}
							}
					);
				});
			});
  		
	</script>  
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div class="main">
<div class="padding10">
<h1 style="color: #FFFFFF; display: block;">
	Bem vindo, <span style="color:#a8cd00"><?php echo($_SESSION['alert']); ?> </span> você acaba de se cadastrar no melhor site de compra coletiva do Brasil. <span style="color:#a8cd00">Boas Compras!</span>
</h1>
  
</div>
</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>