<?php
session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");
require ("administrator/models/OfertaCliente.php");
require ("administrator/models/Paginacao.php");

$objCliente = new Cliente();
$objofertacliente = new OfertaCliente();
$objOferta = new Oferta();
$objEmpresa = new Empresa();
$id_cupom = $objofertacliente->anti_injection($_GET['id']);
$id_oferta = $objOferta->anti_injection($_GET['id_oferta']);
$listaofertas = $objofertacliente->getOfertaCliente(" and id = ".$id_cupom);
$oferta = $objOferta->getOferta2($id_oferta,"id");
$empresa = $objEmpresa->getEmpresa($oferta['id_empresa'],"id");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Cupom</title>
<link rel="stylesheet" type="text/css" href="css/cupom.css" media="all" />
<script language="JavaScript" type="text/javascript">
  window.print();
</script> 
</head>
<body background="images/marcadagua.jpg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/logo-pro-cupom.png" alt="logo" width="281" height="103" hspace="0" vspace="0" border="0" /></td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td align="right">
    <table width="100%" border="0">
  <tr>
    <td width="50%" valign="top"><p>Estabelecimento: <?php echo $empresa['nome_fantasia']; ?></p>
      <p>Endereço:<?php echo $empresa['endereco'].", ".$empresa['num']." - ".$empresa['bairro']." - ".$empresa['cidade']." - ".$empresa['estado']; ?></p>
<?php 
switch($listaofertas['id_local']){
	case 1:
		$localescolhido = "Shopping tacaruna";
		break;
	case 2:
		$localescolhido = "Shopping plaza";
		break;
	case 3:
		$localescolhido = "Delivery";
		break;
}
if(!empty($listaofertas['id_local'])){?>
<p>Local: <?php echo $localescolhido;?></p>
<?php } ?>
<p>Contato: <?php echo $empresa['fone']; ?></p>
      <p>Produto: <?php echo $oferta['descricao']; ?></p>
<p>Valor Original: R$<?php echo $oferta['valor']; ?></p>
      <p>Valor com Desconto: R$<?php echo $oferta['valorpromocao']; ?></p>
    <p>Validade: <?php echo $objOferta->date_transform($oferta['data_validade']); ?></p></td>
    <td valign="top"><h1>Regras:</h1>
    <?php echo $oferta['regras']; ?> </td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td class="codigo"><p>Nome: <?php echo utf8_encode($listaofertas['nome']);?><br/>
    Código: <?php echo $listaofertas['voucher'];?></p></td>
  </tr>
  <tr>
    <td>   
    </td>
  </tr>
</table>
</body>
</html>