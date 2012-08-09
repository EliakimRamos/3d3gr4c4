<?php 
require_once("../administrator/models/Base.php");
require_once("../administrator/models/OfertaCliente.php");

$pechinchas = new OfertaCliente();

$id = $pechinchas->anti_injection($_POST['id']);
$alterar['ativo'] = 2;
$alterar['data'] = date("d/m/Y");
 
$pechinchas->editarOfertaCliente($alterar, $id);
echo "Cupom alterado !";
?>