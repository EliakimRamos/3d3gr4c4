<?php session_start();
require ("administrator/models/Base.php");
require ("administrator/models/Cliente.php");
require ("administrator/models/Oferta.php");
require ("administrator/models/Empresa.php");

$objOferta = new Oferta();
$objCliente = new Cliente();
$objEmpresa = new Empresa();

$datahoje = date("Y-m-d");

$cliente = $objCliente->getCliente($_SESSION['id'], "id");


if(!empty($_COOKIE['idCidade'])){
	$filtro = $_COOKIE['idCidade']; 
}else{
	$filtro = " 1";
}

$ofertalista = $objOferta->listarOferta3($filtro." and ativa = 1 ");
if(!empty($ofertalista)){
	$respImag = $objOferta->listarOfertaImagem(" and id_oferta=".$ofertalista['0']['id']);
	$empresa = $objEmpresa->getEmpresa($ofertalista['0']['id_empresa'], "id");
	//var_dump($oferta);die;
	$_SESSION['oferta'] = $ofertalista['0']['id'];
	$_SESSION['bonus'] = $ofertabonus['id'];
	//foreach($ofertalista['0'] as $dadosdatak){
	$datafinaloferta =  $ofertalista['0']["data_final"];
	//}
	$dia = substr($datafinaloferta, 8,2);
	$mes = substr($datafinaloferta, 5,2);
	$ano = substr($datafinaloferta, 0,4);
}

function sonumeros($entrada){
	$entrada = str_replace(".", "", $entrada);
	$entrada = str_replace("-", "", $entrada);
	$entrada = str_replace("/", "", $entrada);
	$entrada = str_replace(",", "", $entrada);
	$entrada = str_replace(" ", "", $entrada);

	$saida = $entrada;
	return $saida ;
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
<div class="contorno-full">
<?php if(empty($oferta)){
	 echo"<script>window.location='cadastro.php';</script>";
}else{
foreach($ofertalista as $dados){
?>
<div class="promo-lista">
  <?php if($dados){
		$foto = $objOferta->listarOfertaImagem(" and id_oferta=".$dados['id']);?>
	 	<a style="text-decoration:none;" href="index.php?id=<?php echo $dados['id']?>">
	    <img src="administrator/uploads/<?php echo $foto['0']['image']?>" width="207" height="138" alt="01"/>
	    </a>
	<?php } ?>
   <div class="precos-lateral">
 		 <div class="transcrito">
		<?php 
    	$dados['valor']	= str_replace(".", ",", $dados['valor']);
		$valor = explode(",", $dados['valor']);
		$inteiro = $valor[0];
		$decimal = $valor[1];
	  ?>	 	
     <span>De:</span>R$ <?php echo $inteiro;?>,<?php echo $decimal ?> 		 
  </div>
     <div>
     <?php 
        	$dados['valorpromocao']	= str_replace(".", ",", $dados['valorpromocao']);
    		$valor = explode(",", $dados['valorpromocao']);
    		
    		$inteiro = $valor[0];
    		$decimal = $valor[1];
    		?>
   		 	<span>Por:</span>R$ <?php echo $inteiro ?>,<?php echo $decimal ?>
     </div>
  </div>
  <div class="text-promo-lateral">
  	<?php $titulosemspan = str_replace("[span]","",$dados['titulo']);
  	 	  $titulosemspan = str_replace("[/span]","",$titulosemspan);
  	echo utf8_encode(substr($titulosemspan,0,100))."..."?>
  </div>
  <div class="btn-comprar-menor"><a href="index.php?id=<?php echo $dados['id']?>"></a></div>
  
</div>
<?php }
}
?>
</div><!--fim div contorno-full -->


</div><!-- fim div main-->
<?php include('inc/footer.php'); ?> 



</body>
</html>