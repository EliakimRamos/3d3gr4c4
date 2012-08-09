<?php
 session_start();
 require_once("models/Base.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">	
<html>

<head>
<title>&Eacute; de Gra&ccedil;a - Identifica&ccedil;&atilde;o</title>

<link rel="stylesheet" type="text/css" href="style/edegraca-sis.css">
<script type="text/javascript" src="js/jquery-1.2.6.js"></script>
<script language="JavaScript" type="text/javascript">
  $(function(){
  		
  		
  		$("#btnLogar").click(function(){
  				login = $("#email").val();
	  			senha = $("#senha").val();
	  			if(jQuery.trim(senha) == "" || jQuery.trim(login)==""){
	  				$("#mensagem").html("Preencha todos os campos!");
	  				return false;
	  			}
  			$("#form_login").submit();
  		});
  		
  		$("#formlogin").keypress(function(e){

  			if(e.which == 13){
  				login = $("#email").val();
	  			senha = $("#senha").val();
	  			if(jQuery.trim(senha) == "" || jQuery.trim(login)==""){
	  				$("#mensagem").html("Preencha todos os campos!");
	  				return false;
	  			}
  				$("#form_login").submit();
  			}
  		});
  	
  });
</script>
  
</head>
<body id="body_login">
<div class="login">
<div id="formlogin">
	<span class="mensagem" id="mensagem">
			<?php if($_SESSION['alert']!= ""){
						echo $_SESSION['alert'];
						$_SESSION['alert'] ="";	
				}?>			
	</span>
  <form method="post" action="controllers/Validar.php" class="form_login" id="form_login">
   		<label class="label-entrar">E-mail:</label><br>  
   		<input type="text" id="email" name="email" class="input" />
   		<br>
   		<label class="label-entrar">Senha :</label><br>
   		<input type="password" name="senha" id="senha" class="input"/>
  		<br>
  		<div id="btnLogar"></div>
  </form> <br>
  
</div>
</div>
</body>
</html>
