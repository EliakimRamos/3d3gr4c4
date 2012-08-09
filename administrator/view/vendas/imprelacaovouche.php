<?php session_start();

require ("../../models/Base.php");
require ("../../models/Oferta.php");
require ("../../models/Funcoes.php");
require ("../../models/Cliente.php");
require ("../../models/OfertaCliente.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();
$objCliente = new Cliente();
$pechinchas = new OfertaCliente();

$id = $objCliente->anti_injection($_GET['id']);
$resultado = $pechinchas->listarOfertaCliente3("and id_oferta=".$id." and ativo > 0 ");
$oferta = $objOferta->getOferta($id, "id");

$total = count($resultado);
?>

<html>
<head>

<link rel="stylesheet" type="text/css" media="all" href="../../style/css_page.css" />
<link rel="stylesheet" type="text/css" media="all" href="../../style/ui.tabs.css" />
<link type="text/css"  rel="stylesheet" href="../../style/galeria.css" />
<link type="text/css"  rel="stylesheet" href="../../smoothness/jquery-ui-1.8.custom.css" />
<link type="text/css"  rel="stylesheet" href="../../style/autocomplete.css" />
<script type="text/javascript"	src="../../js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>

<script language="JavaScript" type="text/javascript">
	  $(function(){
		 	window.print();
	 })
</script>

<title>
	Listagem dos Clientes
</title>
	
<style type="text/css">
.ok {
	color: #000;
}

.usou {
	background-color: #F00;
	color: #fff;
}

#topo {
	margin: 0 auto;
	text-align: center;
}
</style>
</head>
<body>

	<div id="topo">
		<img src="../../../imagens/logo_cad.png" width="271" height="100" hspace="20" vspace="20" border="0"><br>
		<h2 class="titulo">Listagem de Clientes Aprovados</h2>
		<h3>
			 Oferta:<?php echo $oferta['titulo']?>
		</h3>
	</div>


<table class="table" width="60%" align="center">
     <?php 
     if($resultado){?>
<tr class="column1_titulo">
	<th align="left">Cliente</th>
    <th>Cupons</th>
    <th>Utilizou</th>
	     </tr>
     <?php foreach ($resultado as $dados) {?>
	     <tr <?php if($dados['ativo'] == 1){
	     	 echo "class='ok'";
	     }else{
	     	echo "class='usou'";
	     }
	     	?>	     
	     >
	          <td align="left"><font size="2" face="arial"><?php echo ucwords(mb_strtolower($dados['nome']));?></font></td>
	          <td align="center"><font size="2" face="arial"><?php echo $dados['voucher']?></font></td>
	          <td align="center">
	          	<?php if($dados['ativo'] == 1){
	          		echo "Cupom Ativo !";
	          	}?>	          
	          
	          	<?php if($dados['ativo'] == 2){?>
	          		<font size="2" face="arial"><?php echo $objOferta->date_transform($dados['data'])?></font>
	          	<?php }?>
	          </td>
	     </tr>
      <?php } ?>
     		<tr>
	         	<td colspan="4" align="right"><font size="2" face="arial"> <strong>Total de Clientes: <?php echo $total?></strong></font></td>
     		</tr>
     	<?php }else{?>
     		<tr>
	         	<td colspan="4"><font size="2" face="arial">Não existe nenhum Cliente nesta promoção.</font></td>
     		</tr>     	
     	<?php }?>
</table>
</body>
</html>