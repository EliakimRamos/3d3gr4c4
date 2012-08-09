<?php
	$_POST['valor'] = str_replace(" ", "", $_POST['valor']);
	$_POST['valor'] = str_replace("R$", "", $_POST['valor']);
	$_POST['valor'] = str_replace(".", "", $_POST['valor']);
	$_POST['valor'] = str_replace(",", ".", $_POST['valor']);	
	
	$valor = $_POST['valor'];
	$desconto = $_POST['desconto'];
	
	$valorDesconto = ($valor / 100) * $desconto; 
	$valorPromo = $valor - $valorDesconto;
	
	//echo "R$ ". number_format($valorPromo,2,',','.');
	echo number_format($valorPromo,2,',','.');
?>