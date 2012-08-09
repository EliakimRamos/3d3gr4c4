<?php
session_start();

require_once("../models/Base.php");
require_once("../models/Login.php");
require_once("../models/Administrador.php");
require_once("../models/Cliente.php");

$login = new Login();
$cliente = new Cliente();
$administrador = new Administrador();

$user = $login->anti_injection($_POST['email']);
$pass = $login->anti_injection($_POST['senha']);

$tabela = "cliente";

$retorno = $login->Logar($user,$pass,$tabela);

if($retorno){
	$_SESSION['user'] = "logado";
	$_SESSION['cliente'] = true;
	$_SESSION['nome'] = $retorno['nome'];
	$_SESSION['id'] = $retorno['id'];
	$_SESSION['saldo'] = $retorno['saldo'];
	$_SESSION['email'] = $retorno['email'];	
	$login->loglogin($_SESSION['id'],"1");
}else{
	$_SESSION['erro'] = "Usu&aacute;rio ou Senha Inv&aacute;lidos";
	echo "Usu&aacute;rio ou Senha Inv&aacute;lidos";
	exit;
}
?>
