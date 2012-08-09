<?php
	$_POST['valor_real'] = str_replace(" ", "",  $_POST['valor_real']);
	$_POST['valor_real'] = str_replace("R$", "", $_POST['valor_real']);
	$_POST['valor_real'] = str_replace(".", "",  $_POST['valor_real']);
	$_POST['valor_real'] = str_replace(",", ".", $_POST['valor_real']);
	
	$_POST['valor_promo'] = str_replace(" ", "",  $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace("R$", "", $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace(".", "",  $_POST['valor_promo']);
	$_POST['valor_promo'] = str_replace(",", ".", $_POST['valor_promo']);
	
	$valorDesconto = $_POST['valor_real'] - $_POST['valor_promo'];
	echo number_format($valorDesconto,2,',','.');
?>