<?php
	$_POST['valor'] = str_replace(" ", "", $_POST['valor']);
	$_POST['valor'] = str_replace("R$", "", $_POST['valor']);
	$_POST['valor'] = str_replace(".", "", $_POST['valor']);
	$_POST['valor'] = str_replace(",", ".", $_POST['valor']);

		
	$_POST['valor_promo'] = str_replace(" ", "", $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace("R$", "", $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace(".", "", $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace(",", ".", $_POST['valor_promo']);	
	
	$valor = $_POST['valor'];
	$valor_promo = $_POST['valor_promo'];
	
	$umPorcento = ($valor / 100);
	$Desconto = 100 - ($valor_promo / $umPorcento);
	
	echo number_format($Desconto,2,',','.');
?>