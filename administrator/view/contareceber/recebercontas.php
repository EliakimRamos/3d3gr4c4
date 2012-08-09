<?php
require_once("../../models/Base.php");
require_once("../../models/Contareceber.php");

$contasreceber = new Contareceber();
if(!empty($_POST)){
	$_POST['dia_pagamento'] = date("d/m/Y");
	$contasreceber->editarParcela($_POST, $_POST['id_parcela']);
	if($_POST['id_situacao'] == "4"){
		echo " Paga ";
	}
	if($_POST['id_situacao'] == "5"){
		echo " Cancelada";
	}
}
?>
