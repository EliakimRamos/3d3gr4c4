<?php
$filename = "email";
  header("Content-Type: application/vnd.ms-excel");
$header="Content-Disposition: attachment; filename=" . $filename . ".csv;";
header($header);

require_once("models/Base.php");
require_once("models/Cliente.php");
$cliente = new Cliente();

$idCidade = $_POST['cidade'];

$cidades = @implode(",",$idCidade);


$resultado = $cliente->ExportarEmail(" and cc.id_cidade in (".$cidades.")");

echo" Email \n";
 foreach($resultado as $dados){
 echo strtolower($dados['email'])."\n";
}//fim Foreach ?>    
