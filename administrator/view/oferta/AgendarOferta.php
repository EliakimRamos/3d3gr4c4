<?php session_start();
require_once("../../models/Base.php");
require_once("../../models/Oferta.php");
require_once("../../models/Funcoes.php");


$objOferta = new Oferta();
$objFuncoes = new Funcoes();
$id_oferta = $objOferta->anti_injection($_POST['id']);
$acharOferta = $objOferta->getOferta2($id_oferta, "id");

if($acharOferta){ 
	
	$_SESSION['data_final'] = $acharOferta['data_final'] ; 
	$acharOferta['data_final'] = date("d/m/Y");
	
	/* para não perder as outras datas */
	$acharOferta['data_inicio'] = $objFuncoes->formata_data_BR($acharOferta['data_inicio']);
	$acharOferta['data_validade'] = $objFuncoes->formata_data_BR($acharOferta['data_validade']);
	
	
	if($acharOferta['agendado'] == 0){
		$acharOferta['agendado'] = 1;
	}else{
		$acharOferta['agendado'] = 0;
		if($_SESSION['data_final']){
			$acharOferta['data_final'] = $_SESSION['data_final'];
		}
	}
	$objOferta->editarOferta($acharOferta, $id_oferta);
}

?>