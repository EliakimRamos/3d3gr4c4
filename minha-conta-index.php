<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");
require ("administrator/models/OfertaCliente.php");

if(!$_SESSION['cliente']){
	echo"<script>window.location='login.php'</script>";
	die;
}
$objCliente = new Cliente();
$objofertacliente = new OfertaCliente();
$objOferta = new Oferta();
$cliente = $objCliente->getCliente($_SESSION['idclientek'],'id');
$qtdCupons = $objCliente->getqtdCupons($_SESSION['idclientek']);
$listaofertas = $objofertacliente->listarOfertaCliente2(" and id_cliente=".$_SESSION['idclientek']." and comprou <> 0");
$totaleconomizado = 0;
					if(!empty($listaofertas)){
						foreach ($listaofertas as $dados1){	
							if($dados1['comprou'] == 1 && $dados1['ativo'] == 1){		
							 	$valordesconto = $objOferta->getOferta($dados1['id_oferta'],"id");
							 	$totaleconomizado = $totaleconomizado + $valordesconto['valordesconto'];
							}	
						}
					}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('inc/header.php'); ?>
</head>

<body>
<?php include('inc/topo.php'); ?>
<div id="main">
<div id="main-left">
	
    <?php $menu = "inicio"  ?>
   <?php include('inc/menu-minhaconta.php'); ?>
   
    <div class="contorno-meio">
    <h4>Histórico da Conta</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="historico_conta">
  <tr>
    <td><span class="bemvindo">Bem Vindo:</span> </td>
    <td class="td-center"><span>Cupons Comprados:</span></td>
    <td class="td-center"><span>Você já economizou:</span></td>
  </tr>
  <tr>
    <td><?php echo utf8_encode($cliente['nome']);?></td>
    <td class="td-center"><?php echo $qtdCupons->qtd; ?> </td>
    <td class="td-center">R$ <?php echo $totaleconomizado; ?></td>
  </tr>
</table>
	</div>
</div> <!-- fim div main-left-->
<?php include('inc/direita-promocoes.php'); ?>
</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 
</body>
</html>