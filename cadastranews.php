<?php
require_once('administrator/models/Base.php');
require_once('administrator/models/Cliente.php');
$objCliente = new Cliente();
$retorno = $objCliente->cadastranews($_POST);
if($retorno){
	echo true;
}else{
	echo"false";
}

?>
