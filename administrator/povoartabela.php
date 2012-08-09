<?php
require_once('models/Base.php');
require_once('models/Oferta.php');
require_once('models/CidadesOferta.php');

$objOferta = new Oferta();
$objCidades = new CidadesOferta();

$dados = $objOferta->listarOferta2('');

foreach($dados as $restDados){
	$post['id_oferta'] = $restDados['id'];
	$post['id_cidade'] = 1;
	
	$objCidades->inserirEdegracaCidade($post);
}
?>
