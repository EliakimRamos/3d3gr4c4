<?php
 session_start();
 require_once("models/Base.php");
?>

<html>
<head>
<title>È de Graça - Identificação</title>
<link rel="stylesheet" type="text/css" media="screen" href="style/css_page.css" />
<script type="text/javascript" src="js/jquery-1.2.6.js"></script>
<script language="JavaScript" type="text/javascript">
  $(function(){
  		$("#form_login").submit(function(){
  			login = $("#email").val();
  			senha = $("#senha").val();
  			if(jQuery.trim(senha) == "" || jQuery.trim(login)==""){
  				$("#mensagem").html("Preencha todos os campos!");
  				return false;
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
   		<label class="label">E-mail :</label><br>
   		<input type="text" id="email" name="email" class="input" />
   		<br>
   		<label class="label">Senha :</label><br>
   		<input type="password" name="senha" id="senha" class="input"/>
  		<input type="submit" name="logar" id="btnLogar" value="Entrar" class="botao"/>
  </form> <br>
  
</div>
</div>
</body>
</html>
