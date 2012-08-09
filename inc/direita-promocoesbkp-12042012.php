<?php
session_start();
$objOferta = new Oferta();
$objCliente = new Cliente();
$objEmpresa = new Empresa();
$datahoje = date("Y-m-d");

	if($_GET['idCidade']){
		$idCidade = $_GET['idCidade'];
	}else{
		if($_COOKIE['idCidade']){
				$idCidade = $_COOKIE['idCidade'];
			}else{
				$idCidade = 1;
			}
	}
	$p = $objOferta->anti_injection($_GET['p']);
	if(empty($p)){
		$p = 0;
	}
	
	$filtro = $idCidade." and o.data_final > ".$datahoje." and o.ativa = 1 and o.destaque = 0 and o.posicao not in (";
	/* ativa diferente do destaque */
	
	if($_SESSION['OfertaAtual'] != 1){		
		
		$aux = $objOferta->listarOferta3($filtro.$p.")");			
		/*$ofertabonus = $aux[0];
		var_dump($aux);*/
	}else{
		
		$aux = $objOferta->listarOferta3($filtro."1)");
		/*var_dump($aux);			
		$ofertabonus = $aux[0];*/
	}
 ?>
 <div id="main-right">
 <h1>Mais Ofertas</h1>
<?php
foreach($aux  as $ofertabonus){
if($ofertabonus){
	++$_SESSION['qtdBonus'] ;
	$ImagemBonus = $objOferta->listarOfertaImagem(" and id_oferta =".$ofertabonus['id']);
	 ?>
<a href="index.php?id=<?php echo $ofertabonus['id']?>&p=<?php echo $ofertabonus['posicao']?>" style="text-decoration:none;">
<div class="promo-right">
  <img src="administrator/uploads/<?php echo $ImagemBonus['0']['image']; ?>" width="207" height="138" alt="01" />
  <div class="precos-lateral">
 		 <div class="transcrito"><span>De:</span>R$ <?php $valor = str_replace(".",",",$ofertabonus["valor"]); echo $valor;?></div>
         <div><span>Por:</span>R$ <?php $valor1 = str_replace(".",",",$ofertabonus["valorpromocao"]); echo $valor1;?></div>
  </div>
  <div class="text-promo-lateral">
  <?php 
          $titulosemspan = str_replace("[span]","",$ofertabonus['titulo']);
  	 	  $titulosemspan = str_replace("[/span]","",$titulosemspan);
  echo substr(utf8_encode($titulosemspan),0,85);?>
  ...</div>
</div>  <!-- promo-right -->
</a>
<?php } 
}?>

</div><!-- fim div main-right-->