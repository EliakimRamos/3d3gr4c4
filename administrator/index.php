<?php session_start();
require_once('models/Base.php');
require_once('models/Login.php');
$login = new Login();
$confirmacao = $login->verificar();
if($confirmacao == false){?>
<script language="JavaScript" type="text/javascript">window.location = 'entrar.php';</script>
<?php	die;	} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>&Eacute de gra&ccedil;a - Administrativo</title>
<link rel="stylesheet" type="text/css" href="style/edegraca-sis.css"/>
<!--<link rel="stylesheet" type="text/css" media="screen" href="style/css_page.css" />-->
<link rel="stylesheet" type="text/css" media="screen" href="style/ui.tabs.css" />
<link type="text/css" href="style/galeria.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="style/jScrollPane.css" />
<link type="text/css" href="smoothness/jquery-ui-1.8.custom.css" rel="stylesheet" />
<link type="text/css" href="style/autocomplete.css" rel="stylesheet" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
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
  	$("#btn-sair").click(function(){
  		if(confirm("Deseja Realmente Sair do Sistema?")){
  			window.location="logoff.php";
  			window.close();
  		}
  	});
  	$("#logo").css("cursor","pointer");
  	$("#logo").click(function(){
  		window.location="index.php";
  	})
  });  
</script>
</head>
<body>
<div id="topo"><div class="wrap">
<div id="logo"></div>
<div id="topo-login">
<span> <strong>Ol&aacute;!<?php echo" ".$_SESSION['nomeAdmin'];?></strong></span><div id="btn-sair"><a href="#"></a></div>
</div>
</div>
</div> <!--fim div topo-->
<div id="menucontainer">
<div id="menu">
	<ul>
       	<li><a href="#">Administrador</a>
        <ul>
            <li><a href="?pac=admin&tela=adminGrid">Listar</a></li>
            <li><a href="?pac=admin&tela=adminForm&op=Inserir">Cadastrar</a></li>
            
          </ul>
        </li>
    	<li><a href="#">Comercial</a>
        <ul>
            <li><a href="?pac=comercial&tela=comercialGrid">Listar</a></li>
            <li><a href="?pac=comercial&tela=comercialForm&op=Inserir">Cadastrar</a></li>
 
          </ul>
        </li>
    	<li><a href="#">Empresa</a>
          <ul>
            <li><a href="?pac=empresa&tela=empresaGrid">Listar</a></li>
            <li><a href="?pac=empresa&tela=empresaForm&op=Inserir">Cadastrar</a></li>
            
          </ul>
        </li>
   	  	<li><a href="#">Ofertas</a>
          <ul>
            <li><a href="?pac=oferta&tela=ofertaGrid">Listar</a></li>
            <li><a href="?pac=oferta&tela=ofertaForm&op=Inserir">Cadastrar</a></li>
            <li><a href="?pac=oferta&tela=Agendar">Agendar</a></li>
            
          </ul>
        </li>
        <li><a href="#">Cliente</a>
         <ul>
            <li><a href="?pac=cliente&tela=clienteGrid">Listar</a></li>
            <li><a href="?pac=exportarEmail&tela=index">Email</a></li>
            <li><a href="?pac=cliente&tela=clienteForm&op=Inserir">Cadastrar</a></li>
 
          </ul>
        
        </li>
    	<li><a href="#">Compradores</a>
         <ul>
         		<li><a href="?pac=vendas&tela=promocoes">Cadastrar</a></li>
         </ul>
        </li>
        <?php if($_SESSION['idAdmin'] == 1 || $_SESSION['idAdmin'] == 2 || $_SESSION['idAdmin'] == 3){?>	
		<li><a href="#">Relat&oacute;rios</a>
			<ul>
				<li>
				<a href="?pac=relatorio&tela=relatorioGrid">Compras</a> 
				</li>
					<li><a href="?pac=relatorio&tela=relatorioFinanceiro">Financeiro</a></li>
					<li><a href="?pac=relatorio&tela=comissao">Comissão</a></li>
			</ul>
		</li>	
	<?php }?>
	<li><a href="#">Agenda hotel</a>
			<ul>
				<li>
				<a href="?pac=agenda&tela=agendaGrid">ver agenda</a> 
				</li>
			</ul>
		</li>	
	<li><a href="#">Links ofertas futuras </a>
			<ul>
				<li>
				<a href="?pac=nextoferta&tela=nextofertaGrid">ver links</a> 
				</li>
			</ul>
		</li>	
     </ul> 
</div> 
<!--fim div menu-->
</div><!-- fim div menucontainer-->

<div id="main">
<?php
$pacote = $login->anti_injection(@$_GET['pac']);
$tela = $login->anti_injection(@$_GET['tela']);
if ( empty($pacote)) {
	$pacote = $login->anti_injection(@$_GET['pac']);
	$tela = $login->anti_injection(@$_GET['tela']);
	if ( empty($pacote)) {
		
		?>
				<div id="botoes-index">
					<div class="btn-index oferta"><a href="?pac=oferta&tela=ofertaForm&op=Inserir"></a></div>
					<div class="btn-index admin"><a href="?pac=admin&tela=adminForm&op=Inserir"></a></div>
					<div class="btn-index empresa"><a href="?pac=empresa&tela=empresaForm&op=Inserir"></a></div>
					<?php if($_SESSION['idAdmin'] == 1 || $_SESSION['idAdmin'] == 2 || $_SESSION['idAdmin'] == 3){?>
					<div class="btn-index financeiro"><a href="?pac=relatorio&tela=relatorioFinanceiro"></a></div>
					<div class="btn-index compras"><a href="?pac=relatorio&tela=relatorioGrid"></a></div>
					<?php } ?>
				</div>
<?php
	}
}
else {

	if (file_exists("view/".$pacote."/".$tela.".php")) {
		include "view/".$pacote."/".$tela.".php";
	}//if
}//else

?>
</div>

</body>
</html>