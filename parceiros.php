
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>É de Graça</title>
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
						confsenha: {required: 'Campo Obrigatório', equalTo: "As Senhas tem que ser Idênticas"},
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
							function(data){
								$("#op").val('Editar');
							}
					);
				});
			});
  		
	</script>
   <script language="JavaScript" type="text/javascript">
						<?php 
								$timestamp1 = mktime("0","0","0","04","03","2012");
								$timestamp2 = mktime(date('H'),date("i"),date('s'),date('m'),date("d"),date('Y'));
								$resultado = $timestamp1 - $timestamp2;
								
						?>
						var numTicks = 0;
						var secondsTil = <?php echo $resultado;?>
						
						var intervalid = startClock();

						function startClock() {
							return setInterval(tick, 1000);
						}
						
						function tick() {
							var seconds = secondsTil--;
							if (seconds < 0) {
								seconds = 0;
							}
							var dias = Math.floor(seconds /86400);
							
							var hours = Math.floor(seconds / 3600) - (dias * 24);
							seconds -= Math.floor(seconds / 3600) * 3600;
							var minutes = Math.floor(seconds / 60);
							seconds -= minutes * 60;

							var StrTime = dias.toString();
							if(dias < 10)
							{
								StrTime = "0"+ StrTime;
							}
							document.getElementById("dias").innerHTML = StrTime;
							

							var StrTime = hours.toString();
							if(hours < 10)
							{
								StrTime = "0"+ StrTime;
							}
							document.getElementById("horas").innerHTML = StrTime;
							StrTime = minutes.toString();
							if(minutes < 10)
							{
								StrTime = "0"+ StrTime;
							}
							 document.getElementById("minutos").innerHTML = StrTime;
							
							StrTime = seconds.toString();
							if(seconds < 10)
							{
								StrTime = "0"+ StrTime;
							}
							 document.getElementById("segundos").innerHTML = StrTime;        
						 
							if (numTicks++ > 500 || secondsTil == 0) {
								if (window.location.href.lastIndexOf('?') > -1) {
									window.location.href = window.location.href;
									clearInterval(intervalid);
								} else {
									window.location.href = window.location.href;
									clearInterval(intervalid);
								}
							}
						}
					</script>
  <?php include('inc/header.php') ?>
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div class="main">
<div class="padding10">
<span style="color: #FFFFFF; display: block; font-size: 12px; padding: 0 0 5px;">
	<?php echo $_SESSION['alert']; $_SESSION['alert'] = "";?>
</span>
<h2>Seja nosso parceiro Conheça os Benefícios:</h2>
<span class="textobranco">

<ul class="ul-lista-comum">
  <li>Faça novos clientes para o seu negócio.</li>
  <li>Ampla visibilidade.</li>
  <li>Investimento zero.</li>
  <li>Avaliação de Resultados.</li>
  <li>Publicidade e Marketing nas redes sociais.</li>
</ul>
</span><br />
<h3 class="h3">Preencha o Formulário abaixo que entraremos em contato.<br />
  <br />
</h3>
<form action="sis/controllers/Cliente.php" method="post" name="cadastro" id="cadastro">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><legend>Nome:</legend>
<input tabindex="2" name="nome" id="nome" type="text" class="textfield"/> </td>
    <td><legend>Email:</legend>
<input tabindex="4" name="email" id="email" type="textfield" class="textfield"/></td>
  </tr>
  <tr>
    <td><legend>Empresa:</legend>
<input tabindex="2" name="empresa" id="empresa" type="text" class="textfield"/> </td>
    <td><legend>Área de Atuação:</legend>
<input tabindex="2" name="area" id="area" type="text" class="textfield"/> </td>
  </tr>
  <tr>
    <td><legend>Telefone:</legend>
<input tabindex="2" name="telefone" id="telefone" type="text" class="textfield"/></td>
    <td><legend>Celular:</legend>
<input tabindex="2" name="celular" id="celular" type="text" class="textfield"/></td>
  </tr>
  <tr>
    <td colspan="2"><legend>Mensagem:</legend><textarea name="textarea" cols="45" rows="5" class="textarea" id="textarea"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  <div class="btn-enviar2" id="btncadastrar"></div>
</form>
					
	</div>


</div>
</div>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 



</body>
</html>