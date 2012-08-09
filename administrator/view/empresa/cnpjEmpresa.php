<?php
session_start();
require_once("../../models/Base.php");
require_once("../../models/Empresa.php");

$empresa = new Empresa();
$empresa->conectar();

$cnpj = $empresa->anti_injection($_GET['cnpj']);
if(!empty($_SESSION['idempresa'])){
  $sql = "select * from empresa where cnpj = '".$cnpj."' and id <> ".$_SESSION['idempresa'];
}else{
	$sql = "select * from empresa where cnpj = '".$cnpj."'";
}
$query = mysql_query($sql);
$dados = mysql_fetch_array($query);
if(!empty($dados)){
	echo 'false';
	unset($_SESSION['idempresa']);
}else{
	echo 'true';
	unset($_SESSION['idempresa']);
}
?>