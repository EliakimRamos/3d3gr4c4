<?php session_start();

require_once ("../../models/Base.php");
require_once ("../../models/Oferta.php");
require_once ("../../models/Funcoes.php");

$objOferta = new Oferta();
$objFuncao = new Funcoes();

$id_oferta = $objFuncao->anti_injection($_POST['id']);
$nova_posicao = $objFuncao->anti_injection($_POST['posicao']);
$data_agendamento = $objFuncao->anti_injection( $_POST['data']);

$ofertaAtual = $objOferta->getOferta($id_oferta, "id");
$ofertaAtual['data_inicio'] = $objFuncao->formata_data_BR($ofertaAtual['data_inicio']);
$ofertaAtual['data_final'] = $objFuncao->formata_data_BR($ofertaAtual['data_final']);
$ofertaAtual['data_validade'] = $objFuncao->formata_data_BR($ofertaAtual['data_validade']); 
$ofertaAtual['agendado'] = 1;
$ofertaAtual['novaposicao'] = $nova_posicao;
$ofertaAtual['data_agendamento'] = $data_agendamento;

$objOferta->editarOferta($ofertaAtual, $id_oferta);

?>