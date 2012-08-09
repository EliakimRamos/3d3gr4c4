<?php session_start();

require_once ("../../models/Base.php");
require_once ("../../models/Oferta.php");
require_once ("../../models/Funcoes.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();

$id_oferta = $objOferta->anti_injection($_POST['id']);

$ofertaAtual = $objOferta->getOferta($id_oferta, "id");
$ofertaAtual['data_inicio'] = $objFuncao->formata_data_BR($ofertaAtual['data_inicio']);
$ofertaAtual['data_final'] =  $objFuncao->formata_data_BR($ofertaAtual['data_final']);
$ofertaAtual['data_validade'] = $objFuncao->formata_data_BR($ofertaAtual['data_validade']); 
$ofertaAtual['agendado'] = 0;
$ofertaAtual['novaposicao'] = "";
$ofertaAtual['data_agendamento'] = "";

$objOferta->editarOferta($ofertaAtual, $id_oferta);
?>