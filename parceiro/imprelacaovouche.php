<?php session_start();

require_once ("../administrator/models/Base.php");
require_once ("../administrator/models/Oferta.php");
require_once ("../administrator/models/Funcoes.php");
require_once ("../administrator/models/Cliente.php");
require_once ("../administrator/models/OfertaCliente.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();
$objCliente = new Cliente();
$pechinchas = new OfertaCliente();

$id = $objCliente->anti_injection($_GET['id']);
$idlocaloferta = $objCliente->anti_injection($_GET['idlocal']);
if(!empty($idlocaloferta) && $idlocaloferta != "-1" ){
	$complementofiltro = " and id_local =".$idlocaloferta;
}else{
	$complementofiltro = "";
}
$resultado = $pechinchas->listarOfertaCliente3("and id_oferta=".$id." and ativo = 1 ".$complementofiltro);
$oferta = $objOferta->getOferta($id, "id");

$total = count($resultado);
?>

<html>
<head>
<?php if(!$_SESSION['empresa']){ ?>
<link rel="stylesheet" type="text/css" media="all" href="../administrator/style/edegraca-sis.css" />
 <?php }else{?>
<link rel="stylesheet" type="text/css" media="all"
	href="../administrator/style/edegraca-sis.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="../administrator/style/ui.tabs.css" />
<link type="text/css" href="../administrator/style/galeria.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" media="all" href="../administrator/style/jScrollPane.css" />
<link type="text/css" href="../administrator/smoothness/jquery-ui-1.8.custom.css" rel="stylesheet" />
<link type="text/css" href="../administrator/style/autocomplete.css" rel="stylesheet" />
<script type="text/javascript"	src="../js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>
<script language="JavaScript" type="text/javascript">
	  $(function(){
		 	window.print();
	 })
</script>

	<title>
		Listagem das ofertas
	</title>
	
<style type="text/css">
.ok { color:#000;}
.usou { background-color:#F00; color: #fff;}
</style>
</head>
<body>

<img src="../imagens/logo_cad.png" width="271" height="100" hspace="20" vspace="20" border="0"><br>
<h3 class="titulo">Listagem de clientes aprovados</h3>

<table class="table_imp" width="100%" >
     <?php 
     if($resultado){?>
<tr class="column1_titulo">
	          <th align="left"><font size="2" face="arial">Cliente</font></th>
    		  <th align="left"><font size="2" face="arial">Cupons</font></th>
   </tr>
     <?php
     	$i = '0'; 
     	foreach ($resultado as $dados) {?>
	     <?php if($i == '0'){?>
	     <tr <?php if($dados['ativo'] == 1){
	     	 echo "class='ok'";
	     }else{
	     	echo "class='usou'";
	     }
	     	?>	     
	     >
	     <?php } ?>
	          <td style="border:1px solid #ffffff; padding:5px; color:#fff;"><?php echo utf8_encode(ucwords(mb_strtolower($dados['nome'])));?></td>
	          <td style="border:1px solid #ffffff; padding:5px; color:#fff;"><?php echo $dados['voucher']?></td>
	          
	   
	     		</tr>
	     <?php
     	}
     	?>
		<tr>
	         	<td colspan="4"><font size="2" face="arial">Total de Clientes: <?php echo $total?></font></td>
     		</tr>
     	<?php }else{?>
     		<tr>
	         	<td colspan="4"><font size="2" face="arial">N�o existe nenhum Cliente nesta promo��o.</font></td>
     		</tr>     	
     	<?php }?>
</table>
<?php } ?>
</body>
</html>