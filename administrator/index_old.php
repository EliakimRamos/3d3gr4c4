<?php session_start();
require_once('models/Base.php');
require_once('models/Login.php');
$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){
	?>
		<script language="JavaScript" type="text/javascript">
  			window.location = 'entrar.php';
		</script>
  	<?php
	
	die;	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>&Eacute de gra&ccedil;a</title>
<link rel="stylesheet" type="text/css" media="screen" href="style/css_page.css" />
<link rel="stylesheet" type="text/css" media="screen" href="style/ui.tabs.css" />
<link type="text/css" href="style/galeria.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="style/jScrollPane.css" />
<link type="text/css" href="smoothness/jquery-ui-1.8.custom.css" rel="stylesheet" />
<link type="text/css" href="style/autocomplete.css" rel="stylesheet" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 

<!--<script language="JavaScript" type="text/javascript" src="js/jquery-1.4.4.min.js"></script>-->
<script language="JavaScript" type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.ui.core.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jScrollPane.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/Utils.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.livequery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.readonly.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput-1.1.2.pack.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>


<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/page.css" />
<link rel="stylesheet" type="text/css" media="all"	href="../js/tabela/table_jui.css" />

<script type="text/javascript" language="javascript" src="../js/tabela/jquery.dataTables.min.js"></script> 

<script language="JavaScript" type="text/javascript">
  $(function(){
  	
  	$("#logoff").click(function(){
  		if(confirm("Deseja Realmente Sair do Sistema?")){
  			window.location="logoff.php";
  			window.close();
  		}
  	});
  });
  
</script>

</head>
<body>
<div id="principal">
<div class="topo">
<div id="barra_logo">
<div id="logo">
	<a href="index.php">
		<img src="img/logo.png" width="163" height="58" border="none">
	</a>
</div>
<div id="usuario">Ol� <?php echo $_SESSION['nome'];?> - <a href="#"
	class="sair" id="logoff">SAIR</a></div>
</div>
<div id="menu">
<div id="menu_ordena">
<div id="menu_esq"></div>
<ul id="menu_drop">

	<li><a href="#">Cliente</a>
	<ul>
		<li><img class="corner_inset_left" alt=""
			src="img/corner_inset_left.png" /> <a
			href="?pac=cliente&tela=clienteGrid">Listar</a> <img
			class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
		</li>
		 <li><a	href="?pac=exportarEmail&tela=index">Email</a></li>
		 <li><a href="?pac=cliente&tela=clienteForm&op=Inserir">Cadastrar</a></li>
			<li class="last"><img class="corner_left" alt=""
				src="img/corner_left.png" /> <img class="middle" alt=""
				src="img/dot.gif" /> <img class="corner_right" alt=""
				src="img/corner_right.png" /></li>
		
	</ul>
	</li>

	<li><a href="#">Administrador</a>
	<ul>
		<li><img class="corner_inset_left" alt=""
			src="img/corner_inset_left.png" /> <a
			href="?pac=admin&tela=adminGrid">Listar</a> <img
			class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
		</li>
		<li><a href="?pac=admin&tela=adminForm&op=Inserir">Cadastrar</a></li>
		<li class="last"><img class="corner_left" alt=""
			src="img/corner_left.png" /> <img class="middle" alt=""
			src="img/dot.gif" /> <img class="corner_right" alt=""
			src="img/corner_right.png" /></li>
	</ul>
	</li>
	
	<li><a href="#">Comercial</a>
	<ul>
		<li><img class="corner_inset_left" alt=""
			src="img/corner_inset_left.png" /> <a
			href="?pac=comercial&tela=comercialGrid">Listar</a> <img
			class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
		</li>
		<li><a href="?pac=comercial&tela=comercialForm&op=Inserir">Cadastrar</a></li>
		<li class="last"><img class="corner_left" alt=""
			src="img/corner_left.png" /> <img class="middle" alt=""
			src="img/dot.gif" /> <img class="corner_right" alt=""
			src="img/corner_right.png" /></li>
	</ul>
	</li>

	<li><a href="#">Empresa</a>
	<ul>
		<li>
			<img class="corner_inset_left" alt="" src="img/corner_inset_left.png" /> 
			<a href="?pac=empresa&tela=empresaGrid">Listar</a> 
			<img class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
		</li>
		<li>
			<a href="?pac=empresa&tela=empresaForm&op=Inserir">Cadastrar</a>
		</li>
		<li class="last">
			<img class="corner_left" alt=""	src="img/corner_left.png" /> 
			<img class="middle" alt="" src="img/dot.gif" />
			<img class="corner_right" alt="" src="img/corner_right.png" />
		</li>
	</ul>
	</li>

	<li><a href="#">Ofertas</a>
	<ul>
		<li><img class="corner_inset_left" alt=""
			src="img/corner_inset_left.png" /> <a
			href="?pac=oferta&tela=ofertaGrid">Listar</a> <img
			class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
		</li>
		<li><a href="?pac=oferta&tela=ofertaForm&op=Inserir">Cadastrar</a></li>
		<li><a href="?pac=oferta&tela=Agendar">Agendar</a></li>
		<li class="last"><img class="corner_left" alt=""
			src="img/corner_left.png" /> <img class="middle" alt=""
			src="img/dot.gif" /> <img class="corner_right" alt=""
			src="img/corner_right.png" /></li>
	</ul>
	</li>
	
	<li><a href="#">Compradores</a>
		<ul>
			<li>
				<img class="corner_inset_left" alt="" src="img/corner_inset_left.png" /> 
					<a href="?pac=vendas&tela=promocoes">Listar</a> 
				<img class="corner_inset_right" alt="" src="img/corner_inset_right.png"/>
			</li>		
			<li class="last">
				<img class="corner_left" alt="" src="img/corner_left.png" /> 
				<img class="middle" alt="" src="img/dot.gif" /> 
				<img class="corner_right" alt="" src="img/corner_right.png" />
			</li>
		</ul>
	</li>
	<?php if($_SESSION['id'] == 11 || $_SESSION['id'] == 10 || $_SESSION['id'] == 3){?>	
		<li><a href="#">Relat�rios</a>
			<ul>
				<li>
					<img class="corner_inset_left" alt="" src="img/corner_inset_left.png" />
						<a href="?pac=relatorio&tela=relatorioGrid">Compras</a> 
					<img class="corner_inset_right" alt="" src="img/corner_inset_right.png" />
				</li>
			
					<li><a href="?pac=relatorio&tela=relatorioFinanceiro">Financeiro</a></li>
					<li><a href="?pac=relatorio&tela=checkvalor">Fraude</a></li>
					<li><a href="?pac=relatorio&tela=comissao">Comiss�o</a></li>
								
				<!-- 
					<li><a href="?pac=contapagar&tela=contapagarGrid">Contas Pagar</a></li>
					<li><a href="?pac=contareceber&tela=contareceberForm">Contas Receber</a></li>				
					<li><a href="?pac=relatorio&tela=identificarcomprador">Cupom</a></li>
					<li><a href="?pac=relatorio&tela=quatidadePagseguro">qtd Pagseguro</a></li>
				 -->
				<li class="last">
					<img class="corner_left" alt=""	src="img/corner_left.png" /> 
					<img class="middle" alt="" src="img/dot.gif" />
					<img class="corner_right" alt="" src="img/corner_right.png" />
				</li>
			</ul>
		</li>	
	<?php }?>

</ul>
<div id="menu_dir">&nbsp;</div>
</div>
</div>
</div>

<div id="conteudo"><?php
$pacote = $login->anti_injection(@$_GET['pac']);
$tela = $login->anti_injection(@$_GET['tela']);
if ( empty($pacote)) {

	?>
<div class="corpo">
<div id="alinha_titulo_agenda">
	<?php if($_SESSION['nivel'] == "3"){
			
			
	}else{ ?>

<div id="linha_alinha">
<table cellpadding="50" cellspacing="50" align="center">
	<tr>		
		<?php /*if($_SESSION['id'] == 11 || $_SESSION['id'] == 10 || $_SESSION['id'] == 3 || $_SESSION['id'] == 2){*/?>
			<td>
				<a href="?pac=relatorio&tela=relatorioGrid">
					<img src="img/relatorios.png" border="0" title="Relat�rio Compra" alt="Relat�rio Compra"/> 
				</a>		
			</td>
			
			
			<td>
				<a href="?pac=relatorio&tela=relatorioFinanceiro">
					<img src="img/financeiro.png" border="0" title="Relat�rio Financeiro" alt="Relat�rio Financeiro" /> 
				</a>
			</td>
		<?php /*}*/?>
		
		<td>
			<a href="?pac=oferta&tela=ofertaGrid">
				<img src="img/oferta.png" border="0" title="Registrar Oferta" alt="Registrar Oferta" /> 
			</a>
		</td>
		<td>
			<a href="?pac=admin&tela=adminGrid">
				<img src="img/usuario.png" border="0" title="Registrar Administradores" alt="Registrar Administradores"/>
			</a>
		</td>		
		<td>
			<a href="?pac=empresa&tela=empresaGrid">
				<img src="img/parceiros.png" border="0" title="Registrar Empresa" alt="Registrar Empresa" /> 
			</a>
		</td>		
	</tr>
</table>
</div>
</div>

</div>
	<?php
	}
}
else {

	if (file_exists("view/".$pacote."/".$tela.".php")) {
		include "view/".$pacote."/".$tela.".php";
	}//if
}//else

?></div>
<div id="rodape">
<div id="menu_rodape">&Eacute de gra&ccedil;a</div>
</div>
</div>
</body>
</html>