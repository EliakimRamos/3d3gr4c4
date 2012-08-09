<?php 
require_once("../sis/models/Base.php");
require_once("../sis/models/OfertaCliente.php");
	
$id = $_POST['id'];
$pechinchas = new OfertaCliente();

$alterar = $pechinchas->getOfertaCliente($id, "id");
$alterar['ativo'] = 0; 
$pechinchas->editarOfertaCliente($alterar, $id);
?>