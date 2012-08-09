<?php
session_start();
require_once ("../sis/models/Base.php");
?>

<html>
<head>
<title>Pechincha - Identificação</title>
<?php if(!$_SESSION['empresa']){ ?>
<link rel="stylesheet" type="text/css" media="screen" href="../sis/style/css_page.css" />
 <?php }else{?>
<link rel="stylesheet" type="text/css" media="screen"
	href="../sis/style/css_page.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="../sis/style/ui.tabs.css" />
<link type="text/css" href="../sis/style/galeria.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="../sis/style/jScrollPane.css" />
<link type="text/css" href="../sis/smoothness/jquery-ui-1.8.custom.css" rel="stylesheet" />
<link type="text/css" href="../sis/style/autocomplete.css" rel="stylesheet" />
<script type="text/javascript" src="../sis/js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.bgiframe.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.ui.core.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.ui.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="../sis/js/jScrollPane.js"></script>
<script type="text/javascript" src="../sis/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="../sis/js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../sis/js/Utils.js"></script>
<script type="text/javascript" src="../sis/js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" src="../sis/js/jquery.ui.datepicker-pt-BR.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.maskMoney.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.livequery.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.bgiframe.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.autocomplete.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.readonly.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.maskedinput-1.1.2.pack.js"></script>
<script language="JavaScript" type="text/javascript" src="../sis/js/jquery.validate.js"></script>
 	
 <?php }?>	
</head>
		<?php if(!$_SESSION['empresa']){ ?>
		<body id="body_login">
		<div class="login">
			<div id="formlogin">
					<span class="mensagem" id="mensagem">
						<?php

if ($_SESSION['alert'] != "") {
	echo $_SESSION['alert'];
	$_SESSION['alert'] = "";
}
?>		
					</span>
					
				  <form method="post" action="../sis/controllers/Parceiros.php" class="form_login" id="form_login">
				   		<label class="label">E-mail :</label><br>
				   		<input type="text" id="email" name="email" class="input" />
				   		<br>
				   		<label class="label">Senha :</label><br>
				   		<input type="password" name="senha" id="senha" class="input"/>
				  		<input type="submit" name="logar" id="btnLogar" value="Entrar" class="botao"/>
				  </form> 
			</div>
			</div>
		</body>
		<?php }else{?>
		<body >
			<div id="principal">
			<div class="topo">
			<div id="barra_logo">
			<div id="logo">
				<a href="index.php">
					<img src="../sis/img/logo.png" width="163" height="58" border="none">
				</a>
			</div>
			<div id="usuario">Olá <?php echo $_SESSION['nome'];?> - <a href="sair.php"
				class="sair" id="logoff">SAIR</a></div>
			</div>
			<div id="menu">
			<div id="menu_ordena">
			<div id="menu_esq"></div>
			<ul id="menu_drop" style="width:300px">				
				<li>
					<a href="?p=promocoes">Promoções</a>
				</li>	
				<li>
					<a href="?p=editar&id=<?php echo $_SESSION['id'] ?>">Meus dados</a>
				</li>
			</ul>
			<div id="menu_dir">&nbsp;</div>
			</div>
			</div>
			</div>
			<div id="conteudo">	
				<div class="corpo">
				 <?php if(!empty($_GET['p'])){
				 		if (file_exists($_GET['p'].".php")) {
								include $_GET['p'].".php";
						}
				 }else{
				 	include("promocoes.php");
				 }
				?>
				</div>
			</div>
			<div id="rodape">
			<div id="menu_rodape">Pechincha da Vez</div>
			</div>
			</div>
		</body>
		<?php }?>
</html>
